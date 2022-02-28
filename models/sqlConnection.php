<?php
	class SQLConnection {
		//returns a MySQL connection object
		public static function getConnection() {
			//open configuration file
			$configPath = $_SERVER['DOCUMENT_ROOT'].'/ITStepTest/config/mysqlconnection.json';
			$configData = json_decode(file_get_contents($configPath),true);
			//check parameters
			if (isset($configData['server']))
				$server = $configData['server'];
			else {
				echo 'Configuration error, server name not found'; die;
			}
			if (isset($configData['database']))
				$database = $configData['database'];
			else {
				echo 'Configuration error, database name not found'; die;
			}
			if (isset($configData['user']))
				$user = $configData['user'];
			else {
				echo 'Configuration error, username not found'; die;
			}
			if (isset($configData['password']))
				$password = $configData['password'];
			else {
				echo 'Configuration error, password not found'; die;
			}
			/// connection string
			//SQL Server Aut 
			$connectionInfo = array("Database"=>$database, "UID"=>$user, "PWD"=>$password);
			//Windows Aut $connectionInfo = array("Database"=>$database);
			//create connection
			$connection = sqlsrv_connect($server, $connectionInfo);
			//check connection
			if (!$connection) { 
				echo 'Could not connect to SQL Server'; die; 
			}
			//return connection
			return $connection;
		}
	}
?>