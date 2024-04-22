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
	public function select_all($table_name, $where = null) {
		$where_clause = "";
		
		if (!is_null($where)) {
			$key = array_keys($where)[0];
			$where_clause = "WHERE $key = :val";
		}

		$query = "SELECT * FROM $table_name $where_clause";

		$prepare = $this->connection->prepare($query);

		if (!is_null($where)) {
			$prepare->bindValue(":val", $where[$key]);
		}

		$prepare->execute();

		return $prepare->fetchAll();
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
	
	public function delete($type, $id) {
		
		$query = "DELETE FROM $type WHERE id = :id";

		$prepare = $this->connection->prepare($query);
		$prepare->bindValue(":id", $id);

		return $prepare->execute();
	}

	public function update($table_name, $data, $where) {
		$values = array_merge(array_values($data), array_values($where));
		
		$data_keys = array_keys($data);
		$fields = implode(" = ?, ", $data_keys);
		// Add to the last key
		$fields .= " = ?";

		


		$where_keys = array_keys($where);
		$last_key = end($where_keys);
		$where_clause = "";

		foreach ($where as $key => $value) {
			$where_clause .= $key . " = ?";

			if (count($where) > 1 && $key != $last_key) {
				$where_clause .= " AND ";
			}
		}
		
		$query = "UPDATE $table_name SET $fields WHERE $where_clause";

		echo $query;

		$prepare = $this->connection->prepare($query);
		return $prepare->execute(array_values($values));
	}
}
