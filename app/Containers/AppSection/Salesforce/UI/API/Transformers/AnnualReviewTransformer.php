<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\API\Transformers;

use App\Containers\AppSection\Salesforce\Models\SalesforceAnnualReview;
use App\Ship\Parents\Transformers\Transformer;

class AnnualReviewTransformer extends Transformer
{
    public function transform(SalesforceAnnualReview $annualReview): array
    {
        return [
            'id'          => $annualReview->getHashedKey(),
            'name'        => $annualReview->name,
            'review_date' => $annualReview->review_date?->format('Y-m-d'),
            'amount'      => $annualReview->amount,
            'type'        => $annualReview->type,
            'new_money'   => $annualReview->new_money,
            'notes'       => $annualReview->notes,

        ];
    }
}
