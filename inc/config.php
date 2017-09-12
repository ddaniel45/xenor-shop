<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

	class db {
		private $db;
		function __construct($host,$user,$pwd) {  
			try {
				$this->db = new PDO('mysql:host='.$host.';dbname=xenor-shop', $user, $pwd);
			} catch(PDOException $e) {
				exit("Error occured while connecting.");
			}
		}
		
		function getConnection() {
			if(!$this->db) exit("Connection error.");
			return $this->db;
		}
	}
	
?>
