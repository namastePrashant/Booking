<?php

class Admin_Form_InformationForm extends Zend_Form {

    public function init() {
        $bookingid = new Zend_Form_Element_Hidden("booking_id");
        $firstName = new Zend_Form_Element_Text("first_name");
        $firstName->setLabel("First Name")
                ->setAttribs(array('size' => 30, 'class' => 'form-text',))
                ->setRequired(true);
        $lastName = new Zend_Form_Element_Text('last_name');
        $lastName->setLabel('Last Name')
                ->setAttribs(array('size' => 30, 'class' => 'form-select',))
                ->setRequired(true);

        $emailAddress = new Zend_Form_Element_Text("email_address");
        $emailAddress->setLabel("Email Address")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);

        $telephoneNo = new Zend_Form_Element_Text("telephone_no");
        $telephoneNo->setLabel("Telephone Number")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);

        $address = new Zend_Form_Element_Text("address");
        $address->setLabel("Address")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);
        $nextAddress = new Zend_Form_Element_Text("next_address");
        $nextAddress->setLabel("Next Address")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'));
        $postalCode = new Zend_Form_Element_Text("postal_code");
        $postalCode->setLabel("Postal Code")
                ->setAttribs(array('size' => 30,'class' => 'form-text'))
                ->setRequired(true);

        $city = new Zend_Form_Element_Text("city");
        $city->setLabel("City")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);
        $country = new Zend_Form_Element_Text("country");
        $country->setLabel("Country")
                ->setAttribs(array('size' => 30, 'class' => 'form-text'))
                ->setRequired(true);
       
        $submit = new Zend_Form_Element_Submit("submit");
        $submit->setLabel("Submit");

        $this->addElements(array(
            $bookingid,
            $firstName,
            $lastName,
            $emailAddress,
            $telephoneNo,
            $address,
            $nextAddress,
            $postalCode,
            $city,
            $country,
            $submit));
    }

}

