<?php

/*
 * This file is part of the tencentim/ten-im.
 *
 * (c) tencentim<hata@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tencentim\TenIM\Facades;

use Illuminate\Support\Facades\Facade;

/****
 * Class IM
 *
 * @package Tencentim\TenIM\Facades
 */
class IM extends Facade
{
    /**
     * Return the facade accessor.
     *
     * @return string
     */
    public static function getFacadeAccessor(): string
    {
        return 'im';
    }

    /**
     * Return the facade accessor.
     *
     * @return \Tencentim\TenIM\IM
     */
    public static function im(): \Tencentim\TenIM\IM
    {
        return app('im');
    }
}
