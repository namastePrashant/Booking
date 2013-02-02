<?php

class Default_IndexController extends Zend_Controller_Action {

    public function init() {

        $this->view->currency = "&euro;";
    }

    public function indexAction() {
        $form = new Admin_Form_BookingForm();
        $this->view->form = $form;
        $postData = '';
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
            $postData = $formData;
        }
        $this->view->postData = $postData;
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
                    $session->first = '';
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
            $this->_helper->FlashMessenger->addMessage(array("error" => $e->getMessage()));
        }
    }

    public function successAction() {
        
    }

    public function infoEditAction() {
        $form = new Admin_Form_InformationForm();
        $form->submit->setLabel("Save");
        $infoModel = new Admin_Model_Booking();
        $bookingId = $this->_getParam('id', 0);
        $data = $infoModel->getDetailById($bookingId);
        $this->view->id = $bookingId;
        $form->populate($data);
        $this->view->form = $form;
        try {
            if ($this->getRequest()->isPost()) {
                if ($form->Valid($this->getRequest()->getPost())) {
                    $formData = $this->getRequest()->getPost();
                    $bookingId = $formData['booking_id'];
                    unset($formData['booking_id']);
                    unset($formData['submit']);
                    $infoModel->update($formData, $bookingId);
                    $this->_helper->FlashMessenger->addMessage(array("success" => "Successfully edited personal information"));
                    $this->_helper->redirector('payment', "index", "default", array("id" => $bookingId));
                }
            }
        } catch (Exception $e) {
            $this->_helper->FlashMessenger->addMessage(array("error" => $e->getMessage()));
        }
    }

    public function editBookingAction() {
        $form = new Admin_Form_BookingForm();
        $form->submit->setLabel("Save");
        $extraModel = new Admin_Model_Extra();
        $extras = $extraModel->getAll();
        $this->view->extra = $extras;
        $bookingModel = new Admin_Model_Booking();
        $bookingId = $this->_getParam('id', 0);
        if ($bookingId) {
            $data = $bookingModel->getDetailById($bookingId);
            $this->view->data = $data;
            $extrabookingModel = new Admin_Model_Extrabooking();
            $postData = $extrabookingModel->getAllbyBookingId($bookingId);
        } else {
            //needs to set index as action $form->setAction("index action");
            $session = Zend_Registry::get("defaultsession");
            $data = $session->first;
            $this->view->data = $data;
            $postData = array();
            if (array_key_exists("extra_id", $data)) {
                foreach ($data['extra_id'] as $key => $val) {
                    $postData[] = $key;
                }
            }
        }
        $form->populate($data);
        $this->view->form = $form;
        try {
            if ($this->getRequest()->isPost()) {
                $formData = $this->getRequest()->getPost();
                if ($form->isValid($formData)) {
                    unset($formData['submit']);
                    $bookingModel->update($formData, $bookingId);
                    $this->_helper->FlashMessenger->addMessage(array("success" => "Successfully edited booking information"));
                    $this->_helper->redirector('info-edit', "index", "default", array("id" => $bookingId));
                }
                if (array_key_exists("extra_id", $formData)) {
                    $extraIds = array();
                    foreach ($formData['extra_id'] as $key => $val) {
                        $extraIds[] = $key;
                    }

                    $postData = $extraIds;
                }
                $this->view->formData = $formData;
            }
            $this->view->postData = $postData;
        } catch (Exception $e) {
            $this->_helper->FlashMessenger->addMessage(array("error" => $e->getMessage()));
        }
    }

}
