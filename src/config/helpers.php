<?php  
    include_once "config.php";

	class Helpers {
		protected $hostname = DB_HOSTNAME;
		protected $username = DB_USERNAME;
		protected $password = DB_PASSWORD;
		protected $dbname   = DB_NAME;
		protected $conn;

		public function __construct() {
			$this->conn = mysqli_connect($this->hostname, $this->username, $this->password, $this->dbname);
		}
		
		public function status() {
			if(!$this->conn ) return mysqli_error($this->conn);
			else  return 'Success';
		}

		public function connect() {
			return $this->conn;
		}

		public function closed() {
			return mysqli_close($this->conn);
		}

		public function find_array($sql) {
			$query = mysqli_query($this->conn, $sql);
			$data = array();

			while ($row = mysqli_fetch_array($query)) {
				$data[] = $row;
			}
			
			return $data;
		}

		public function find_one($sql) {
			$result = mysqli_query($this->conn, $sql);

            if ($result) {
                $row = mysqli_fetch_assoc($result);
                return $row;
            }
		}

		public function search_num($sql) {
			$result = mysqli_query($this->conn, $sql);

			if ($result) {
				$row_count = mysqli_num_rows($result);
				return $row_count;
			}
		}

		public function save_data($sql) {
			$result = mysqli_query($this->conn, $sql);
			return $result;
		}

		public function find_current_id() {
			$result = mysqli_insert_id($this->conn);
			return $result;
		}

		public function escape_string($param) {
			return mysqli_real_escape_string($this->conn, $params);
		}
	}
?>