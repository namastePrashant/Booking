<?php

class Admin_IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        $priceModel = new Admin_Model_Price();
        $this->view->result = $priceModel->getAll();
    }

    public function addAction() {
        $form = new Admin_Form_PriceForm();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                unset($formData['submit']);
                unset($formData["price_id"]);
                try {
                    $priceModel = new Admin_Model_Price();
                    $priceModel->add($formData);
                    $this->_helper->FlashMessenger->addMessage(array("success" => "Successfully Price added"));
                    $this->_helper->redirector('index');
                } catch (Exception $e) {
                    $this->_helper->FlashMessenger->addMessage(array("error" => $e->getMessage()));
                }
            }
        }
    }

    public function editAction() {

        $form = new Admin_Form_PriceForm();
        $form->submit->setLabel("Save");
        $priceModel = new Admin_Model_Price();
        $id = $this->_getParam('id', 0);
        $data = $priceModel->getDetailById($id);
        $form->populate($data);
        $this->view->form = $form;
        try {
            if ($this->getRequest()->isPost()) {
                if ($form->Valid($this->getRequest()->getPost())) {
                    $formData = $this->getRequest()->getPost();
                    $id = $formData['price_id'];
                    unset($formData['price_id']);
                    unset($formData['submit']);

                    $priceModel->update($formData, $id);
                    $this->_helper->FlashMessenger->addMessage(array("success" => "Successfully Price edited"));
                    $this->_helper->redirector('index');
                }
            }
        } catch (Exception $e) {
            $this->_helper->FlashMessenger->addMessage(array("error" => $e->getMessage()));
        }
    }

    public function deleteAction() {
        $id = $this->_getParam('id', 0);
        $priceModel = new Admin_Model_Price();
        $this->view->id = $id;
        if ($this->getRequest()->isPost()) {
            try {
                $delete = $this->_getParam('delete');
                if ('Yes' == $delete) {
                    $priceModel->delete($id);
                }$this->_helper->redirector("index");
            } catch (Exception $e) {
                $this->view->message = $e->getMessage();
            }
        }
    }

}
