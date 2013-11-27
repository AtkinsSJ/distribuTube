<?php

class Collection implements Countable, Iterator {
	
	private $_table;
	private $_models = array();
	private $_position = 0; // Array iterator

	private $_conditions = array();
	private $_parameters = array();
	private $_sortField;
	private $_sortDirection;
	private $_limit;
	private $_offset;

	public function __construct($table) {
		$this->_table = $table;
		$this->filter("user_id = :userId",
				array('userId' => Model::getUserId()));
	}

	public function filter($condition, $parameters=array()) {
		$this->_conditions[] = $condition;
		$this->_parameters = array_merge($this->_parameters, $parameters);
		
		return $this;
	}

	public function sortBy($field, $direction='ASC') {
		$this->_sortField = $field;
		$this->_sortDirection = $direction;

		return $this;
	}

	public function page($pageNumber, $perPage) {
		$this->_limit = $perPage;
		$this->_offset = $perPage * ($pageNumber-1);

		return $this;
	}

	/**
	 * Runs a custom query using the filters.
	 */
	public function customSelect($target) {
		$db = Model::getDatabase();
		$query = "SELECT {$target}
			FROM {$db->tablePrefix}{$this->_table}
			";

		// WHERE clause
		if (count($this->_conditions) > 0) {
			$conditions = implode($this->_conditions, ' AND ');
			$query .= ' WHERE ' . $conditions;
		}

		$stmt = $db->prepare($query);
		if ( $stmt->execute($this->_parameters) ) {
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} else {
			throw new DatabaseException('Error in customSelect()', $query, $stmt->errorInfo());
		}
	}

	/**
	 * Load all records that fit the current filters.
	 */
	public function load() {
		$db = Model::getDatabase();
		$query = "SELECT *
			FROM {$db->tablePrefix}{$this->_table}
			";

		// WHERE clause
		if (count($this->_conditions) > 0) {
			$conditions = implode($this->_conditions, ' AND ');
			$query .= ' WHERE ' . $conditions;
		}

		// ORDER BY clause
		if ($this->_sortField) {
			$query .= " ORDER BY {$this->_sortField} {$this->_sortDirection} ";
		}

		// LIMIT OFFSET clause
		if ($this->_limit) {
			$query .= " LIMIT {$this->_limit} OFFSET {$this->_offset} ";
		}
		
		$stmt = $db->prepare( $query );

		if ( $stmt->execute( $this->_parameters ) ) {
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			foreach ($result as $record) {
				$this->_models[] = Model::createPopulated($this->_table, $record['id'], $record);
			}
		} else {
			throw new DatabaseException('Could not load database data for records', $query, $stmt->errorInfo());
		}

		return $this; // Chaining
	}

	/**
	 * Update all records that fit the current filters
	 */
	public function update(Array $changes) {
		$db = Model::getDatabase();
		$query = "UPDATE {$db->tablePrefix}{$this->_table}
			SET ";

		$updates = array();
		$params = $this->_parameters;
		foreach ($changes as $key => $value) {
			$updates[] = "{$key} = :{$key}";
			$params[$key] = $value;
		}
		$query .= implode(', ', $updates);

		// WHERE clause
		if (count($this->_conditions) > 0) {
			$conditions = implode($this->_conditions, ' AND ');
			$query .= ' WHERE ' . $conditions;
		}

		echo $query;
	}

// COUNTABLE
	public function count() {
		return count($this->_models);
	}

// ITERATOR
	public function rewind() {
		$this->_position = 0;
	}

	public function current() {
		return $this->_models[$this->_position];
	}

	public function key() {
		return $this->_position;
	}

	public function next() {
		$this->_position++;
	}

	public function valid() {
		return isset($this->_models[$this->_position]);
	}
}