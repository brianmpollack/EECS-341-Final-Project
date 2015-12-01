<?php
class MySql {
	public static function getConnection(){
		require("mysql_credentials.php");
		$mysqli = new mysqli(MySqlCredentials::HOSTNAME, MySqlCredentials::USERNAME, MySqlCredentials::PASSWORD, MySqlCredentials::DATABASE);
		if($mysqli->connect_error){
			trigger_error("Oops. There was an error. We could not connect to the server. Error number: ".$mysqli->connect_errno, E_USER_ERROR);
		}
		return $mysqli;
	}
}
?>