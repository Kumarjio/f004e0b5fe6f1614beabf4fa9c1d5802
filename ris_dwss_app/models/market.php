<?php
class Market extends DataMapper {

	var $has_many = array("productcategory", "product", "supplier", 'staff');

    function __construct($id = NULL) {
        parent::__construct($id);
    }
}
?>
