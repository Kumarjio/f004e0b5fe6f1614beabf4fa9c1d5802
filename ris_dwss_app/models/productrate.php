<?php
class Productrate extends DataMapper {

	var $has_one  = array("product");

    function __construct($id = NULL) {
        parent::__construct($id);
    }
    
}
?>
