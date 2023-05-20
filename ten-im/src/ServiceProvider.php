<?php

/*
 * This file is part of the tencentim/ten-im.
 *
 * (c) tencentim<hata@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tencentim\TenIM;

/***
 * Class ServiceProvider
 *
 * @package Tencentim\TenIM
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    public function boot()
    {
        $this->publishes([
            __DIR__.'/Config/im.php' => config_path('im.php'),
        ]);
    }

    public function register()
    {
        $this->app->singleton(IM::class, function () {
            return new IM(config('im'));
        });

        $this->app->alias(IM::class, 'im');
    }

    /***
     * @return string[]
     */
    public function provides(): array
    {
        return [IM::class, 'im'];
    }
}
