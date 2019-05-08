<?php

namespace DavideCasiraghi\LaravelSmartBlog;

use Illuminate\Support\Facades\Facade;

/**
 * @see \DavideCasiraghi\LaravelSmartBlog\Skeleton\SkeletonClass
 */
class LaravelSmartBlog extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-smart-blog';
    }
}
