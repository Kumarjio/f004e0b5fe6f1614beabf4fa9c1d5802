<?php
class Productcategory extends DataMapper
{
    
    var $table = 'productcategories';
    var $has_many = array("product");
    var $has_one  = array("market");

    function __construct($id = NULL) {
        parent::__construct($id);
    }
    
}
?>
