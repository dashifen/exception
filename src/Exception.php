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
		parent::__construct($message, $this->setCode($code), $previous);
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

		// if our $code is in the array of this exception's constants, then
		// we'll return it.  when it's not, we reset it to the default.  the
		// goal is to provide a list of error codes that can be used in catch
		// blocks -- usually with switch statements -- to differentiate
		// between the same type of exception with differing messages.

		if (!in_array($code, $reflection->getConstants())) {
			$code = $default;
		}
		
		return $code;
	}
}
