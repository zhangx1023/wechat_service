<?php

/**
 * author: mengqi<zhangxuan@showboom.cn>
 * Time: 2016/6/13 11:57
 *
 */
class MessageService {
	/**
	 * 发送模板消息
	 */
	public function callWxSendTem($params) {
		$openId = $params ['touser'];
		// 获取access_token
		$token = TZ_Loader::service ( 'Foundation', 'Wechat' )->getAccessToken ( $params ['app_id'], $params ['app_secret'] );
		$access_token = $token ['access_token'];
		$urlApi = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$access_token";
		$type = 'post';
		// 根据模板得到消息体
		$data = $this->getMessageInfoByTemplateId ( $params ['template_id'], $params ['data'] );
		if (empty ( $data )) {
			TZ_Loader::service ( 'Foundation', 'Wechat' )->writeLog ( "没有得到模板消息主体，丢弃" );
			TZ_Response::error ( '40008', '没有得到模板消息主体，丢弃' );
		}
		$paramsAPI = array (
				'touser' => $openId,
				'template_id' => $params ['template_id'],
				'url' => $params ['url'] . "?openid=$openId",
				'data' => $data 
		);
		
		$result = TZ_Loader::service ( 'CurlTool', 'Base' )->sendcurl ( $urlApi, $type, $paramsAPI );
		return json_decode ( $result, true );
	}
	
	/**
	 * 单条消息插入数据库
	 * 
	 * @param
	 *        	$params
	 * @return mixed
	 * @throws Exception
	 */
	public function insertSignalMsg($params) {
		if (empty ( $params ) || ! is_array ( $params )) {
			throw new Exception ( 'param error.' );
		}
		$msg = array ();
		$msg ['openid'] = $params ['touser'];
		$msg ['template_id'] = $params ['template_id'];
		$msg ['data'] = json_encode ( $params ['data'], JSON_UNESCAPED_UNICODE );
		$msg ['source'] = $params ['source'];
		$msg ['status'] = $params ['status'];
		$msg ['type'] = 2;
		$msg ['update_at'] = date ( 'Y-m-d H:i:s' );
		$msg ['create_at'] = date ( 'Y-m-d H:i:s' );
		return TZ_Loader::model ( 'Message', 'Wechat' )->insert ( $msg );
	}
	
	// 发送消息后更新状态值
	public function updateSignalMsg($mid, $status) {
		if (empty ( $mid )) {
			throw new Exception ( 'param error.' );
		}
		$params = array ();
		$params ['status'] = $status;
		$params ['update_at'] = date ( 'Y-m-d H:i:s' );
		TZ_Loader::model ( 'Message', 'Wechat' )->update ( $params, array (
				'id:eq' => $mid 
		) );
	}
	
	/**
	 * 消息群发
	 * 
	 * @param
	 *        	$params
	 * @throws Exception
	 */
	public function insertMassMsg($params) {
		if (empty ( $params ) || ! is_array ( $params )) {
			throw new Exception ( 'param error.' );
		}
		$msg = array ();
		$openidStr = implode ( $params ['touser'], ';' );
		$msg ['openid'] = $openidStr;
		$dataStr = implode ( $params ['text'] );
		$msg ['data'] = $dataStr;
		$msg ['source'] = $params ['source'];
		$msg ['status'] = $params ['status'];
		$msg ['type'] = 1;
		$msg ['update_at'] = date ( 'Y-m-d H:i:s' );
		return TZ_Loader::model ( 'Message', 'Wechat' )->insert ( $msg );
	}
	
	/**
	 * 群发提交成功后更新状态值
	 * 
	 * @param
	 *        	$mid
	 * @param
	 *        	$status
	 * @throws Exception
	 */
	public function updateMassMsg($mid, $status) {
		if (empty ( $mid )) {
			throw new Exception ( 'param error.' );
		}
		$params = array ();
		$params ['status'] = $status;
		TZ_Loader::model ( 'Message', 'Wechat' )->update ( $params, array (
				'id:eq' => $mid 
		) );
	}
	// 根据模板id得到模板消息
	public function getMessageInfoByTemplateId($templateId, $info) {
		$data = array ();
		var_dump ( $templateId == '_CTJSl_i_eq8g8Wha1cDv7-KRo_hJqP0zYUqese2Gl0' );
		switch ($templateId) {
			case '_CTJSl_i_eq8g8Wha1cDv7-KRo_hJqP0zYUqese2Gl0' : // 黑米流量通
			case 'y0YVp0-ZfFD4X5ZduSExLqvjqNXbBrW8pNJpcFZAPCE' : // showboom秀豹
			case 'jFldswVmBZ_UimNFrMF8-kkBDx5lPo-P-UDTgfW4-v8' : // 黑米大牛
			                                                    // 充值成功提醒
				$data = array (
						"first" => array (
								"value" => $info ['title'],
								"color" => "#000000" 
						),
						"keyword1" => array (
								"value" => $info ['pack_flow'],
								"color" => "#173177" 
						),
						"keyword2" => array (
								"value" => $info ['expire_time'],
								"color" => "#173177" 
						),
						"keyword3" => array (
								"value" => $info ['now_flow'],
								"color" => "#173177" 
						),
						"remark" => array (
								"value" => "流量卡号：" . $info ['iccid'] . "\n备注：剩余流量统计存在一定延迟，请点击“详情”查询。如有疑问，请在公众号中留言。",
								"color" => "#000000" 
						) 
				);
				break;
			case 'fsUsh4hShMleevGyMmhehxwWB9R1FIeNO9KaoWzrAos' : // 黑米流量通
			case '1CqsYwM05o2kejsZOVZ4HruwHNLNOmSzlAyvUsAxHQI' : // showboom秀豹
			case 'hjslyJjw5Ew65Ws_goY_ZXqlRuR2enwQRi0e6EofDRI' : // 黑米大牛
			                                                    // 实名驳回通知
				$data = array (
						"first" => array (
								"value" => $info ['title'],
								"color" => "#000000" 
						),
						"keyword1" => array (
								"value" => $info ['iccid'],
								"color" => "#173177" 
						),
						"keyword2" => array (
								"value" => $info ['real_name'],
								"color" => "#173177" 
						),
						"keyword3" => array (
								"value" => substr_replace ( $info ['mobile'], '****', 7 ),
								"color" => "#173177" 
						),
						"keyword4" => array (
								"value" => $info ['reason'],
								"color" => "#173177" 
						),
						"remark" => array (
								"value" => $info ['remark'],
								"color" => "#FF5511" 
						) 
				);
				break;
			case 'XW3oqd0JdDiSbIwnrqCp5_uVHo03LXvjyrCQGurm66s' : // 黑米流量通
			case '-x1YSdXSWIgOtTL90uh6_7WFExm0nYz7iC1R-1hKRXs' : // showboom秀豹
			case 'pwXBQDUG0BH233DB8LeJQ_98hT90Tm7ddzkhfNNCvqI' : // 黑米大牛
			                                                    // 流量不足提醒
				$data = array (
						"first" => array (
								"value" => $info ['title'],
								"color" => "#000000" 
						),
						"time" => array (
								"value" => $info ['search_time'],
								"color" => "#173177" 
						),
						"yiyong" => array (
								"value" => '',
								"color" => "#173177" 
						),
						"taocan remainder" => array (
								"value" => $info ['left_flow'] . "\n" . "流量卡号：" . $info ['iccid'],
								"color" => "#173177" 
						),
						"remark" => array (
								"value" => $info ['remark'],
								"color" => "#FF5511" 
						) 
				);
				break;
			
			case 'aCxR1tC2X5x1mLHczt_r0Rro7Tf6V6D6y0tunVe-EEo' : // 黑米流量通
			case 'Ad-U8udOV7IRqP_rXMlGZ15PpacAMh5nJKBFdnvdccc' : // showboom秀豹
			case '_bAjeTRZpuvXWTrLXMCHFzo1jiLWpjHAlJnTtKgjzgY' : // 黑米大牛
			                                                    // 注销提醒
				$data = array (
						"first" => array (
								"value" => $info ['title'],
								"color" => "#000000" 
						),
						"keyword1" => array (
								"value" => $info ['iccid'],
								"color" => "#173177" 
						),
						"keyword2" => array (
								"value" => $info ['first_time'],
								"color" => "#173177" 
						),
						"keyword3" => array (
								"value" => $info ['last_time'],
								"color" => "#173177" 
						),
						
						"keyword4" => array (
								"value" => $info ['money'],
								"color" => "#173177" 
						),
						
						"keyword5" => array (
								"value" => $info ['save_money'],
								"color" => "#173177" 
						),
						"remark" => array (
								"value" => $info ['remark'],
								"color" => "#FF5511" 
						) 
				);
				break;
			case '8UNaSDFeDz2p7IaIV7kYGEFWBOKgQWniIZwrD4tR5w4' : // 黑米技术大牛
			case '3vKi9JvcY3_7byo_pUdktZ9Yu_eyAUPwS4xWZSNycZo' : // 秀豹
			case 'VXFaXD7xX1GyB_Im6Nf2r72d6W6R07uOfJe5VrCiIoo' : // 手由宝
			case 'b-W-6s2n-JjBSXsJ9Yv3z-sJzfi1vC3x_gINqX_wc9s' : // 黑米流量中心
			                                                    // 审核结果通知
				$data = array (
						"first" => array (
								"value" => $info ['title'],
								"color" => "#000000" 
						),
						"keyword1" => array (
								"value" => $info ['name'],
								"color" => "#173177" 
						),
						"keyword2" => array (
								"value" => $info ['result'],
								"color" => "#173177" 
						),
						"remark" => array (
								"value" => $info ['remark'],
								"color" => "#FF5511" 
						) 
				);
				break;
			case 'WxOY2i7nOm_BfZZpua0iPRJF0tYVvBy-tKdaMKE3rI4' : // 黑米技术大牛
			case 'z4AbDrFxzY-xv0PjQOOilrBObARHSO5Ybd1nNII1Zas' : // 秀豹
			                                                    // 发货提醒
				$data = array (
						"first" => array (
								"value" => $info ['title'],
								"color" => "#000000" 
						),
						"keyword1" => array (
								"value" => $info ['name'],
								"color" => "#173177" 
						),
						"keyword2" => array (
								"value" => $info ['number'],
								"color" => "#173177" 
						),
						"remark" => array (
								"value" => $info ['remark'],
								"color" => "#FF5511" 
						) 
				);
				break;
			case 'qPQRvOpAnNc2_wsfkcAKL5aIQW8MCUDVsIKX5WvNtp8' : // 黑米技术大牛
			case 'E3s2JS1I3OdWktLeL60MIjV7YB3fpn2P9LpOhcHiKIQ' : // 黑米流量通
			                                                    // 订单异常提醒
				$data = array (
						"first" => array (
								"value" => $info ['title'],
								"color" => "#000000" 
						),
						"keyword1" => array (
								"value" => $info ['iccid'],
								"color" => "#173177" 
						),
						"keyword2" => array (
								"value" => $info ['name'],
								"color" => "#173177" 
						),
						"keyword3" => array (
								"value" => $info ['source'],
								"color" => "#173177" 
						),
						"remark" => array (
								"value" => $info ['remark'],
								"color" => "#FF5511" 
						) 
				);
				break;
			case 'aBgp881Hpqn40CLwuU1EWOCCYCqD5eTs4gF9cGc0A2U' : // 手由宝
			case '_SeaLjZqrXbB-CHLz9sdUsuopIiMRrw7ygW-Br6V8zA' : // 黑米流量中心
			                                                    // 套餐到期提醒
				$data = array (
						"first" => array (
								"value" => $info ['title'],
								"color" => "#000000" 
						),
						"keyword1" => array (
								"value" => $info ['imei'],
								"color" => "#173177" 
						),
						"keyword2" => array (
								"value" => $info ['name'],
								"color" => "#173177" 
						),
						"keyword3" => array (
								"value" => $info ['date'],
								"color" => "#173177" 
						),
						"remark" => array (
								"value" => $info ['remark'],
								"color" => "#FF5511" 
						) 
				);
				break;
			case 'f0VbvcV5EynkXcUE5UYVmR7Jg5ykvduDMp-1MD9Xwhk' : // 手由宝
			case 'Ti1DStafaIpS9XSWoDV1LHuPn1aVgU2sMXxCfcPONN8' : // 黑米流量中心
			                                                    // 订单发货通知
				$data = array (
						"first" => array (
								"value" => $info ['title'],
								"color" => "#000000" 
						),
						"keyword1" => array (
								"value" => $info ['name'],
								"color" => "#173177" 
						),
						"keyword2" => array (
								"value" => $info ['address'],
								"color" => "#173177" 
						),
						"keyword3" => array (
								"value" => $info ['order'],
								"color" => "#173177" 
						),
						"remark" => array (
								"value" => $info ['remark'],
								"color" => "#FF5511" 
						) 
				);
				break;
			case 'J__v3nnMLLWo_l0sgZKMh4Imu-Rc87SrI3Vy8hGykRQ' : // 黑米大牛
			case 'hC5yvTEDa8gSG1Sn-T7xLQrnDeDEoPl-17_xH7oWN7E' : // 秀宝
			case 'QmVUROzhvOiLoef1dp-7ATgYiGOi35XV-SgOtdyXyTI' : // 黑米流量通
			                                                    // 发票寄送通知
				$data = array (
						"first" => array (
								"value" => $info ['title'],
								"color" => "#000000" 
						),
						"keyword1" => array (
								"value" => $info ['money'],
								"color" => "#173177" 
						),
						"keyword2" => array (
								"value" => $info ['type'],
								"color" => "#173177" 
						),
						"keyword3" => array (
								"value" => $info ['company'],
								"color" => "#173177" 
						),
						"keyword4" => array (
								"value" => $info ['order'],
								"color" => "#173177" 
						),
						"remark" => array (
								"value" => $info ['remark'],
								"color" => "#FF5511" 
						) 
				);
				break;
			case 'loaTIH5-1FYa6XORulf12QXkCsiG0fZHcvDujTZDAAg' : // 黑米大牛
			case 'Fzb6kAz_i13-QoyUd0FahQA-YpSsfkzw3WFgMn8g0JY' : // 秀宝
			case 'i5KXRHOPd3RtN2Kaa4pmioWI5jnT6EKvMgH0m50_vlM' : // 黑米流量通
			                                                    // 电子发票寄送通知
				$data = array (
						"first" => array (
								"value" => $info ['title'],
								"color" => "#000000" 
						),
						"keyword1" => array (
								"value" => $info ['money'],
								"color" => "#173177" 
						),
						"keyword2" => array (
								"value" => $info ['type'],
								"color" => "#173177" 
						),
						"keyword3" => array (
								"value" => $info ['mail'],
								"color" => "#173177" 
						),
						"remark" => array (
								"value" => $info ['remark'],
								"color" => "#FF5511" 
						) 
				);
				break;
			case '5ZNEp1Cla1P_kF7PnBGyN7n-mDyPbhFl0xW8llj7akg' : // 黑米大牛
			case 'FGqK6_bop0m1b9IWw7qnnCb04LYOcUfK1Vv2CoEiSZM' : // 秀宝
			case 'Lod4Sq3zJcdVSGeM36S9SrwE9rBFDk86lsbfCN25NeM' : // 黑米流量通
			                                                    // 申请驳回通知
				$data = array (
						"first" => array (
								"value" => $info ['title'],
								"color" => "#000000" 
						),
						"keyword1" => array (
								"value" => $info ['money'],
								"color" => "#173177" 
						),
						"keyword2" => array (
								"value" => $info ['type'],
								"color" => "#173177" 
						),
						"keyword3" => array (
								"value" => $info ['reason'],
								"color" => "#173177" 
						),
						"remark" => array (
								"value" => $info ['remark'],
								"color" => "#FF5511" 
						) 
				);
				break;
			case '-EBDMQe_W1pc806DGE6v7uGjeBUYC5M6qph8c78GpHo' : // 黑米大牛
			case 'ZthmBf-jZntftsY5O5vYl1qI7WpMepz3BBSb8I-YGZ8' : // 秀宝
			case 'obHj0_PR1VXNYtDAP1A06eGIZFvcPAeky0iBSIOV3yE' : // 黑米流量通
			                                                    // 收货成功通知
				$data = array (
						"first" => array (
								"value" => $info ['title'],
								"color" => "#000000" 
						),
						"keyword1" => array (
								"value" => $info ['type'],
								"color" => "#173177" 
						),
						"keyword2" => array (
								"value" => $info ['order'],
								"color" => "#173177" 
						),
						"remark" => array (
								"value" => $info ['remark'],
								"color" => "#FF5511" 
						) 
				);
				break;
			case 'w_YnchoGguizhRyxiFgNDAQxJazIk--vRqGtI6IDbFQ' : // 黑米大牛
			case 'NDHbNULzXXfr5D-nlbifxHhTC2vLcR5TIJTS3MXgWNE' : // 秀宝
			                                                    // 收货信息修改通知
				$data = array (
						"first" => array (
								"value" => $info ['title'],
								"color" => "#000000" 
						),
						"keyword1" => array (
								"value" => $info ['name'],
								"color" => "#173177" 
						),
						"keyword2" => array (
								"value" => $info ['telephone'],
								"color" => "#173177" 
						),
						"keyword3" => array (
								"value" => $info ['address'],
								"color" => "#173177" 
						),
						"remark" => array (
								"value" => $info ['remark'],
								"color" => "#FF5511" 
						) 
				);
				break;
			case 'iH8zYxNS5aXCtdCso6Whw813qOcdRrWZsJviDTHlFTQ' : // 黑米大牛
			case 'YL89bEd8Rjn-46QNS7KMqTKmEYEuLU8B1ZXTnj-gM-4' : // 秀宝
			                                                    // 付款成功通知
				$data = array (
						"first" => array (
								"value" => $info ['title'],
								"color" => "#000000" 
						),
						"keyword1" => array (
								"value" => $info ['name'],
								"color" => "#173177" 
						),
						"keyword2" => array (
								"value" => $info ['money'],
								"color" => "#173177" 
						),
						"remark" => array (
								"value" => $info ['remark'],
								"color" => "#FF5511" 
						) 
				);
				break;
			case '6mXyfg5VTjDy838WYofDoncwx4Q6SUBsIUQT0cke2Ls' : // 黑米小白iii测试
			case '7WTkXN0xl-QHv41-yVfM7LVxYoCAAYPddq69uHppmYo' : // 秀豹流量手机
			    // 发货通知
			    $data = array (
			    "first" => array (
			    "value" => $info ['title'],
			    "color" => "#000000"
			        ),
			        "keyword1" => array (
			        "value" => $info ['name'],
			        "color" => "#173177"
			            ),
			            "keyword2" => array (
			            "value" => $info ['address'],
			            "color" => "#173177"
			                ),
			                "keyword3" => array (
			                "value" => $info ['time'],
			                "color" => "#173177"
			                    ),
			                    "keyword4" => array (
			                    "value" => $info ['order'],
			                    "color" => "#173177"
			                        ),
			                "remark" => array (
			                "value" => $info ['remark'],
			                "color" => "#FF5511"
			                    )
			                );
			    break;
			case 'zC47PCkI65q5H9ZxPTbTwPxtgxt9IiYAp7VHZApAKKo' : // 黑米小白iii测试
			case 'KJij2aoO9pj2xfd2BlL8LpvBzBHrLBZbYSaMQQy_JvM' : // 秀豹流量手机
			    // 赔付通知
			    $data = array (
			    "first" => array (
			    "value" => $info ['title'],
			    "color" => "#000000"
			        ),
			        "keyword1" => array (
			        "value" => $info ['name'],
			        "color" => "#173177"
			            ),
			            "keyword2" => array (
			            "value" => $info ['result'],
			            "color" => "#173177"
			                ),
			                "keyword3" => array (
			                "value" => $info ['money'],
			                "color" => "#173177"
			                    ),
			                "remark" => array (
			                "value" => $info ['remark'],
			                "color" => "#FF5511"
			                    )
			                );
			    break;
			case 'ewNXNgYZsIIKXix_P0cFLreZf94-trAVt27UWJtu3kQ' : // 黑米小白iii测试
			case 'u7U_JkZixrs2vnnLb36eNlmREGh68dgRUHex786TTYA' : // 秀豹流量手机
			    // 设备寄回提醒
			    $data = array (
			    "first" => array (
			    "value" => $info ['title'],
			    "color" => "#000000"
			        ),
			        "keyword1" => array (
			        "value" => $info ['name'],
			        "color" => "#173177"
			            ),
			            "keyword2" => array (
			            "value" => $info ['time'],
			            "color" => "#173177"
			                ),
			                "keyword3" => array (
			                "value" => $info ['back_time'],
			                "color" => "#173177"
			                    ),
			                "remark" => array (
			                "value" => $info ['remark'],
			                "color" => "#FF5511"
			                    )
			                );
			    break;
			case 'aB-LlYb2tMDbsQgT2kjY_-dI-H833QZ2_QfrLPmM4G4' : // 黑米小白iii测试
			case 'b2mOAoYITIDIMo7QnalxMo5UOdo3XEtnFEMFRwntnwM' : // 秀豹流量手机
			    // 收货通知
			    $data = array (
			    "first" => array (
			    "value" => $info ['title'],
			    "color" => "#000000"
			        ),
			        "keyword1" => array (
			        "value" => $info ['name'],
			        "color" => "#173177"
			            ),
			            "keyword2" => array (
			            "value" => $info ['result'],
			            "color" => "#173177"
			                ),
			                "remark" => array (
			                "value" => $info ['remark'],
			                "color" => "#FF5511"
			                    )
			                );
			    break;
			case 'TKFND4v8rY3x8qhdLkb_II9yLtUp_AqkFdN_THuLAfM' : // 黑米小白iii测试
			case 'jPC3nvwprTfwn2kNhE3enHfUQw-PebhU3RyrjsWkWQE' : // 秀豹流量手机
			    // 流量活动成功参与通知
			    $data = array (
			    "first" => array (
			    "value" => $info ['title'],
			    "color" => "#000000"
			        ),
			        "keyword1" => array (
			        "value" => $info ['name'],
			        "color" => "#173177"
			            ),
			            "keyword2" => array (
			            "value" => $info ['flow'],
			            "color" => "#173177"
			                ),
			                "keyword3" => array (
			                "value" => $info ['time'],
			                "color" => "#173177"
			                    ),
			                "remark" => array (
			                "value" => $info ['remark'],
			                "color" => "#FF5511"
			                    )
			                );
			    break;
			case 'DX7-2fOhoO6VDqHFguc6qksRIYMrXJsL5JkRnsifefw' : // 黑米小白iii测试
			case 'W4GbA1GsOI4jN1driQaDrHXrdmt72ERWrNhsVk0jiXw' : // 秀豹流量手机
			    // 试用进度提醒
			    $data = array (
			    "first" => array (
			    "value" => $info ['title'],
			    "color" => "#000000"
			        ),
			        "keyword1" => array (
			        "value" => $info ['name'],
			        "color" => "#173177"
			            ),
			            "keyword2" => array (
			            "value" => $info ['order'],
			            "color" => "#173177"
			                ),
			                "keyword3" => array (
			                "value" => $info ['time'],
			                "color" => "#173177"
			                    ),
			                    "keyword4" => array (
			                    "value" => $info ['end_time'],
			                    "color" => "#173177"
			                        ),
			                "remark" => array (
			                "value" => $info ['remark'],
			                "color" => "#FF5511"
			                    )
			                );
			    break;
			case '6iC6b2xisIutUM4NMV-ybDHCNoQA-OZ1LkDRB7O7nac' : // 黑米小白iii测试
			case 'Q0V3Q7COOHltd1JNewymN95yC_cL1PfreMNzy8KS1zs' : // 秀豹流量手机
			    // 逾期提醒
			    $data = array (
			    "first" => array (
			    "value" => $info ['title'],
			    "color" => "#000000"
			        ),
			        "keyword1" => array (
			        "value" => $info ['order'],
			        "color" => "#173177"
			            ),
			            "keyword2" => array (
			            "value" => $info ['detail'],
			            "color" => "#173177"
			                ),
			                "keyword3" => array (
			                "value" => $info ['end_time'],
			                "color" => "#173177"
			                    ),
			                        "remark" => array (
			                        "value" => $info ['remark'],
			                        "color" => "#FF5511"
			                            )
			                        );
			    break;
			default :
				break;
		}
		
		return $data;
	}
}