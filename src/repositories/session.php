<?php

include_once __DIR__ . "/../config.php";
include_once __DIR__ . "/repository.php";
include_once __DIR__ . "/../models/session.php";
include_once __DIR__ . "/../utils/uuid.php";

class CartSessionModelRepository extends BaseRepository {
	final public static function create(string $owner): CartSessionModel|null {
		throw new \Exception("Not implemented yet.");
	}

	final public static function remove(string $owner): bool {
		throw new \Exception("Not implemented yet.");
	}
	
	final public static function find(string $owner): CartSessionModel|null {
		throw new \Exception("Not implemented yet.");
	}
}

?>
