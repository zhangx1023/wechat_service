<?php

/**
 * author: mengqi<zhangxuan@showboom.cn>
 * Time: 2016/6/17 9:19
 *
 */
class TestController extends Yaf_Controller_Abstract
{
    /**
     * 获取菜单
     */
    public function createMenuAction()
    {
        $info = array();
        $params = $_POST;
        if (empty($params['id']) || !is_numeric($params['id']))
            throw new Exception('id为空!');
        $info['order_no'] = $params['order_no'];
        $info['code'] = $params['code'];
        $info['title'] = $params['title'];
        $info['sub_title'] = $params['sub_title'];
        $info['package'] = $params['package'];
        $info['pack_type'] = $params['pack_type'];
        $info['effect_period'] = $params['effect_period'];
        $info['original_price'] = $params['original_price'];
        $info['price'] = $params['price'];
        $info['real_price'] = $params['real_price'];
        $info['use_score'] = $params['use_score'];
        $info['give_score'] = $params['give_score'];
        $info['status'] = $params['status'];
        $info['pack_pic'] = $params['imageurl'];
        $info['updated_at'] = date('Y-m-d H:i:s');
    }

    /**
     * 发送模板消息
     */
    public function sendMsgAction()
    {
        $info = array();
        //$params = $_POST;
	TZ_Loader::service('Foundation', 'Wechat')->writeLog('start test send msg');
        $info['touser'] = 'on__dvkoxfHCPgXw7kvA8JxEBgQE';
        $info['template_id'] = '_CTJSl_i_eq8g8Wha1cDv7-KRo_hJqP0zYUqese2Gl0';
        $info['data'] =array(
	        'title'=>'您充值的流量包已经到账。',
	        'pack_flow'=>'100M',
	        'expire_time'=>'2017-08-31 23:59:59',
	        'now_flow'=>'150M',
	        'code'=>'89860042191576096350'
        );
        $url = "http://mns.test.heimilink.com/wechat/template/sendmsg";
        TZ_Loader::service('Foundation', 'Wechat')->writeLog($info);
        TZ_Loader::service('Foundation', 'Wechat')->writeLog($url);
        $result = TZ_Loader::service('CurlTool', 'Base')->sendcurl($url, 'post', $info);
        TZ_Loader::service('Foundation', 'Wechat')->writeLog($result);
		return json_decode($result, true);
    }


    public function menuViewAction()
    {
        $this->_view->display('menu.tpl');
    }

    public function sendMsgViewAction()
    {
        $this->_view->display('sendmsg.tpl');
    }

    public function sendMassViewAction()
    {
        $this->_view->display('sendmass.tpl');
    }
}