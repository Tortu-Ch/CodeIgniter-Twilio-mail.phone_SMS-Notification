<?php

class Paypal_ipn_model extends Crud_model {

    private $table = null;

    function __construct() {
        $this->table = 'paypal_ipn';
        parent::__construct($this->table);
    }

}