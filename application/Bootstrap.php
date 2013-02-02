<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function _initSession()
    {
        Zend_Session::start();
        $defaultNameSpace = new Zend_Session_Namespace("defaultsession");
        $defaultNameSpace->setExpirationSeconds(7200);
        Zend_Registry::set("defaultsession",$defaultNameSpace);
    }
}

