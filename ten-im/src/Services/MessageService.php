<?php
/**
 * MessageService.php
 *
 * @copyright  2021 opencart.cn - All Rights Reserved
 * @link       http://www.guangdawangluo.com
 * @author     Sam Chen <sam.chen@opencart.cn>
 * @created    2021-12-24 18:25:58
 * @modified   2021-12-24 18:25:58
 */

namespace Tencentim\TenIM\Services;

use Illuminate\Support\Facades\Log;

/**
 * 消息相关
 * Class MessageService
 * https://cloud.tencent.com/document/product/269/2282
 */

class MessageService extends BaseService
{
    /**
     * 未读消息数
     * @param $account
     * @return int|mixed
     */
    public function unread($account)
    {
        $res = $this->client->post('v4/openim/get_c2c_unread_msg_num', [
            'query' => $this->getQueries(),
            'json' => [
                'To_Account' => $account,
            ],
        ]);

        $json = (string)$res->getBody();
        $json = json_decode($json, true);
        return $json['AllC2CUnreadMsgNum'] ?? 0;
    }

    /**
     * 发送消息
     * https://cloud.tencent.com/document/product/269/2720#.E6.96.87.E6.9C.AC.E6.B6.88.E6.81.AF.E5.85.83.E7.B4.A0
     */
    public function send($message)
    {
        $json = [
            'SyncOtherMachine' => $message->syncOtherMachine,
            'From_Account' => $message->from,
            'To_Account' => $message->to,
            'MsgLifeTime' => 60 * 60 * 24 * 7,
            // 'MsgSeq' => time(),
            'MsgRandom' => time(),
            // 'MsgTimeStamp' => time(),
            'MsgBody' => [
                [
                    "MsgType" => $message->type,
                    "MsgContent" => $message->getContent(),
                ],
            ],
        ];

        // 离线推送
        $offline = $message->getOffline();
        if ($offline) {
            $json['OfflinePushInfo'] = $offline;
        }

        if (is_array($message->to)) {
            $url = 'v4/openim/batchsendmsg';
        } else {
            $url = 'v4/openim/sendmsg';
        }

        $res = $this->client->post($url, [
            'query' => $this->getQueries(),
            'json' => $json,
        ]);

        $json = (string)$res->getBody();
        $json = json_decode($json, true);
        return $json['ActionStatus'] == 'OK';
    }
}
