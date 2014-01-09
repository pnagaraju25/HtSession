<?php

namespace HtSession;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container as SessionContainer;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $sm = $e->getApplication()->getServiceManager();
        $sessionManager = $sm->get('HtSession\Session\Manager');
        $sessionBootstraper = new Session\BootstrapSession($sessionManager);
        $sessionBootstraper->bootstrap(); 
    }


    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            "Zend\Loader\ClassMapAutoloader" => array(
                __DIR__ . "/autoload_classmap.php",
            ),
            "Zend\Loader\StandardAutoloader" => array(
                "namespaces" => array(
                    __NAMESPACE__ => __DIR__ . "/src/" . __NAMESPACE__,
                ),
            ),
        );
    }
    

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'HtSession\Session\Manager' => 'HtSession\Factory\SessionManagerFactory',
                'HtSession\ModuleOptions' => 'HtSession\Factory\ModuleOptionsFactory',
                'HtSession\DefaultSessionSetSaveHandler' => 'HtSession\Factory\SessionSetSaveHandlerFactory'
            ),
            'aliases' => array(
                'HtSession\SessionSetSaveHandler' => 'HtSession\DefaultSessionSetSaveHandler',
                'HtSessionDbAdapter' => 'Zend\Db\Adapter\Adapter',
            )
        );
    }

}
