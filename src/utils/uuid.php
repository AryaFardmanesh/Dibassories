<?php

function uuid(): string {
	$id = uniqid() . uniqid() . uniqid();
	return substr( $id, 0, 32 );
}

?>
