<?php

class School_View_Helper_FlashMessages extends Zend_View_Helper_Abstract {

    protected $flashMessenger;

    public function __construct() {
        $this->flashMessenger = new Zend_Controller_Action_Helper_FlashMessenger();
    }

    public function flashMessages() {
        return $this;
    }

    public function getMessages() {
        $current_messages = $this->flashMessenger->getCurrentMessages();
        $flash_messages = $this->flashMessenger->getMessages();

        $messages = $current_messages + $flash_messages;

        $this->flashMessenger->clearMessages();
        $this->flashMessenger->clearCurrentMessages();

        $structuredMessages = array();
        foreach ($messages as $message) {
            if (is_array($message)) {
                $key = array_keys($message);
                $key = $key[0];
                $value = $message[$key];
            } else {
                $key = 'info';
                $value = $message;
            }
            $structuredMessages[$key][] = $value;
        }

        $output = '';
        foreach ($structuredMessages as $key => $value) {
            $output .= $this->formatMessageList($value, $key);
        }
        return $output;
    }

    public function formatMessageList($messages, $type) {
        if (empty($messages)) {
            return '';
        }

        $output = "<div class='$type'>";
        foreach ($messages as $message) {
            $output .= $message . "<br />";
        }
        $output .= "</div>";

        return $output;
    }

}