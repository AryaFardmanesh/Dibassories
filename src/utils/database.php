<?php

include_once __DIR__ . "/../config.php";

class Database {
	private static PDO|null $connection = null;

	private static string|null $error = null;

	final public static function hasError(): bool {
		return Database::$error !== null;
	}

	final public static function getError(): string|null {
		$err = Database::$error;
		Database::$error = null;
		return $err;
	}

	final public static function connect(): bool {
		$servername = DB_SERVERNAME;
		$dbname = DB_NAME;

		try {
			Database::$connection = new PDO(
				"mysql:host=$servername;dbname=$dbname",
				DB_USERNAME,
				DB_PASSWORD
			);
			Database::$connection->setAttribute(
				PDO::ATTR_ERRMODE,
				PDO::ERRMODE_EXCEPTION
			);

			return true;
		} catch (PDOException $err) {
			Database::$error = $err->getMessage();
			return false;
		}
	}

	final public static function close(): void {
		Database::$connection = null;
		Database::$error = null;
	}

	final public static function query(string $sql, array $options = []): PDOStatement|null {
		try {
			$stmt = Database::$connection->prepare($sql, $options);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt;
		} catch (PDOException $err) {
			Database::$error = $err->getMessage();
			return null;
		}
	}
}

?>
