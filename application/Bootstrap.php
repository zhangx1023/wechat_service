<?php

/**
 * bootstrap file
 * 
 * @author vincent <vincent@747.cn>
 * @final 2013-5-10
 */
class Bootstrap extends Yaf_Bootstrap_Abstract {

    /**
     * data
     */
    private $_config = null;

    /**
     * config init
     */
    public function _initConfig() {
        $this->_config = Yaf_Application::app()->getConfig();
        Yaf_Registry::set('config', $this->_config);
    }

    /**
     * loader config
     */
    public function _initLoader() {
        $loader = new TZ_Loader;
        Yaf_Registry::set('loader', $loader);
    }

    /**
     * plug config
     */
    public function _initPlugin(Yaf_Dispatcher $dispatcher) {
        $routerPlugin = new RouterPlugin();
        $dispatcher->registerPlugin($routerPlugin);
    }

    /**
     * view config 
     */
    public function _initView(Yaf_Dispatcher $dispatcher) {
        defined('STATIC_SERVER') or define('STATIC_SERVER', $this->_config->static->server);
        defined('STATIC_VERSION') or define('STATIC_VERSION', md5(date('Ymd')));
          defined('STATIC_PATH') or define('STATIC_PATH', $this->_config->application->baseUri);
        $dispatcher->disableView();
    }

    /**
     * db config
     */
    public function _initDb() {
        //card_db
        $wxDb = $this->_config->database->wechat_message_db;
        $wxMaster = $wxDb->master->toArray();
        $wxSlave = !empty($wxDb->slave) ? $wxDb->slave->toArray() : null;
        $wxDb = new TZ_Db($wxMaster, $wxSlave, $wxDb->driver);
        Yaf_Registry::set('wechat_message_db', $wxDb);

        //card_db
        $userDb = $this->_config->database->user_center_db;
        $userMaster = $userDb->master->toArray();
        $userSlave = !empty($userDb->slave) ? $userDb->slave->toArray() : null;
        $userDb = new TZ_Db($userMaster, $userSlave, $userDb->driver);
        Yaf_Registry::set('user_center_db', $userDb);

         $sharedeviceDb = $this->_config->database->share_device_db;
        $sharedeviceMaster = $sharedeviceDb->master->toArray();
        $sharedeviceSlave = !empty($sharedeviceDb->slave) ? $sharedeviceDb->slave->toArray() : null;
        $sharedeviceDb = new TZ_Db($sharedeviceMaster, $sharedeviceSlave, $sharedeviceDb->driver);
        Yaf_Registry::set('share_device_db', $sharedeviceDb);
    }

    /**
     * Init library
     *
     * @return void
     */
    public function _initLibrary() {
    
    }

}

/**
 * RouterPlugin.php
 */
class RouterPlugin extends Yaf_Plugin_Abstract {

    public function routerStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
        
    }

    public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
        
    }

    public function dispatchLoopStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
        $view = new TZ_View();
        $view->setCacheEnable(true);
        $view->setScriptPath(APP_PATH . '/application/modules/' . $request->getModuleName() . '/views');
        Yaf_Dispatcher::getInstance()->setView($view);
    }

    public function preDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
        
    }

    public function postDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {        
    }

    public function dispatchLoopShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
        
    }

}

/**
 * 返回商品数据
 * @return type
 */
function getProductList() {
    return array(
        1 => '手由宝一台',
        2 => '200元京东店铺代金劵',
        3 => '200元微商城店铺代金劵',
        4 => '100元京东店铺代金劵',
        5 => '100元微商城店铺代金劵',
        6 => '20元微商城店铺代金劵'
    );
}



//tools
function d($params) {
    echo '<pre>';
    var_dump($params);
    echo '</pre>';
}

function error_404() {
    die(header('Location:/error/notfound'));
}

