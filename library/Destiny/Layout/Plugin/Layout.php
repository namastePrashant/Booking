<?php

class Destiny_Layout_Plugin_Layout extends Zend_Controller_Plugin_Abstract {

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $module = $request->getModuleName();
        $module = "admin";
        $options = array(
            'layoutPath' => BASE_PATH . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . $module,
        );
        Zend_Layout::startMvc()->setLayoutPath($options);
    }
}
