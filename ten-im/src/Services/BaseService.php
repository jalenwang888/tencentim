<?php
/**
 * BaseService.php
 *
 * @copyright  2021 opencart.cn - All Rights Reserved
 * @link       http://www.guangdawangluo.com
 * @author     Sam Chen <sam.chen@opencart.cn>
 * @created    2021-12-24 18:24:23
 * @modified   2021-12-24 18:24:23
 */

namespace Tencentim\TenIM\Services;

use GuzzleHttp\Client;
use Tencent\TLSSigAPIv2;

/**
 * https://cloud.tencent.com/document/product/269/3662
 */
abstract class BaseService
{
    protected $client;
    protected $signature;
    protected $appId;
    protected $appKey;

    public function __construct()
    {
        $this->appId = config('tim.appid');
        $this->appKey = config('tim.key');

        $this->client = new Client([
            'base_uri' => 'https://console.tim.qq.com/',
        ]);

        $this->getSignature(config('tim.identifier'));
    }

    public function getSignature($account): string
    {
        $api = new TLSSigAPIv2($this->appId, $this->appKey);
        $this->signature = $api->genUserSig($account);
        return $this->signature;
    }

    protected function getQueries(): array
    {
        return [
            'sdkappid' => config('tim.appid'),
            'identifier' => config('tim.identifier'),
            'usersig' => $this->signature,
            'random' => time(),
            'contenttype' => 'json',
        ];
    }
}
