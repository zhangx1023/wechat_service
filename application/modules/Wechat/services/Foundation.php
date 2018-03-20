<?php

/**
 * author: mengqi<zhangxuan@showboom.cn>
 * Time: 2016/6/12 17:13
 *
 */
class FoundationService
{
    static $redis = null;
    static protected $redis_predix = 'access_token:';
    static protected $expire = 7190;//access_token 有效期

    public function __construct()
    {
        self::$redis = TZ_Redis::connect('user');
    }

    /**
     * 获取微信access_token
     * @return array
     */
    public function getAccessToken($appId, $appSecret)
    {
        // 读取redis中的token数据,如果存在直接返回
        $access_token = self::$redis->get(self::$redis_predix . $appId);
        $this->writeLog('redis中存储的access_token' . date('Y-m-d H:i:s'));
        $this->writeLog($access_token);
        if ($access_token) {
            $result = array(
                'error' => 0,
                'access_token' => $access_token
            );
            return $result;
        }
        //若没有则调用API获取
        $url = 'https://api.weixin.qq.com/cgi-bin/token';
        $type = 'get';
        $params = array(
            'grant_type' => 'client_credential',
            'appid' => $appId,
            'secret' => $appSecret
        );
        $result = TZ_Loader::service('CurlTool', 'Base')->sendcurl($url, $type, $params);
        $info = json_decode($result, true);
        $token = $info['access_token'];
        $this->writeLog('调用微信API获取access_token' . date('Y-m-d H:i:s'));
        $this->writeLog($token);
        //验证时候获取失败
        if (!isset($token)) {
            return array(
                'error' => -1,
                'msg' => 'access_token API调用失败'
            );
        }
        // 将获取到的token缓存入redis,设置过期时间
        $this->setToken(self::$redis_predix . $appId, $token);
        // 返回获取到的token
        return array(
            'error' => 0,
            'access_token' => $token
        );
    }

    /**
     * 生成token及保存数据
     * @param $key
     * @param $value
     */
    public function setToken($key, $value)
    {
        self::$redis->setex($key, self::$expire, $value);
    }

    /**
     * 获取用户列表
     * @param string $next_opneid
     * @return bool
     */
    public function getUserList($next_opneid = '')
    {
        //获取access_token
        $token = TZ_Loader::service('Foundation', 'Wechat')->getAccessToken();
        $access_token = $token['access_token'];

        $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$access_token";
        $params = array(
            "next_openid" => $next_opneid
        );
        $result = json_decode(TZ_Loader::service('CurlTool', 'Base')->sendcurl($url, 'post', $params), true);

        return ($result == false) ? false : $result;
    }

    /**
     * 刷新access_token
     * @throws Exception
     */
    public function refreshAccessToken($appId, $appSecret)
    {
        $this->writeLog('进入刷新access_token方法' . date('Y-m-d H:i:s'));
        try {
            $this->writeLog('刷新access_token' . date('Y-m-d H:i:s'));
            $key = self::$redis_predix . $appId;
            if (self::$redis->exists($key)) {
                $this->writeLog('access_token已存在' . date('Y-m-d H:i:s'));
                $this->writeLog('access_token原值为：' . self::$redis->get($key));
                self::$redis->del($key);
                $this->getAccessToken($appId, $appSecret);
            }
        } catch (Exception $e) {
            throw new Exception('刷新redis失败');
        }
    }

    /**
     * 获取微信账号基本信息
     * @return bool
     */
    public function getBasicInfo($openId)
    {
        $appCode = TZ_Loader::model('UserWx', 'Wechat')->select(['openid:eq' => $openId], 'app_code', 'ROW')['app_code'];
        if(empty($appCode)){
        	$info=TZ_Loader::model('UserInfo', 'Wechat')->select(['openid:eq' => $openId], '*', 'ROW');
        	if(!empty($info)){
        		$appCode='S_DEVICE';
        	}
        }
        $wxConfig = TZ_Loader::model('Config', 'Wechat')->select(['app_code:eq' => $appCode], '*', 'ROW');
        return $wxConfig;
    }

    /**写日志
     * @param $msg
     */
    public function writeLog($msg)
    {
        $file = $_SERVER['DOCUMENT_ROOT'] . "/logs/" . date("Ymd") . ".log";
        if (!is_dir($_SERVER['DOCUMENT_ROOT'] . "/logs/")) {
            mkdir($_SERVER['DOCUMENT_ROOT'] . "/logs/", 0777, true);
        }
        file_put_contents($file, date('Y-m-d H:i:s') . " : " . json_encode($msg, JSON_UNESCAPED_UNICODE) . "\r\n", FILE_APPEND);
    }


}