<?php

namespace atomita\wordpress\utils\exception;

use Exception;
use WP_Error;

class WordPressException extends Exception {
	protected $error;

	function __construct(WP_Error $error){
		$code = $error->get_error_code();
		parent::__construct($error->get_error_message($code), intval($code));

		$this->error = $error;
	}

	function getError(){
		return $this->error;
	}

	function __get($name){
		return $this->error->$name;
	}

	function __set($name, $value){
		$this->error->$name = $value;
	}

	function __call($method, $args){
		return call_user_func_array([$this->error, $method], $args);
	}
}
