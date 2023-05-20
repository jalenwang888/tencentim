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

use Hyperf\Contract\ConfigInterface;
use Psr\Container\ContainerInterface;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                IM::class => static function (ContainerInterface $container) {
                    return new IM($container->get(ConfigInterface::class)->get('im', []));
                },
            ],
            'publish' => [
                [
                    'id'          => 'config',
                    'description' => 'The config for im.',
                    'source'      => __DIR__.'/Config/im.php',
                    'destination' => BASE_PATH.'/config/autoload/im.php',
                ],
            ],
        ];
    }
}
