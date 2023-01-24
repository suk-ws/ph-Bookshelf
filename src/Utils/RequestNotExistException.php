<?php

namespace SukWs\Bookshelf\Utils;

use Exception;
use Throwable;

class RequestNotExistException extends Exception {
	
	public function __construct ($message = "", $code = 0, Throwable $previous = null) {
		parent::__construct($message, $code, $previous);
	}
	
}