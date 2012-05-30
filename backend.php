<?php
try {
	error_reporting(E_ALL|E_STRICT);

	function myErrorHandler($errno, $errstr, $errfile, $errline) {
		throw new Exception("$errno $errstr at $errfile:$errline");
	}
	set_error_handler("myErrorHandler");
	function my_exception_handler($e) {
		header("Content-Type: text/javascript");
		header("Status: 400 Bad Request");

		$data = array(
			'message' => $e->getMessage(),
			'code' => $e->getCode(),
			'file' => $e->getFile(),
			'line' => $e->getLine()
		);

		$stack = $e->getTrace();
		if(count($stack) !== 0) {
			$data['trace'] = array();
			foreach($stack as $tmp) { $data['trace'][] = $tmp; }
		}

		echo json_encode($data) . "\n";
		exit;
	}
	set_exception_handler('my_exception_handler');

	if(!file_exists('config.php')) { throw new Exception('No configuration!'); }
	require_once(__DIR__ . '/config.php');

	/* Setup MySQL */
	class SQL {
		static private $mysqli = null;
		static public function init() {
			if(is_null($this->mysqli)) {
				$this->mysqli = mysqli_connect(SQL_HOSTNAME, SQL_USERNAME, SQL_PASSWORD, SQL_DATABASE);
				if($this->mysqli->connect_error) {
					throw new Exception('SQL connection failed: ' . $this->mysqli->connect_error);
				}
			}
			return $this->mysqli;
		}
	}

	if(isset($_POST['send_msg']) && isset($_POST['msg'])) {
		$msg = $_POST['msg'];
		$sql = SQL::init();
		if( $sql->query('INSERT INTO `' . SQL_DATABASE . 'log` (msg) VALUES (' . $sql->escape_string($msg) . ')') === FALSE) {
			throw new Exception('SQL error: ' . $sql->error());
		}
		echo 'OK';
		return;
	}

	throw new Exception('Unknown request');
} catch(Exception $e) {
	my_exception_handler($e);
}
return;
?>
