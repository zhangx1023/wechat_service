<?php

/**
 * author: mengqi<zhangxuan@showboom.cn>
 * Time: 2016/6/13 12:11
 *
 */
class MessageLogsModel extends TZ_Db_Table
{
    /**
     * construct table
     */
    public function __construct()
    {
        parent::__construct(Yaf_Registry::get('wechat_message_db'), 'wechat_message_db.wechat_message_logs');
    }
}