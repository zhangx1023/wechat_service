<?php

/**
 * author: mengqi<zhangxuan@showboom.cn>
 * Time: 2016/6/17 16:41
 *
 */
class TaskController extends Yaf_Controller_Abstract
{
	
	//不用
    public function rpopAction()
    {
        TZ_Loader::service('Repeat','Wechat')->Rpop();
    }
}