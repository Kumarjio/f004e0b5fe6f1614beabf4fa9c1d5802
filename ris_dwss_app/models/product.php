<?php
class Product extends DataMapper{

	var $has_many = array('productrate', 'supplierproduct');
    var $has_one  = array('market', 'productcategory');

    function __construct($id = NULL) {
        parent::__construct($id);
    }
    
}
?>
