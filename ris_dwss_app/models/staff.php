<?php
class Staff extends DataMapper {

	var $table = 'stafves';
	var $has_one  = array('market');

	function __construct($id = NULL) {
        parent::__construct($id);
    }
}
?>
