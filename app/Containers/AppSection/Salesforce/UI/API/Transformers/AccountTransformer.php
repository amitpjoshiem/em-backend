<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\API\Transformers;

use App\Containers\AppSection\Salesforce\Models\SalesforceAccount;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Primitive;
use stdClass;

class AccountTransformer extends Transformer
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [
        'opportunity',
        'annualReviews',
    ];

    public function transform(SalesforceAccount $account): array
    {
        return [
            'do_not_mail'           => $account->do_not_mail,
            'category'              => $account->category,
            'client_start_date'     => $account->client_start_date,
            'client_ar_date'        => $account->client_ar_date,
            'p_c_client'            => $account->p_c_client,
            'tax_conversion_client' => $account->tax_conversion_client,
            'platinum_club_client'  => $account->platinum_club_client,
            'medicare_client'       => $account->medicare_client,
            'household_value'       => $account->household_value,
            'total_investment_size' => $account->total_investment_size,
            'political_stance'      => $account->political_stance,
            'client_average_age'    => $account->client_average_age,
            'primary_contact'       => $account->primary_contact,
            'military_veteran'      => $account->military_veteran,
            'homework_completed'    => $account->homework_completed,
        ];
    }

    public function includeOpportunity(SalesforceAccount $account): Item | Primitive
    {
        if ($account->opportunity === null) {
            return $this->primitive(new stdClass());
        }

        return $this->item($account->opportunity, new OpportunityTransformer());
    }

    public function includeAnnualReviews(SalesforceAccount $account): Collection
    {
        return $this->collection($account->annualReviews, new AnnualReviewTransformer(), 'annualReviews');
    }
}
