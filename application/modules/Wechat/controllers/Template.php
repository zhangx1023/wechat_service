<?php

/**
 * author: mengqi<zhangxuan@showboom.cn>
 * Time: 2016/6/12 18:21
 *
 */
class TemplateController extends Yaf_Controller_Abstract
{
    /**
     * 添加模板
     */
    public function getTemplateAction()
    {
        $params = TZ_Request::getParams('get');
        if (empty($params['template_id'])) {
            TZ_Response::error('4000', '参数错误');
        }

        //获取access_token
        $token = TZ_Loader::service('Foundation', 'Wechat')->getAccessToken();
        $access_token = $token['access_token'];

        $url = "https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token=$access_token";
        $type = 'post';
        $params = array(
            'template_id_short' => $params['template_id']
        );
        $result = TZ_Loader::service('CurlTool', 'Base')->sendcurl($url, $type, $params);
        //print_r($result);exit;
        $resultOri = json_decode($result);
        if ($resultOri->errcode != 0) {
            TZ_Response::error('5004', '获取消息模板ID错误');
        } else {
            TZ_Response::success($result, '获取消息模板ID成功');
        }
    }

	//发送消息(heimilink_flow,heimilnk_boss)使用
	//touser open_id
	// url(登录地址) ,source(app_code) 不用再传
    public function sendMsgAction()
    {
        $params = TZ_Request::getParams('post');
        if (empty($params['template_key']) || empty($params['touser']) || empty($params['data'])) {
            TZ_Response::error('4000', '参数错误');
        }
        if (!is_array($params['data'])) {
            TZ_Response::error('4001', '消息数据必须为规定数组');
        }
        TZ_Loader::service('Foundation', 'Wechat')->writeLog($params);
        //print_r($params);exit;
        //数据签名
        $sign_params = $params;
        unset($sign_params['action']);
        $sign = TZ_Loader::service('Sign', 'Base')->checkSign($sign_params);
        if ($sign) {
        	//根据openId,得到公众号相关信息
        	$wxConfig = TZ_Loader::service('Foundation', 'Wechat')->getBasicInfo($params['touser']);
        	if(empty($wxConfig)){
        		TZ_Loader::service('Foundation', 'Wechat')->writeLog('openID get app error');
        		TZ_Response::error('4006', '获取公众号信息失败');
        	}
        	$params['source']=$wxConfig['app_code'];
        	$params['url']=$params['url']?:$wxConfig['login_url'];
        	$params['app_id']=$wxConfig['app_id'];
        	$params['app_secret']=$wxConfig['app_secret'];
        	TZ_Loader::service('Foundation', 'Wechat')->writeLog($wxConfig);
        	//根据模板key得到模板信息
        	$templateInfo=TZ_Loader::model('TemplateConfig','Wechat')->select(array('template_key:eq'=>$params['template_key'],'app_code:eq'=>$wxConfig['app_code']),'*','ROW');
         	if(empty($templateInfo)){
        		TZ_Loader::service('Foundation', 'Wechat')->writeLog('templateID get  error');
        		TZ_Response::error('4007', '获取模板信息失败');
        	}
        	$params['template_id']=$templateInfo['template_id'];
        	
            //存入数据库并返回消息id
            $params['status'] = 0;//发送中
            $msgID = TZ_Loader::service('Message', 'Wechat')->insertSignalMsg($params);
            unset($params['status']);

            TZ_Loader::service('Foundation', 'Wechat')->writeLog($params);
            //调用微信发送消息方法
            $result = TZ_Loader::service('Message', 'Wechat')->callWxSendTem($params);
            //记录日志
            TZ_Loader::service('Foundation', 'Wechat')->writeLog($result);
            if ($result['errcode'] != '0') {
                //记录单发失败记录
                $params['mid'] = $msgID;
                $params['err_msg'] = $result;
                TZ_Loader::service('MessageLogs', 'Wechat')->insertSignalMsgLogs($params);
                //用户拒收
                if ($result['errcode'] == '43004') {
                    TZ_Loader::service('Message', 'Wechat')->updateSignalMsg($msgID, 3);
                    TZ_Loader::service('Foundation', 'Wechat')->writeLog('require subscribe' . date('Y-m-d H:i:s'));
                    TZ_Response::error('5006', 'require subscribe');
                } else {
                    TZ_Loader::service('Foundation', 'Wechat')->writeLog('错误代码' . date('Y-m-d H:i:s'));
                    TZ_Loader::service('Foundation', 'Wechat')->writeLog($result['errcode']);
                    //access_token冲突，重新获取
                    if ($result['errcode'] == '40001') {
                        TZ_Loader::service('Foundation', 'Wechat')->writeLog('access_token invalid' . date('Y-m-d H:i:s'));
                        TZ_Loader::service('Foundation', 'Wechat')->refreshAccessToken($wxConfig['app_id'], $wxConfig['app_secret']);
                    }
                     TZ_Loader::service('Foundation', 'Wechat')->writeLog('发送失败,插入队列,下次重新发送');
                    TZ_Loader::service('Foundation', 'Wechat')->writeLog($params);
                    //进入重试队列
                    TZ_Loader::service('Repeat', 'Wechat')->msgRecycle($params);
                    TZ_Loader::service('Foundation', 'Wechat')->writeLog("发送失败，已进入redis消息队列重发");
                    TZ_Response::error('5000', '发送失败，已进入redis消息队列重发');
                }
            } else {
                //更新消息状态
                TZ_Loader::service('Message', 'Wechat')->updateSignalMsg($msgID, 1);
                TZ_Loader::service('Foundation', 'Wechat')->writeLog("发送消息模板成功");
                TZ_Response::success($result, '发送消息模板成功');
            }
        } else {
            TZ_Response::error('4005', '数据签名验证失败');
        }
    }

}