<?php
/**
 * Created by PhpStorm.
 * User: rolando.caldas
 * Date: 25/10/2018
 * Time: 12:45
 */

namespace Domain\ValueObject;

class Thumbnail implements \JsonSerializable
{
    const PORTRAIT = '/portrait_fantastic.';
    const PORTRAIT_FULL = '/portrait_uncanny.';
    const STANDARD = '/standard_medium.';
    const STANDARD_FULL = '/standard_fantastic.';
    const LANDSCAPE = '/landscape_medium.';
    const LANDSCAPE_FULL = '/landscape_incredible.';
    const FULL = '.';

    private $path;
    private $extension;

    public function __construct(string $path, string $extension)
    {
        $this->path = $path;
        $this->extension = $extension;
    }

    public function image(string $ratio = self::FULL)
    {
        return $this->path . $ratio . $this->extension;
    }

    public function jsonSerialize()
    {
        return [
            'path' => $this->path,
            'extension' => $this->extension,
            'size' => [
                'portrait' => self::PORTRAIT,
                'portrait_full' => self::PORTRAIT_FULL,
                'standard' => self::STANDARD,
                'standard_full' => self::STANDARD_FULL,
                'landscape' => self::LANDSCAPE,
                'landscape_full' => self::LANDSCAPE_FULL,
                'full' => self::FULL,
            ],
        ];
    }
}