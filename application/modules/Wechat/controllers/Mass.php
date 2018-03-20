<?php

/**
 * author: mengqi<zhangxuan@showboom.cn>
 * Time: 2016/6/13 15:01
 *
 */
class MassController extends Yaf_Controller_Abstract
{
	
	//目前不用
	
    /**
     * 上传素材
     * todo
     */
    public function uploadMaterialAction()
    {

    }

    /**
     * todo
     * 根据标签进行群发
     * 仅限文本信息
     */
    public function sendByTagAction()
    {
        $params = TZ_Request::getParams('post');
        if (empty($params['is_to_all']) || empty($params['tag_id']) || empty($params['content'])) {
            TZ_Response::error('4000', '参数错误');
        }

        //获取access_token
        $token = TZ_Loader::service('Foundation', 'Wechat')->getAccessToken();
        $access_token = $token['access_token'];

        $url = "https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=$access_token";
        $type = 'post';
        $paramsAPI = array(
            "filter" => array(
                "is_to_all" => $params['is_to_all'],
                "tag_id" => $params['tag_id']
            ),
            "text" => array(
                "content" => $params['content']
            ),
            "msgtype" => "text"
        );

        //存入数据库并返回消息id
        $msgID = TZ_Loader::service('Message', 'Wechat')->insertMassMsg($params);

        $result = TZ_Loader::service('CurlTool', 'Base')->sendcurl($url, $type, $paramsAPI);


    }


    /**
     * 根据openid进行群发
     * 仅限文本消息
     */
    public function sendByOpenidAction()
    {
        $params = TZ_Request::getParams('post');
        if (empty($params['touser']) || empty($params['text']) || empty($params['source']) || !is_array($params['touser']) || !is_array($params['text'])) {
            TZ_Response::error('4000', '参数错误');
        }

        $sign_params = $params;
        unset($sign_params['action']);
        $sign = TZ_Loader::service('Sign', 'Base')->checkSign($sign_params);
        if (true) {
            //获取access_token
            $token = TZ_Loader::service('Foundation', 'Wechat')->getAccessToken();
            $access_token = $token['access_token'];

            $url = "https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=$access_token";
            $paramsAPI = array(
                "touser" => $params['touser'],
                "msgtype" => "text",
                "text" => $params['text']
                /*"touser" => [
                    "on__dvr330UIrxDQrN5O6b1gaWxo",
                    "on__dvqYtps_pkjm51fX5tUSdvaY"
                ],
                "text" => array(
                    "content" => "hello from heimi."
                ),
                "msgtype" => "text"*/
            );
            //存入数据库并返回消息id
            //print_r($paramsAPI);
            $msgID = TZ_Loader::service('Message', 'Wechat')->insertMassMsg($params);
            $result = TZ_Loader::service('CurlTool', 'Base')->sendcurl($url, 'post', $paramsAPI);
            $resultOri = json_decode($result);
            if ($resultOri->errcode != '0') {
                //记录群发失败记录
                $params['mid'] = $msgID;
                $params['err_msg'] = $result;
                TZ_Loader::service('MessageLogs', 'Wechat')->insertMassMsgLogs($params);

                TZ_Response::error('4010', '群发消息提交失败');
            } else {
                TZ_Loader::service('Message', 'Wechat')->updateMassMsg($msgID, 1);
                TZ_Response::success($resultOri, '群发消息提交成功');
            }
        } else {
            TZ_Response::error('4005', '数据签名验证失败');
        }
    }

    /**
     * 获取群发消息状态
     */
    public function getStatusAction()
    {

    }

}