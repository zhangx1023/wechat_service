<?php

/**
 * author: mengqi<zhangxuan@showboom.cn>
 * Time: 2016/6/13 11:27
 *
 */
class RepeatService
{
    static $redis = null;
    static protected $msgKey = 'wx:send_msg:';

    public function __construct()
    {
        self::$redis = TZ_Redis::connect('user');
    }


    /**
     * 消息回收
     * @param array $params
     */
    public function msgRecycle($params = array())
    {
        TZ_Loader::service('Foundation', 'Wechat')->writeLog("----start msg recycle----");
        TZ_Loader::service('Foundation', 'Wechat')->writeLog($params);
        try {
            $count = $params['count'] ? $params['count'] : 1;
            $errcode = json_decode($params['err_msg'], true)['errcode'];
            if ($errcode != '45009' && $errcode != '43004' && $count < 5) {
                $params['count']++;
                unset($params['err_msg']);
                self::$redis->LPUSH(self::$msgKey, json_encode($params, JSON_UNESCAPED_UNICODE));
            } else {
                TZ_Loader::service('Foundation', 'Wechat')->writeLog('由于某些原因消息发送失败');
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
        TZ_Loader::service('Foundation', 'Wechat')->writeLog("----end msg recycle----");
    }

    /**
     * rpop redis data and send
     */
    public function rpopData()
    {
        if (self::$redis->LLEN(self::$msgKey)) {
            $result=self::$redis->RPOP(self::$msgKey);
            return json_decode($result,true);
        }
        return false;
    }

}