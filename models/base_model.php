<?php

namespace Models;

class BaseModel {
	protected $connection;

	function __construct() {
		$this->connection = DbConnect::connect();
	}
	function __destruct() {
		$this->connection = DbConnect::closeConnection();
	}

	/**
	 * Insert into the database
	 *
	 * @param string $table_name
	 * @param array $data An associated array of the table column names as keys and the report data as the values.
	 *
	 * @return boolean
	 */
	public function insert($table_name, $data) {
		$keys = array_keys($data);
		$fields = implode(",", $keys);

		$placeholders = str_repeat('?,', count($keys) - 1) . '?';

		// $values = array_values($data);
		$query = "INSERT INTO $table_name ($fields)
		VALUES ($placeholders)";

		$prepare = $this->connection->prepare($query);
		return $prepare->execute(array_values($data));
	}

	/**
	 * Get the last inserted ID.
	 *
	 * @return string|false The ID
	 */
	public function get_last_id() {
		$query = "SELECT LAST_INSERT_ID()";

		$results = $this->connection->query($query);
		return $results->fetchColumn();
	}

	/**
	 * Select all rows and columns from specified table
	 *
	 * @param string $table_name The table name
	 * @return array
	 */
	public function select_all($table_name) {

		$query = "SELECT * FROM $table_name";

		$results = $this->connection->query($query);
		return $results->fetchAll();
	}

	public function select_one($table_name, $column, $where) {
		$key = array_keys($where)[0];

		$query = "SELECT $column FROM $table_name WHERE $key = :val";

		$prepare = $this->connection->prepare($query);
		$prepare->bindValue(":val", $where[$key]);

		$prepare->execute();
		
		return $prepare->fetch();
	}
	public function select_user($email) {

		$query = "SELECT * FROM user INNER JOIN user_login ON user.id = user_login.user_id WHERE user_login.email = :val";

		$prepare = $this->connection->prepare($query);
		$prepare->bindValue(":val", $email);

		$prepare->execute();
		
		return $prepare->fetch();
	}
}
