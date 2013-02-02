<?php

class Admin_BookingController extends Zend_Controller_Action {

    public function init() {
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('price-calculation', 'json')
                ->initContext();
    }

//    public function indexAction() {
//        $bookingModel = new Admin_Model_Booking();
//        $this->view->result = $bookingModel->getAll();
//    }
//
//    public function addAction() {
//        $form = new Admin_Form_BookingForm();
//        $this->view->form = $form;
//        if ($this->getRequest()->isPost()) {
//            $formData = $this->getRequest()->getPost();
//            if ($form->isValid($formData)) {
//                unset($formData['submit']);
//                unset($formData['booking_id']);
//                $session = Zend_Registry::get("defaultsession");
//                $session->first = $formData;
//                $this->_helper->redirector("info");
//            }
//        }
//    }
//
//    public function infoAction() {
//        $form = new Admin_Form_InformationForm();
//        $this->view->form = $form;
//        if ($this->getRequest()->isPost()) {
//            $formData = $this->getRequest()->getPost();
//            if ($form->isValid($formData)) {
//                $session = Zend_Registry::get("defaultsession");
//                $firstData = $session->first;
//                $formData += $firstData;
//                unset($formData['submit']);
//                try {
//                    $bookingModel = new Admin_Model_Booking();
//                    $bookingModel->add($formData);
//                    $this->_helper->FlashMessenger->addMessage(array("success" => "Successfully Booking Completed"));
//                    $this->_helper->redirector('index');
//                } catch (Exception $e) {
//                    $this->_helper->FlashMessenger->addMessage(array("error" => $e->getMessage()));
//                }
//            }
//        }
//    }

    public function priceCalculationAction() {
        $pickupLocation = $this->_getParam('pickuplocation');
        $returnLocation = $this->_getParam('returnlocation');
        $number = $this->_getParam('number');
        $days = $this->_getParam('days');
        $priceModel = new Admin_Model_Price();
        $options = $priceModel->getPrice($pickupLocation, $returnLocation);
        $rent = $this->test($days);
        $this->view->number = $number;
        $this->view->rent = $rent;
        $this->view->results = $options;
        $this->view->html = $this->view->render("booking/price-calculation.phtml");
    }

    public function test($days) {

        if ($days == 1) {
            return $rent = 380;
        } elseif ($days >= 2 && $days <= 7) {
            return $rent = $days * 360;
        } elseif ($days >= 8) {
            return $rent = $days * 330;
        }
    }

}

