<?php

include_once __DIR__ . "/../config.php";
include_once __DIR__ . "/repository.php";
include_once __DIR__ . "/../models/sessions.php";
include_once __DIR__ . "/../utils/uuid.php";

class CartSessionRepository extends BaseRepository {
	final public static function create(string $owner): CartSessionModel|null {
		if (!CartSessionRepository::dbConnect()) {
			CartSessionRepository::setError(Database::getError());
			goto failed;
		}

		$model = new CartSessionModel(
			uuid(),
			$owner
		);

		if ($model->hasError()) {
			CartSessionRepository::setError($model->getError());
			goto failed;
		}

		$id = $model->id;
		$status = $model->status;

		Database::query(
			"INSERT INTO `dibas_cart_sessions` (
				`id`,
				`owner`,
				`status`,
				`created_at`
			) VALUES (
				'$id',
				'$owner',
				$status,
				CURRENT_TIMESTAMP()
			);"
		);

		if (Database::hasError()) {
			CartSessionRepository::setError(Database::getError());
			goto failed;
		}

		Database::close();
		return $model;

		failed:
			Database::close();
			return null;
	}

	final public static function remove(string $owner): bool {
		if (!CartSessionRepository::dbConnect()) {
			CartSessionRepository::setError(Database::getError());
			Database::close();
			return false;
		}

		Database::query(
			"DELETE FROM `dibas_cart_sessions` WHERE `dibas_cart_sessions`.`owner` = '$owner';"
		);

		Database::close();
		return true;
	}
	
	final public static function find(string $owner): CartSessionModel|null {
		if (!CartSessionRepository::dbConnect()) {
			CartSessionRepository::setError(Database::getError());
			goto failed;
		}

		$row = Database::query(
			"SELECT * FROM `dibas_cart_sessions` WHERE `dibas_cart_sessions`.`owner` = '$owner';"
		)->fetch();

		if (Database::hasError()) {
			CartSessionRepository::setError(Database::getError());
			goto failed;
		}

		if ($row === FALSE) {
			goto failed;
		}

		$model = new CartSessionModel(
			$row["id"],
			$row["owner"],
			(int)$row["status"],
			new DateTimeImmutable($row["created_at"])
		);

		if ($model->hasError()) {
			CartSessionRepository::setError($model->getError());
			goto failed;
		}

		Database::close();
		return $model;

		failed:
			Database::close();
			return null;
	}
}

?>
