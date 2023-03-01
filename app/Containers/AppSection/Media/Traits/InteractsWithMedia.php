<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Traits;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\InteractsWithMedia as BaseInteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\FileAdder;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 *  @property MediaCollection $media
 */
trait InteractsWithMedia
{
    use BaseInteractsWithMedia {
        BaseInteractsWithMedia::addMedia as baseAddMedia;

    }

    /**
     * Add a file to the media library.
     *
     * @psalm-param string|UploadedFile $file
     */
    public function addMedia($file): FileAdder
    {
        return $this
            ->baseAddMedia($file)
            ->sanitizingFileName(function (string $fileName): string {
                $name = pathinfo($fileName, PATHINFO_FILENAME);
                $name = static::replaceNumbers($name);

                $ext  = pathinfo($fileName, PATHINFO_EXTENSION);

                return sprintf('%s.%s', Str::slug($name), $ext);
            });
    }

    public static function replaceNumbers(string $string): string
    {
        $newNumbers = range(0, 9);

        // 1. Persian HTML decimal
        $persianDecimal = [
            '&#1776;',
            '&#1777;',
            '&#1778;',
            '&#1779;',
            '&#1780;',
            '&#1781;',
            '&#1782;',
            '&#1783;',
            '&#1784;',
            '&#1785;',
        ];
        // 2. Arabic HTML decimal
        $arabicDecimal = [
            '&#1632;',
            '&#1633;',
            '&#1634;',
            '&#1635;',
            '&#1636;',
            '&#1637;',
            '&#1638;',
            '&#1639;',
            '&#1640;',
            '&#1641;',
        ];
        // 3. Arabic Numeric
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        // 4. Persian Numeric
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

        $string = str_replace($persianDecimal, $newNumbers, $string);
        $string = str_replace($arabicDecimal, $newNumbers, $string);
        $string = str_replace($arabic, $newNumbers, $string);

        return str_replace($persian, $newNumbers, $string);
    }
}
