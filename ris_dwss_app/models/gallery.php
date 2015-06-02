<?php
class Gallery extends DataMapper {

	public $table = 'galleries';

    function __construct($id = NULL) {
        parent::__construct($id);
    }

}
?>
