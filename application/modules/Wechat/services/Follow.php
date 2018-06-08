<?php

/**
 * author: mengqi<zhangxuan@showboom.cn>
 * Time: 2016/6/12 17:13
 *
 */
class FollowService
{
    static private $_token_url = "https://api.weixin.qq.com/cgi-bin/token";
    static private $_user_url = "https://api.weixin.qq.com/cgi-bin/user/info";
    static private $_update_remark = "https://api.weixin.qq.com/cgi-bin/user/info/updateremark?access_token=ACCESS_TOKEN";

    public function __construct()
    {
        // 返回文本消息模板
        $this->textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
        // 返回图文消息模板(单条)
        $this->simpleNewsTpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[news]]></MsgType>
            <ArticleCount>1</ArticleCount>
            <Articles>
            <item>
            <Title><![CDATA[%s]]></Title> 
            <Description><![CDATA[%s]]></Description>
            <PicUrl><![CDATA[%s]]></PicUrl>
            <Url><![CDATA[%s]]></Url>
            </item>
            </Articles>
            </xml> ";

        $this->picText = "<xml>"
            . "<ToUserName><![CDATA[%s]]></ToUserName>"
            . "<FromUserName><![CDATA[%s]]></FromUserName>"
            . "<CreateTime>%d</CreateTime>"
            . "<MsgType><![CDATA[news]]></MsgType>"
            . "<ArticleCount>1</ArticleCount>"
            . "<Articles>"
            . "<item>"
            . "<Title><![CDATA[%s]]></Title>"
            . "<Description><![CDATA[%s]]></Description>"
            . "<PicUrl><![CDATA[%s]]></PicUrl>"
            . "<Url><![CDATA[%s]]></Url>"
            . "</item>"
            . "</Articles>"
            . "<FuncFlag>0</FuncFlag>"
            . "</xml>";

        $this->picText2 = "<xml>"
            . "<ToUserName><![CDATA[%s]]></ToUserName>"
            . "<FromUserName><![CDATA[%s]]></FromUserName>"
            . "<CreateTime>%d</CreateTime>"
            . "<MsgType><![CDATA[news]]></MsgType>"
            . "<ArticleCount>2</ArticleCount>"
            . "<Articles>"
            . "<item>"
            . "<Title><![CDATA[%s]]></Title>"
            . "<Description><![CDATA[%s]]></Description>"
            . "<PicUrl><![CDATA[%s]]></PicUrl>"
            . "<Url><![CDATA[%s]]></Url>"
            . "</item>"
            . "<item>"
            . "<Title><![CDATA[%s]]></Title>"
            . "<Description><![CDATA[%s]]></Description>"
            . "<PicUrl><![CDATA[%s]]></PicUrl>"
            . "<Url><![CDATA[%s]]></Url>"
            . "</item>"
            . "</Articles>"
            . "<FuncFlag>0</FuncFlag>"
            . "</xml>";

        $this->picText4 = "<xml>"
            . "<ToUserName><![CDATA[%s]]></ToUserName>"
            . "<FromUserName><![CDATA[%s]]></FromUserName>"
            . "<CreateTime>%d</CreateTime>"
            . "<MsgType><![CDATA[news]]></MsgType>"
            . "<ArticleCount>4</ArticleCount>"
            . "<Articles>"
            . "<item>"
            . "<Title><![CDATA[%s]]></Title>"
            . "<Description><![CDATA[%s]]></Description>"
            . "<PicUrl><![CDATA[%s]]></PicUrl>"
            . "<Url><![CDATA[%s]]></Url>"
            . "</item>"
            . "<item>"
            . "<Title><![CDATA[%s]]></Title>"
            . "<Description><![CDATA[%s]]></Description>"
            . "<PicUrl><![CDATA[%s]]></PicUrl>"
            . "<Url><![CDATA[%s]]></Url>"
            . "</item>"
            . "<item>"
            . "<Title><![CDATA[%s]]></Title>"
            . "<Description><![CDATA[%s]]></Description>"
            . "<PicUrl><![CDATA[%s]]></PicUrl>"
            . "<Url><![CDATA[%s]]></Url>"
            . "</item>"
            . "<item>"
            . "<Title><![CDATA[%s]]></Title>"
            . "<Description><![CDATA[%s]]></Description>"
            . "<PicUrl><![CDATA[%s]]></PicUrl>"
            . "<Url><![CDATA[%s]]></Url>"
            . "</item>"
            . "</Articles>"
            . "<FuncFlag>4</FuncFlag>"
            . "</xml>";

        $this->picText5 = "<xml>"
            . "<ToUserName><![CDATA[%s]]></ToUserName>"
            . "<FromUserName><![CDATA[%s]]></FromUserName>"
            . "<CreateTime>%d</CreateTime>"
            . "<MsgType><![CDATA[news]]></MsgType>"
            . "<ArticleCount>5</ArticleCount>"
            . "<Articles>"
            . "<item>"
            . "<Title><![CDATA[%s]]></Title>"
            . "<Description><![CDATA[%s]]></Description>"
            . "<PicUrl><![CDATA[%s]]></PicUrl>"
            . "<Url><![CDATA[%s]]></Url>"
            . "</item>"
            . "<item>"
            . "<Title><![CDATA[%s]]></Title>"
            . "<Description><![CDATA[%s]]></Description>"
            . "<PicUrl><![CDATA[%s]]></PicUrl>"
            . "<Url><![CDATA[%s]]></Url>"
            . "</item>"
            . "<item>"
            . "<Title><![CDATA[%s]]></Title>"
            . "<Description><![CDATA[%s]]></Description>"
            . "<PicUrl><![CDATA[%s]]></PicUrl>"
            . "<Url><![CDATA[%s]]></Url>"
            . "</item>"
            . "<item>"
            . "<Title><![CDATA[%s]]></Title>"
            . "<Description><![CDATA[%s]]></Description>"
            . "<PicUrl><![CDATA[%s]]></PicUrl>"
            . "<Url><![CDATA[%s]]></Url>"
            . "</item>"
            . "<item>"
            . "<Title><![CDATA[%s]]></Title>"
            . "<Description><![CDATA[%s]]></Description>"
            . "<PicUrl><![CDATA[%s]]></PicUrl>"
            . "<Url><![CDATA[%s]]></Url>"
            . "</item>"
            . "</Articles>"
            . "<FuncFlag>5</FuncFlag>"
            . "</xml>";
    }

    public function responseMsg()
    {
        TZ_Loader::service('Foundation', 'Wechat')->writeLog("-------into  responseMsg function body----------");
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        TZ_Loader::service('Foundation', 'Wechat')->writeLog($postStr);

        //extract post data
        if (!empty($postStr)) {
            /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
             the best way is to check the validity of xml by yourself */
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);
            switch ($RX_TYPE) {
                case "text":
                    $resultStr = self::doText($postObj);
                    break;
                case "event":
                    $resultStr = self::doEvent($postObj);
                    break;
                default:
                    $resultStr = "";
                    break;
            }
            echo $resultStr;
        } else {
            echo "";
            exit;
        }
    }


    // 用户语音、打字、图片等回复
    private function doText($postObj)
    {
        TZ_Loader::service('Foundation', 'Wechat')->writeLog('开始关键词回复' . date('Y-m-d H:i:s'));
        TZ_Loader::service('Foundation', 'Wechat')->writeLog($postObj);
        //用户的openId
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $userInput = trim($postObj->Content);
        $time = time();
        TZ_Loader::service('Foundation', 'Wechat')->writeLog('用户输入内容：' . $userInput);
        //得到相关公众号配置信息
        $appCode = TZ_Loader::model('UserWx', 'Wechat')->select(['openid:eq' => $fromUsername], 'app_code', 'ROW')['app_code'];
        TZ_Loader::service('Foundation', 'Wechat')->writeLog($appCode);
        $result = TZ_Loader::model('Keywords', 'Wechat')->select(array('status:eq' => 1, 'app_code:eq' => $appCode, 'order' => 'order_no asc,updated_at desc'), '*', 'ALL');
        //TZ_Loader::service('Foundation', 'Wechat')->writeLog($result);
        foreach ($result as $value) {
            $keyword = $value['keyword'];
            $repeat = $value['repeat'];
            $keywords = explode(';', $keyword);
            TZ_Loader::service('Foundation', 'Wechat')->writeLog('数据库中关键词记录：' . $keyword);
            foreach ($keywords as $item) {
                if (false !== strpos($userInput, $item)) {
                    $contentStr = $repeat;
                    TZ_Loader::service('Foundation', 'Wechat')->writeLog('回复内容：' . $contentStr);
                    break 2;
                }
            }
        }
        if (empty($contentStr)) {
            return 'success';
        }

        TZ_Loader::service('Foundation', 'Wechat')->writeLog('结束关键词匹配：' . date('Y-m-d H:i:s'));
        $resultStr = sprintf($this->textTpl, $fromUsername, $toUsername, $time, 'text', $contentStr);
        return $resultStr;
    }

    // 事件相关: 订阅、点击等事件
    private function doEvent($postObj)
    {
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $time = time();

        //根据openId,得到公众号相关信息
        //得到相关公众号配置信息
        $appCode = TZ_Loader::model('UserWx', 'Wechat')->select(['openid:eq' => $fromUsername], 'app_code', 'ROW')['app_code'];
        switch ($postObj->Event) {
            case "subscribe":
                try {
                    $repeatArr = TZ_Loader::model('Keywords', 'Wechat')->select(array('status:eq' => 0, 'app_code:eq' => $appCode), "*", 'ROW');
                    $repeat = $repeatArr['repeat'];
                } catch (Exception $e) {
                    TZ_Loader::service('Foundation', 'Wechat')->writeLog('欢迎语查询失败！');
                }
                $contentStr = $repeat;
                $returnStr = sprintf($this->textTpl, $fromUsername, $toUsername, $time, 'text', $contentStr);
                break;
            case "unsubscribe":
                break;
            case "TEMPLATESENDJOBFINISH":
                $this->handleTemMsgCallback($postObj);
                break;
            case "MASSSENDJOBFINISH":
                $this->handleMassMsgCallback($postObj);
                break;
            case "VIEW":
                break;
            case "CLICK":
                try {
                    $eventKey = $postObj->EventKey;
                    $contentStr = TZ_Loader::model('Keywords', 'Wechat')->select(array('app_code:eq' => $appCode, 'status:eq' => 3, 'keyword:eq' => $eventKey), "`repeat`", 'ROW')['repeat'];
                    TZ_Loader::service('Foundation', 'Wechat')->writeLog($contentStr);
                } catch (Exception $e) {
                    TZ_Loader::service('Foundation', 'Wechat')->writeLog('click 消息回复查询失败！');
                }
                $returnStr = sprintf($this->textTpl, $fromUsername, $toUsername, $time, 'text', $contentStr);
                break;
            default:
                break;
        }
        return $returnStr;
    }


    /**
     * 处理模板消息事件推送
     */
    public function handleTemMsgCallback($postObj)
    {
        TZ_Loader::service('Foundation', 'Wechat')->writeLog($postObj);
        $status = $postObj->Status;
        if ($status == 'success') {
            exit;
        } elseif ($status == 'failed:user block') {
            exit;
        } elseif ($status == 'failed: system failed') {
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $createTime = $postObj->CreateTime;
        }
    }

    /**
     * 处理群发消息事件推送
     */
    public function handleMassMsgCallback($postObj)
    {
        TZ_Loader::service('Foundation', 'Wechat')->writeLog($postObj);
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;

    }


    public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if ($this->checkSignature()) {
            echo $echoStr;
            exit;
        }
    }

    /**
     * 验证消息真实性
     * @return bool
     */
    public function checkSignature()
    {

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = Yaf_Registry::get('config')->wechat->token;
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

}

