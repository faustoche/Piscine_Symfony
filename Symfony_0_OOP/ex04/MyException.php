<?php

class MyException extends Exception {
	public function errorMessage() {
		$errorMsg = 'Undefined';
		return $errorMsg;
	}
}

?>