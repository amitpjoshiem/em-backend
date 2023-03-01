<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Services\Objects;

use App\Containers\AppSection\Salesforce\Exceptions\ExportExceptions\ApiRequestException;
use App\Containers\AppSection\Salesforce\Exceptions\ExportExceptions\OwnerNotExistException;
use App\Containers\AppSection\Salesforce\Exceptions\ExportExceptions\SalesforceAuthException;
use App\Containers\AppSection\Salesforce\Exceptions\SalesforceFindException;
use App\Containers\AppSection\Salesforce\Exceptions\SalesforceObjectIdException;
use App\Containers\AppSection\Salesforce\Exceptions\SalesforceServiceModelException;
use App\Containers\AppSection\Salesforce\Models\SalesforceObjectInterface;
use App\Containers\AppSection\Salesforce\SubActions\ManageExportExceptionsSubAction;
use App\Containers\AppSection\Salesforce\Tasks\CreateSalesforceExportTask;
use App\Ship\Parents\Models\Model;
use Carbon\CarbonImmutable;
use Exception;
use JsonException;

abstract class AbstractObject extends Api
{
    /**
     * @var string
     */
    public const CREATE = 'create';

    /**
     * @var string
     */
    public const UPDATE = 'update';

    /**
     * @var string
     */
    public const DELETE = 'delete';

    abstract public function getModel(): ?Model;

    abstract public function getCustomFields(): array;

    protected function getStrictlyModel(): Model
    {
        $model = $this->getModel();

        if ($model === null) {
            throw new SalesforceServiceModelException();
        }

        return $model;
    }

    protected function saveSalesforceId(string $salesforceId): void
    {
        $this->getStrictlyModel()->update([
            'salesforce_id' => $salesforceId,
        ]);
    }

    protected function getObjectData(bool $isUpdate = false): array
    {
        /** @var SalesforceObjectInterface $model */
        $model = $this->getStrictlyModel();

        return $model::prepareSalesforceData($model->getKey(), $isUpdate);
    }

    public function create(): bool
    {
        try {
            $salesforceId = $this->createObject($this->getObjectData());
            $this->saveSalesforceId($salesforceId);
        } catch (Exception $exception) {
            return $this->handleApiException($exception, self::CREATE);
        }

        return true;
    }

    public function update(): bool
    {
        try {
            $this->updateObject($this->getStrictSalesforceId(), $this->getObjectData(true));
        } catch (Exception $exception) {
            return $this->handleApiException($exception, self::UPDATE);
        }

        return true;
    }

    public function delete(): bool
    {
        try {
            $this->deleteObject($this->getStrictSalesforceId());
        } catch (Exception $exception) {
            return $this->handleApiException($exception, self::DELETE);
        }

        return true;
    }

    /**
     * @throws SalesforceFindException
     * @throws JsonException
     */
    public function find(): array
    {
        return $this->getObjectById($this->getStrictSalesforceId());
    }

    /**
     * @throws SalesforceFindException
     * @throws JsonException
     */
    public function findById(string $salesforceId): array
    {
        return $this->getObjectById($salesforceId);
    }

    public function getUpdated(CarbonImmutable $startDate, CarbonImmutable $endDate): array
    {
        return $this->getUpdatedObjects($startDate, $endDate);
    }

    public function getDeleted(CarbonImmutable $startDate, CarbonImmutable $endDate): array
    {
        return $this->getDeletedObjects($startDate, $endDate);
    }

    public function findAll(array $salesforceIds): array
    {
        $object             = $this->getObjectName();
        $query              = 'SELECT FIELDS(ALL) FROM ' . $object . " WHERE Id IN ('" . implode("', '", $salesforceIds) . "')";
        $childOpportunities = $this->queryAll($query);

        return $childOpportunities['records'];
    }

    protected function getDescribeValuesByLabel(string $label): array
    {
        $describe = $this->describeObject();
        $values   = [];
        foreach ($describe['fields'] as $field) {
            if ($field['label'] === $label) {
                foreach ($field['picklistValues'] as $picklistValue) {
                    $values[] = $picklistValue['label'];
                }

                break;
            }
        }

        return $values;
    }

    protected function getStrictSalesforceId(): string
    {
        /** @var SalesforceObjectInterface $model */
        $model = $this->getStrictlyModel();

        $salesforceId = $model->getSalesforceId();

        if ($salesforceId === null) {
            throw new SalesforceObjectIdException();
        }

        return $salesforceId;
    }

    public function globalImport(): array
    {
        $customFields = $this->getCustomFields();

        $fields = $customFields !== [] ? sprintf(', %s', implode(', ', $customFields)) : '';

        $query = sprintf('SELECT FIELDS(STANDARD)%s FROM %s', $fields, $this->getObjectName());

        return $this->queryAll($query);
    }

    protected function saveExport(string $action, ?string $salesforce_id = null): void
    {
        /** @var SalesforceObjectInterface $model */
        $model = $this->getStrictlyModel();

        app(CreateSalesforceExportTask::class)->run(
            $model->getKey(),
            $model::class,
            $action,
            $salesforce_id
        );
    }

    public function handleApiException(Exception $e, string $action): bool
    {
        app(ManageExportExceptionsSubAction::class)->run($e, $this->getModel()::class, $this->getStrictlyModel()->getKey(), $action);

        if ($e instanceof ApiRequestException) {
            return !$e->isAuth;
        }

        return $e instanceof SalesforceAuthException || $e instanceof OwnerNotExistException;
    }
}
