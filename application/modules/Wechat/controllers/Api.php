<?php

/**
 * author: mengqi<zhangxuan@heimilink.com>.
 * Time: 2017/5/19 16:57
 * Info:
 */
class ApiController extends Yaf_Controller_Abstract
{
    /**
     * 获取微信配置
     */
    public function getWxConfAction()
    {
        $params = $_POST;
        if (empty($params['appCode'])) {
            TZ_Response::error('4000', '参数错误');
        }
        $data = TZ_Loader::model('Config', 'Wechat')->select(['app_code:eq' => $params['appCode']], 'app_code,app_id,app_secret,login_url', 'ROW');
        if ($data) {
            TZ_Response::success($data);
        } else {
            TZ_Response::error('4004', '此公众号配置不存在！');
        }
    }

}