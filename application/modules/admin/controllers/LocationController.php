<?php

class Admin_LocationController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        $locationModel = new Admin_Model_Location();
        $this->view->result = $locationModel->getAll();
    }

    public function addAction() {
        $form = new Admin_Form_LocationForm();
        $this->view->form = $form;
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                unset($formData['submit']);
                unset($formData["location_id"]);
                try {
                    $locationModel = new Admin_Model_Location();
                    $locationModel->add($formData);
                    $this->_helper->FlashMessenger->addMessage(array("success" => "Successfully Location added"));
                    $this->_helper->redirector('index');
                } catch (Exception $e) {
                    $this->_helper->FlashMessenger->addMessage(array("error" => $e->getMessage()));
                }
            }
        }
    }

    public function editAction() {

        $form = new Admin_Form_LocationForm();
        $form->submit->setLabel("Save");
        $locationModel = new Admin_Model_Location();
        $id = $this->_getParam('id', 0);
        $data = $locationModel->getDetailById($id);
        $form->populate($data);
        $this->view->form = $form;
        try {
            if ($this->getRequest()->isPost()) {
                if ($form->Valid($this->getRequest()->getPost())) {
                    $formData = $this->getRequest()->getPost();
                    $id = $formData['location_id'];
                    unset($formData['location_id']);
                    unset($formData['submit']);

                    $locationModel->update($formData, $id);
                    $this->_helper->FlashMessenger->addMessage(array("success" => "Successfully Location edited"));
                    $this->_helper->redirector('index');
                }
            }
        } catch (Exception $e) {
           // var_dump($e->getMessage());
            $this->_helper->FlashMessenger->addMessage(array("error" => $e->getMessage()));
        }
    }

    public function deleteAction() {
        $id = $this->_getParam('id', 0);
        $locationModel = new Admin_Model_Location();
        $this->view->id = $id;
        if ($this->getRequest()->isPost()) {
            try {
                $delete = $this->_getParam('delete');
                if ('Yes' == $delete) {
                    $locationModel->delete($id);
                }$this->_helper->redirector("index");
            } catch (Exception $e) {
                $this->view->message = $e->getMessage();
            }
        }
    }

}


