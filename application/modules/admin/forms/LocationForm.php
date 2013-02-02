<?php

class Admin_Form_LocationForm extends Zend_Form {

    public function init() {
        $locationid = new Zend_Form_Element_Hidden("location_id");
        $location = new Zend_Form_Element_Text("name");
        $location->setLabel("Location ")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);
        $submit = new Zend_Form_Element_Submit("submit");
        $submit->setLabel("Submit");

        $this->addElements(array(
            $locationid,
            $location,
            $submit));
    }

}

