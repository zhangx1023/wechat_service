<?php

/**
 * author: mengqi<zhangxuan@heimilink.com>.
 * Time: 2017/1/5 17:55
 * Info:
 */
class AutoController extends Yaf_Controller_Abstract
{
	
	//发消息(从队列中读取)
    public function sendMsgAction()
    {
        TZ_Loader::service('Foundation', 'Wechat')->writeLog("====start repeat sendmsg=====");
        while (true) {
            $data = TZ_Loader::service('Repeat', 'Wechat')->rpopData();
            if ($data) {
                //调用微信发送消息方法
            	$result = TZ_Loader::service('Message', 'Wechat')->callWxSendTem($data);
                //记录日志
                TZ_Loader::service('Foundation', 'Wechat')->writeLog($result);
                if ($result['errcode'] != '0') {
                    //记录单发失败记录
                    $data['err_msg'] = $result;
                    TZ_Loader::service('MessageLogs', 'Wechat')->insertSignalMsgLogs($data);
                    TZ_Loader::service('Foundation', 'Wechat')->writeLog('判断失败原因');
                    //用户拒收
                    if ($result['errcode'] == '43004') {
                        TZ_Loader::service('Foundation', 'Wechat')->writeLog("用户拒收此消息：" . $data['mid']);
                    } else {
                        //系统错误
                        TZ_Loader::service('Repeat', 'Wechat')->msgRecycle($data);
                    }
                } else {
                    //更新消息状态
                    TZ_Loader::service('Message', 'Wechat')->updateSignalMsg($data['mid'], 1);
                    TZ_Loader::service('Foundation', 'Wechat')->writeLog('模板消息发送成功');
                    TZ_Response::success($result,'模板消息发送成功');
                }
            } else {
                exit;
            }
        }
    }


}