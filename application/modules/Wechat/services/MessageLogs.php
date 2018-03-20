<?php

/**
 * author: mengqi<zhangxuan@showboom.cn>
 * Time: 2016/6/13 14:08
 *
 */
class MessageLogsService
{
    /**
     * 记录单发消息失败记录
     * @param $params
     * @throws Exception
     */
    public function insertSignalMsgLogs($params)
    {
        if (empty($params) || !is_array($params)) {
            throw new Exception('param error.');
        }
        $msg = array();
        $msg['mid'] = $params['mid'];
        $msg['openid'] = $params['touser'];
        $msg['template_id'] = $params['template_id'];
        $msg['data'] = json_encode($params['data'], JSON_UNESCAPED_UNICODE);
        $msg['source'] = $params['source'];
        $msg['type'] = 2;
        $msg['err_msg'] = json_encode($params['err_msg'], JSON_UNESCAPED_UNICODE);
        $msg['create_at'] = date('Y-m-d H:i:s');
        TZ_Loader::model('MessageLogs', 'Wechat')->insert($msg);
    }


    /**
     * 记录群发消息失败记录
     * @param $params
     * @throws Exception
     */
    public function insertMassMsgLogs($params)
    {
        if (empty($params) || !is_array($params)) {
            throw new Exception('param error.');
        }
        $msg = array();
        $msg['mid'] = $params['mid'];
        $openidStr = implode($params['touser'], ';');
        $msg['openid'] = $openidStr;
        $msg['template_id'] = $params['template_id'];
        $msg['data'] = $params['text']['content'];
        $msg['source'] = $params['source'];
        $msg['type'] = 1;
        $msg['err_msg'] = $params['err_msg'];
        $msg['create_at'] = date('Y-m-d H:i:s');
        TZ_Loader::model('MessageLogs', 'Wechat')->insert($msg);
    }

}