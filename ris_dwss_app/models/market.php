<?php
class Market extends DataMapper {

	var $has_many = array("productcategory", "product");

    function __construct($id = NULL) {
        parent::__construct($id);
    }
}
?>
