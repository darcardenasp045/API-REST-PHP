<?php
class Database {
	private string $host = 'localhost';
	private string $database = 'sampledb';
	private string $user = 'root';
	private string $password = '123456';
	private ?PDO $connection = null;

	public function __construct() {
		$this->connect();
	}

	private function connect(): void {
		try {
			$this->connection = new PDO("mysql:host=$this->host;dbname=$this->database", $this->user, $this->password, [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			]);
		} catch (PDOException $e) {
			die("Connection failed: " . $e->getMessage());
		}
	}

	public function getConnection(): ?PDO {
		return $this->connection;
	}
}
?>
