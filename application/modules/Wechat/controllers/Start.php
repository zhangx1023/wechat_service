<?php

/**
 * Created by PhpStorm.
 * User: sa
 * Date: 2016/6/12
 * Time: 13:22
 */
class StartController extends Yaf_Controller_Abstract
{
    /**
     * 测试专用action
     */
    public function indexAction()
    {
        //$result = TZ_Loader::service('Foundation', 'Wechat')->getAccessToken();
        //$result = TZ_Loader::service('Follow', 'Wechat')->getUserInfo('on__dvr330UIrxDQrN5O6b1gaWxo');
        //$result = TZ_Loader::service('Foundation', 'Wechat')->getUserList();
        //print_r($result);
    }

    /**
     * 初始化微信信息 ,自动回复和欢迎语
     */
    public function BasicAction()
    {
        TZ_Loader::service('Foundation', 'Wechat')->writeLog($_GET['echostr']);
        if (!isset($_GET['echostr'])) {
            TZ_Loader::service('Foundation', 'Wechat')->writeLog("start responseMsg");
            TZ_Loader::service('Follow', 'Wechat')->responseMsg();
        } else {
            TZ_Loader::service('Foundation', 'Wechat')->writeLog('start valid');
            TZ_Loader::service('Follow', 'Wechat')->valid();
        }
    }
}