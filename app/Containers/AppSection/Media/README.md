### Media Apiato Container

This package used to upload files using [Spatie Media Library](https://spatie.be/docs/laravel-medialibrary/)  
Inspired by [Laravel Media Uploader](https://github.com/ahmed-aliraqi/laravel-media-uploader/)

#### Requirements
- PHP >= 8.0
- You should be ensured that the [ffmpeg](https://ffmpeg.org) was installed on your server

> Implement`HasInteractsWithMedia` interface and use `InteractsWithMedia` trait in your model:

```php
<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Sample\Models;

use App\Containers\AppSection\Media\Contracts\HasInteractsWithMedia;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Traits\InteractsWithMedia;
use App\Ship\Parents\Models\Model;

class Sample extends Model implements HasInteractsWithMedia
{
    use InteractsWithMedia;

    public function getAuthorId() : ?int
    {
     // TODO: Implement getAuthorId() method.
    }

    public function getCollection() : string
    {
     // TODO: Implement getCollection() method.
    }

    // You can add your own Collection with additional configuration
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(MediaCollectionEnum::DEFAULT)->singleFile();
    }
}
```

> Add MediaAttributesValidationRulesMergerTask DI to your Request:

```php
<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Sample\UI\API\Requests;

use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Tasks\MediaAttributesValidationRulesMergerTask;
use App\Ship\Parents\Requests\Request;

class UpdateSampleRequest extends Request
{
    // ...

    public function rules(MediaAttributesValidationRulesMergerTask $merger): array
    {
        $rules = [
            'id'       => 'required|exists:users,id',
            'username' => 'string|min:2|max:100|unique:users,username',
        ];

        return $merger
            ->setAllowedCollectionTypes([MediaCollectionEnum::DEFAULT])
            ->run($rules);
    }
}
```

> Add AttachMediaParametersToTransporter trait to your DTO Transporter:

```php
<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Sample\Data\Transporters;

use App\Containers\AppSection\Media\Traits\AttachMediaParametersToTransporter;
use App\Ship\Parents\Transporters\Transporter;

class UpdateSampleTransporter extends Transporter
{
    use AttachMediaParametersToTransporter;
    
    public int $id;

    public ?string $sample_name;
}
```

> If you add new collection type, you need add it to enum configuration to ```MediaCollectionEnum::class```
