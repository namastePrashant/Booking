<?php

class Admin_Form_PriceForm extends Zend_Form {

    public function init() {
        $priceid = new Zend_Form_Element_Hidden("price_id");
        $locationModel = new Admin_Model_Location();
        $locations = $locationModel->getAllLocation();
        $fromLocation = new Zend_Form_Element_Select("from_location_id");
        $fromLocation->setLabel("From Location")
                ->addMultiOptions($locations)
                ->setAttribs(array('class' => 'form-select',))
                ->setRequired(true);
        $toLocation = new Zend_Form_Element_Select('to_location_id');
        $toLocation->setLabel('To Location')
                ->addMultiOptions($locations)
                ->setAttribs(array('class' => 'form-select',))
                ->setRequired(true);

        $price = new Zend_Form_Element_Text("price");
        $price->setLabel("Price ")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);
        $submit = new Zend_Form_Element_Submit("submit");
        $submit->setLabel("Submit");

        $this->addElements(array(
            $priceid,
            $fromLocation,
            $toLocation,
            $price,
            $submit));
    }

}

