<?php
    //use files
    require_once('sqlConnection.php');
    require_once('exceptions/recordnotfoundexception.php');
    require_once('exceptions/invaliduserexception.php');

    //class name
    class User{
        //attributes
        private $id;
        private $name;
        private $lastname;
        private $phone;
        private $dateOfBirth;
        
        //getters and setters
        public function getId() { return $this->id; }
        public function setId($value) { $this->id = $value; }
        public function getName() { return $this->name; }
        public function setName($value) { $this->name = $value; }
        public function getLastname() { return $this->lastname; }
        public function setLastname($value) { $this->lastname = $value; }
        public function getPhone() { return $this->phone; }
        public function setPhone($value) { $this->phone = $value; }
        public function getDateOfBirth() { return $this->dateOfBirth; }
        public function setDateOfBirth($value) { $this->dateOfBirth = $value; }

        //constructor
        public function __construct() {
            //empty object
            if (func_num_args() == 0) {
                $this->id = 0;
                $this->name = "";
                $this->lastname = "";
                $this->phone = "";
                $this->dateOfBirth = "";
            }
            //object with data from database
            if (func_num_args() == 1) {
                //get job number
                $id = func_get_arg(0);
                //get connection
                $connection = SqlConnection::getConnection();
                //query
                $query = "Select Id, Name, Lastname, Phone, DateOfBirth From Users Where Id = '$id'";
                //command
                $command = sqlsrv_query($connection, $query);
                if($command){
                    while($row = sqlsrv_fetch_array($command)){
                        $this->id = $row['Id'];
                        $this->name = $row['Name'];
                        $this->lastname = $row['Lastname'];
                        $this->phone = $row['Phone'];
                        $this->dateOfBirth = $row['DateOfBirth'];
                    }
                    sqlsrv_free_stmt($command);
                }else{
                    throw new RecordNotFoundException($id);
                }
            }

            //object with data from arguments
            if (func_num_args() == 5) {
                //get arguments
                $arguments = func_get_args();
                //pass arguments to attributes
                $this->id = $arguments[0];
                $this->name = $arguments[1];
                $this->lastname = $arguments[2];
                $this->phone = $arguments[3];
                $this->dateOfBirth = $arguments[4];
            }
        }

        //represents the object in JSON format
        public function toJson() {
            return  json_encode(array(
                'id' => $this->id,
                'name' => $this->name,
                'lastname' => $this->lastname,
                'phone' => $this->phone,
                'dateOfBirth' => $this->dateOfBirth
            ));
        }

        //get all
        public static function getAll(){
            //list
            $list = array();
            //get connection
            $connection = SqlConnection::getConnection();
            //query
            $query = "Select Id, Name, Lastname, Phone, DateOfBirth From Users Order By Name Asc";
            //command
            $command = sqlsrv_query($connection, $query);
            //execute
            if($command){
                while($row = sqlsrv_fetch_array($command)){
                    array_push($list, new User($row['Id'], $row['Name'], $row['Lastname'], $row['Phone'], $row['DateOfBirth']));
                }
                sqlsrv_free_stmt($command);
            }else{
                $list = 'Empty list';
            }
            return $list;
        }

        //get all in JSON format
        public static function getAllJson() {
            //list
            $list = array();
            //get all
            foreach(self::getAll() as $item) {
                array_push($list, json_decode($item->toJson()));
            }
            //return json encoded array
            return json_encode($list);
        }
    }
?>