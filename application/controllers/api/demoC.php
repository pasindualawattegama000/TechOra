<?php

require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

use chriskacerguis\RestServer\RestController;

class demoC extends RestController{

    public function index_get(){
        echo "I am the RESTful API";
    }

}


?>