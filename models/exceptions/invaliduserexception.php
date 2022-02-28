<?php
	class InvalidUserException extends Exception {
		//attributes
		protected $message;
		
		//getters
		public function get_message() { return $this->message; }
		
		//constructor
		public function __construct($user) {
			$this->message = 'Access denied for user '.$user; 
		}
	}
?>