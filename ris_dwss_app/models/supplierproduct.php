<?php
class Supplierproduct extends DataMapper {

    var $has_one  = array("product", "supplier");

    function __construct($id = NULL) {
        parent::__construct($id);
    }
}
?>
