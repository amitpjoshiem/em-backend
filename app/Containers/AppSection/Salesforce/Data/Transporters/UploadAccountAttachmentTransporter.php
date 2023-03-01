<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class UploadAccountAttachmentTransporter extends Transporter
{
    public int $member_id;

    public int $media_id;

    public ?string $custom_name = null;
}
