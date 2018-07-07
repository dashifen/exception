<?php

namespace Dashifen\Exception;

use Throwable;
use ReflectionClass;
use ReflectionException;

class Exception extends \Exception {
	const UNKNOWN_ERROR = 0;

	/**
	 * Exception constructor
	 *
	 * Ensures that the $code parameter is this object's UNKNOWN_ERROR or
	 * on of its children's other constants.
	 *
	 * @param string         $message
	 * @param int            $code
	 * @param Throwable|null $previous
	 *
	 * @throws ReflectionException
	 */
	public function __construct($message = "", $code = 0, Throwable $previous = null) {
		$code = $this->setCode($code);
		parent::__construct($message, $code, $previous);
	}

	/**
	 * setCode
	 *
	 * Either returns $code unchanged, or sets it to $default if it is not
	 * found within this object's (or one of its children's) constants.
	 *
	 * @param int $code
	 * @param int $default
	 *
	 * @return int
	 * @throws ReflectionException
	 */
	protected function setCode(int $code, int $default = self::UNKNOWN_ERROR): int {
		$reflection = new ReflectionClass($this);
		if (!in_array($code, $reflection->getConstants())) {
			$code = $default;
		}
		
		return $code;
	}
}
