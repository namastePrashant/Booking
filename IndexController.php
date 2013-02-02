<?php

class Default_IndexController extends Zend_Controller_Action {

    public function init() {
        $this->view->currency = "&euro;";
    }

    public function indexAction() {
        $form = new Admin_Form_BookingForm();
        $this->view->form = $form;
        $extraModel = new Admin_Model_Extra();
        $extras = $extraModel->getAll();
        $this->view->extra = $extras;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $formData['pickup_time'] = $formData['pickup_time'] . ":00:00";
                $formData['return_time'] = $formData['return_time'] . ":00:00";
                unset($formData['submit']);
                unset($formData['booking_id']);
                $session = Zend_Registry::get("defaultsession");
                $session->first = $formData;
                $this->_helper->redirector("info");
            }
        }
    }

    public function infoAction() {
        $form = new Admin_Form_InformationForm();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $session = Zend_Registry::get("defaultsession");
                $firstData = $session->first;
                $formData += $firstData;
                unset($formData['submit']);
                try {
                    $bookingModel = new Admin_Model_Booking();
                    $bookingId = $bookingModel->add($formData);
                    $this->_helper->FlashMessenger->addMessage(array("success" => "Successfully Booking Completed"));
                    $this->_helper->redirector('payment', "index", "default", array("id" => $bookingId));
                } catch (Exception $e) {
                    var_dump($e->getMessage());
                    $this->_helper->FlashMessenger->addMessage(array("error" => $e->getMessage()));
                }
            }
        }
    }

    public function paymentAction() {

        try {
            $config = new Zend_Config_Ini(BASE_PATH . DIRECTORY_SEPARATOR . "configs" . DIRECTORY_SEPARATOR . "class.ini", "production");
            $this->view->payment = $config->payment->toArray();
            $bookingId = $this->_getParam("id");
            $bookingModel = new Admin_Model_Booking();
            $this->view->data = $bookingModel->getDetailById($bookingId);
            $this->view->extras = $bookingModel->getExtras($bookingId);
            $this->view->callbackUrl = 'http://rent.4x4offroads.com/dev/index/success';
        } catch (Exception $e) {
            //  var_dump($e->getMessage());
            $this->_helper->FlashMessenger->addMessage(array("error" => $e->getMessage()));
        }
    }

    public function successAction() {
        
    }

}
