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

interface IMInterface
{
    public function send(string $servername, string $command, array $params = []): array;
}
