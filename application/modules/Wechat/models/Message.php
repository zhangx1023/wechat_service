<?php

/**
 * Created by PhpStorm.
 * User: sa
 * Date: 2016/6/12
 * Time: 10:51
 */
class MessageModel extends TZ_Db_Table
{
    /**
     * construct table
     */
    public function __construct()
    {
        parent::__construct(Yaf_Registry::get('wechat_message_db'), 'wechat_message_db.wechat_message');
    }

}