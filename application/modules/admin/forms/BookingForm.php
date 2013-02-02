<?php

class Admin_Form_BookingForm extends Zend_Form {
    public function init() {
        $bookingid = new Zend_Form_Element_Hidden("booking_id");
        $priceModel = new Admin_Model_Price();
        $fromOption = $priceModel->getAllLocation();
        $toOption = $priceModel->getAllLocation(true);
        $numberOption = array();
        for ($i = 1; $i <= 20; $i++) {
            $numberOption[$i] = $i;
        }
        $timeOption = array();
        for ($j = 0; $j <= 23; $j++) {
            $timeOption[$j] = (strlen($j) == 1) ? "0" . $j . ":00" : $j . ":00";
        }

        $pickupLocation = new Zend_Form_Element_Select("pickup_location");
        $pickupLocation->setLabel("Pickup Location")
                ->setAttribs(array('class' => 'form-select', 'id' => 'pickup-location'))
                ->addmultiOptions($fromOption)
                ->setRequired(true);
        $returnLocation = new Zend_Form_Element_Select('return_location');
        $returnLocation->setLabel('Return Location')
                ->setAttribs(array('class' => 'form-select', 'id' => 'return-location'))
                ->addmultiOptions($toOption)
                ->setRequired(true);

        $number = new Zend_Form_Element_Select("number");
        $number->setLabel("Number Of Vehicals")
                ->setAttribs(array('class' => 'form-select'))
                ->addmultiOptions($numberOption)
                ->setRequired(true);
        $pickupDate = new Zend_Form_Element_Text("pickup_date");
        $pickupDate->setLabel("Pickup Date")
                ->setAttribs(array('class' => 'form-text'))
                ->setRequired(true);

        $returnDate = new Zend_Form_Element_Text("return_date");
        $returnDate->setLabel("Return Date")
                ->setAttribs(array('class' => 'form-text'))
                ->setRequired(true);
        $pickuptime = new Zend_Form_Element_Select("pickup_time");
        $pickuptime->setLabel("Pickup Time")
                ->setAttribs(array('class' => 'form-number-select'))
                ->addmultiOptions($timeOption)
                ->setRequired(true);

        $returnTime = new Zend_Form_Element_Select("return_time");
        $returnTime->setLabel("Return Time")
                ->setAttribs(array('class' => 'form-number-select'))
                ->addmultiOptions($timeOption)
                ->setRequired(true);
        $submit = new Zend_Form_Element_Submit("submit");
        $submit->setLabel("Book Now");
        $this->addElements(array(
            $bookingid,
            $pickupLocation,
            $returnLocation,
            $number,
            $pickupDate,
            $pickuptime,
            $returnDate,
            $returnTime,
            $submit));
        $this->setElementDecorators(array(
            'viewHelper',
            'Errors',
        ));
        $submit->setDecorators(array(
            'viewHelper',
            'Errors',
            array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'submit-wrapper')),
            array('Label', array('tag' => 'div')),
        ));
        $submit->removeDecorator("label");
    }

}

