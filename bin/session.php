<?php 

function getID() {
	return $_SESSION["uid"];
}

function endSession() {
	session_destroy();
}

?>