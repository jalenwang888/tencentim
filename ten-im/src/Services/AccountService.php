<?php
/**
 * AccountService.php
 *
 * @copyright  2021 opencart.cn - All Rights Reserved
 * @link       http://www.guangdawangluo.com
 * @author     Sam Chen <sam.chen@opencart.cn>
 * @created    2021-12-24 18:25:41
 * @modified   2021-12-24 18:25:41
 */

namespace Tencentim\TenIM\Services;

class AccountService extends BaseService
{
    /**
     * 创建用户
     * https://cloud.tencent.com/document/product/269/1608
     * @param $account
     * @return bool
     */
    public function add($account): bool
    {
        $res = $this->client->post('v4/im_open_login_svc/account_import', [
            'query' => $this->getQueries(),
            'json' => [
                'Identifier' => $account,
                // 'Nick' => '',
                // 'FaceUrl' => '',
            ],
        ]);

        $json = (string)$res->getBody();
        $json = json_decode($json, true);
        if ($json['ActionStatus'] == 'OK') {
            return true;
        }

        throw new \Exception($json['ErrorInfo']);
    }

    /**
     * 设置用户资料
     * @param string $account
     * @param array $items
     * @return bool
     */
    public function setProfile(string $account, array $items)
    {
        $res = $this->client->post('v4/profile/portrait_set', [
            'query' => $this->getQueries(),
            'json' => [
                'From_Account' => $account,
                'ProfileItem' => $items,
            ],
        ]);

        $json = (string)$res->getBody();
        $json = json_decode($json, true);
        if ($json['ActionStatus'] == 'OK') {
            return true;
        }

        throw new \Exception($json['ErrorInfo']);
    }

    /**
     * 查询帐号
     * https://cloud.tencent.com/document/product/269/38417
     * @param $account
     * @return array
     */
    public function getProfile($account): array
    {
        $res = $this->client->post('v4/profile/portrait_get', [
            'query' => $this->getQueries(),
            'json' => [
                'To_Account' => [$account],
                'TagList' => [
                    'Tag_Profile_IM_Nick',
                    'Tag_Profile_Custom_Account',
                ],
            ],
        ]);

        $json = (string)$res->getBody();
        $json = json_decode($json, true);

        if ($json['ActionStatus'] != 'OK') {
            throw new \Exception($json['ErrorInfo'], $json['ErrorCode']);
        }

        return $json['UserProfileItem'][0]['ProfileItem'];
    }
}
