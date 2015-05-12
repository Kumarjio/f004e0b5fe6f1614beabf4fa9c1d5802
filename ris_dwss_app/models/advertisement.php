<?php
class Advertisement extends DataMapper {
    
    var $has_one  = array('supplier');

    function __construct($id = NULL) {
        parent::__construct($id);
    }
}
?>
