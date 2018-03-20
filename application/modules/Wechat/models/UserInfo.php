<?php

/**
 * Created by PhpStorm.
 * User: sa
 * Date: 2016/6/12
 * Time: 10:51
 */
class UserInfoModel extends TZ_Db_Table
{
    /**
     * construct table
     */
    public function __construct()
    {
        parent::__construct(Yaf_Registry::get('share_device_db'), 'share_device_db.user_info');
    }

}