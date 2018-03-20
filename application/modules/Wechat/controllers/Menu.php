<?php

/**
 * author: mengqi<zhangxuan@showboom.cn>
 * Time: 2016/6/12 15:28
 * 自定义菜单
 */
class MenuController extends Yaf_Controller_Abstract
{
	/**
	 * 自定义菜单设置 heimilink_boss 修改菜单
	 */
	public function createMenuAction()
	{
		$params = TZ_Request::getParams('post');
		if (empty($params['app_code']) || empty($params['button'])) {
			TZ_Response::error('4000', '参数错误');
		}
		if (!is_array($params['button'])) {
			TZ_Response::error('4001', '消息数据必须为规定数组');
		}
		TZ_Loader::service('Foundation', 'Wechat')->writeLog($params);
		//数据签名
		$sign_params = $params;
		unset($sign_params['action']);
		$sign = TZ_Loader::service('Sign', 'Base')->checkSign($sign_params);
		if ($sign) {
			//根据ap_code查询公众号信息
			$appInfo=TZ_Loader::model('Config','Wechat')->select(array('app_code:eq'=>$params['app_code']),'*','ROW');
			if(empty($appInfo)){
				TZ_Loader::service('Foundation', 'Wechat')->writeLog('app_code get app info error');
				TZ_Response::error('4006', '获取公众号信息失败');
			}
			//获取access_token
			$token = TZ_Loader::service('Foundation', 'Wechat')->getAccessToken($appInfo['app_id'], $appInfo['app_secret']);
			$access_token = $token['access_token'];

			//$appId = TZ_Loader::model('Config', 'Wechat')->select(array('status:eq' => 1), 'app_id', 'ROW')['app_id'];
			file_put_contents(APP_PATH . '/logs/button.txt', "\n" . 'url=' . $appInfo['login_url'], FILE_APPEND);
			$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$access_token";
			$type = 'post';
			if (!empty($_POST['button'])) {
				$params = $_POST;
				file_put_contents(APP_PATH . '/logs/button.txt', "\n" . '开始自定义菜单' . date('Y-m-d H:i:s'), FILE_APPEND);
				file_put_contents(APP_PATH . '/logs/button.txt', "\n" . var_export($params, true), FILE_APPEND);
				file_put_contents("static/menuInfo.txt", serialize($params));
			} else {
				$params = unserialize(file_get_contents('static/menuInfo.txt'));
			}
			file_put_contents(APP_PATH . '/logs/button.txt', "\n" . '读取文件', FILE_APPEND);
			file_put_contents(APP_PATH . '/logs/button.txt', "\n" . var_export($params, true), FILE_APPEND);
			//去掉app_code
			unset($params['app_code']);
			//exit;
			$result = TZ_Loader::service('CurlTool', 'Base')->sendcurl($url, $type, $params);
			$resultOri = json_decode($result);
			file_put_contents(APP_PATH . '/logs/button.txt', "\n" . $result, FILE_APPEND);
			if ($resultOri->errcode != 0) {
				TZ_Response::error('5003', '创建自定义菜单失败');
			} else {
				TZ_Response::success($resultOri, '创建自定义菜单成功');
			}
		} else {
            TZ_Response::error('4005', '数据签名验证失败');
        }
	}

	/**
	 * 查询自定义菜单
	 */
	public function getMenuAction()
	{
		$params = TZ_Request::getParams('post');
		if (empty($params['app_code'])) {
			TZ_Response::error('4000', '参数错误');
		}
		TZ_Loader::service('Foundation', 'Wechat')->writeLog($params);
		//数据签名
		$sign_params = $params;
		unset($sign_params['action']);
		$sign = TZ_Loader::service('Sign', 'Base')->checkSign($sign_params);
		if ($sign) {
			//根据ap_code查询公众号信息
			$appInfo=TZ_Loader::model('Config','Wechat')->select(array('app_code:eq'=>$params['app_code']),'*','ROW');
			if(empty($appInfo)){
				TZ_Loader::service('Foundation', 'Wechat')->writeLog('app_code get app info error');
				TZ_Response::error('4006', '获取公众号信息失败');
			}
			//获取access_token
			$token = TZ_Loader::service('Foundation', 'Wechat')->getAccessToken($appInfo['app_id'], $appInfo['app_secret']);
			$access_token = $token['access_token'];

			$url = "https://api.weixin.qq.com/cgi-bin/menu/get";
			$type = 'get';
			$params = array(
            'access_token' => $access_token
			);

			$result = TZ_Loader::service('CurlTool', 'Base')->sendcurl($url, $type, $params);
			$resultOri = json_decode($result);
			if (isset($resultOri->errcode)) {
				TZ_Response::error('5003', '查询自定义菜单失败');
			} else {
				TZ_Response::success($resultOri, '查询自定义菜单成功');
			}
		} else {
            TZ_Response::error('4005', '数据签名验证失败');
        }
	}

	/**
	 * 删除自定义菜单
	 */
	public function delMenuAction()
	{
		//获取access_token
		$token = TZ_Loader::service('Foundation', 'Wechat')->getAccessToken();
		$access_token = $token['access_token'];

		$url = "https://api.weixin.qq.com/cgi-bin/menu/delete";
		$type = 'get';
		$params = array(
            'access_token' => $access_token
		);
		$result = TZ_Loader::service('CurlTool', 'Base')->sendcurl($url, $type, $params);
		$resultOri = json_decode($result);
		//print_r($result);
		if ($resultOri->errcode != 0) {
			TZ_Response::error('5003', '删除自定义菜单失败');
		} else {
			TZ_Response::success($resultOri, '删除自定义菜单成功');
        }
    }
}