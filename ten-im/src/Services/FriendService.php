<?php
/**
 * FriendService.php
 *
 * @copyright  2022 opencart.cn - All Rights Reserved
 * @link       http://www.guangdawangluo.com
 * @author     Sam Chen <sam.chen@opencart.cn>
 * @created    2022-02-28 11:09:20
 * @modified   2022-02-28 11:09:20
 */

namespace Tencentim\TenIM\Services;


class FriendService extends BaseService
{
    public function add(string $fromTimUserId, array $toTimUserIds)
    {
        $friends = [];
        foreach ($toTimUserIds as $toTimUserId) {
            $friends[] = [
                'To_Account' => $toTimUserId,
                'AddSource' => 'AddSource_Type_Web',
            ];
        }

        $res = $this->client->post('v4/sns/friend_add', [
            'query' => $this->getQueries(),
            'json' => [
                'From_Account' => $fromTimUserId,
                'AddFriendItem' => $friends,
                // 'AddType' => 'Add_Type_Both',
                'ForceAddFlags' => 1,
            ],
        ]);

        $json = (string)$res->getBody();
        $json = json_decode($json, true);
        if ($json['ActionStatus'] == 'OK') {
            return true;
        }

        throw new \Exception($json['ErrorInfo']);
    }

    public function deleteAll(string $timUserId)
    {
        $res = $this->client->post('v4/sns/friend_delete_all', [
            'query' => $this->getQueries(),
            'json' => [
                'From_Account' => $timUserId,
            ],
        ]);

        $json = (string)$res->getBody();
        $json = json_decode($json, true);
        return $json['ActionStatus'] == 'OK';
    }
}
