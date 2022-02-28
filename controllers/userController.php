<?php
    //allow access from outside the server
    header('Access-Control-Allow-Origin: *');
    //allow methods
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

    require_once($_SERVER['DOCUMENT_ROOT'].'/AzureTest/models/user.php');

    //GET (Read)
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        //parameters
		if (isset($_GET['id'])) {
            try {
                //create object
                $u = new User($_GET['id']);
                //display
                echo json_encode(array(
                    'status' => 0,
                    'user' => json_decode($u->tojson())
                ));
            }
            catch (RecordNotFoundException $ex) {
                echo json_encode(array(
                    'status' => 1,
                    'errorMessage' => $ex->get_message()
                ));
            }
        }else{
            echo json_encode(array(
              'status' => 0,
              'user' => json_decode(User::getAllJson())
            ));
        }
    }
?>