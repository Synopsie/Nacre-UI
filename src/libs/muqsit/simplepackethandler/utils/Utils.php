<?php

/*
 *  ____   __   __  _   _    ___    ____    ____    ___   _____
 * / ___|  \ \ / / | \ | |  / _ \  |  _ \  / ___|  |_ _| | ____|
 * \___ \   \ V /  |  \| | | | | | | |_) | \___ \   | |  |  _|
 *  ___) |   | |   | |\  | | |_| | |  __/   ___) |  | |  | |___
 * |____/    |_|   |_| \_|  \___/  |_|     |____/  |___| |_____|
 *
 * Nacre-UI est une API destiné aux formulaires,
 * elle permet aux développeurs d'avoir une compatibilité entre toutes les interfaces,
 * mais aussi éviter les taches fastidieuses à faire.
 *
 * @author Synopsie
 * @link https://nacre.arkaniastudios.com/home.html
 * @version 2.0.5
 *
 */

declare(strict_types=1);

namespace nacre\libs\muqsit\simplepackethandler\utils;

use Closure;
use InvalidArgumentException;
use ReflectionFunction;
use ReflectionNamedType;

use function count;
use function implode;
use function is_a;

final class Utils {
	/**
	 * @param string[] $params
	 * @return string[]
	 */
	public static function parseClosureSignature(Closure $closure, array $params, string $return_type) : array {
		/** @noinspection PhpUnhandledExceptionInspection */
		$method = new ReflectionFunction($closure);
		$type   = $method->getReturnType();
		if(!($type instanceof ReflectionNamedType) || $type->allowsNull() || $type->getName() !== $return_type) {
			throw new InvalidArgumentException("Return value of {$method->getName()} must be {$return_type}");
		}

		$parsed_params = [];
		$parameters    = $method->getParameters();
		if(count($parameters) === count($params)) {
			$parameter_index = 0;
			foreach($parameters as $parameter) {
				$parameter_type    = $parameter->getType();
				$parameter_compare = $params[$parameter_index++];
				if($parameter_type instanceof ReflectionNamedType && !$parameter_type->allowsNull() && is_a($parameter_type->getName(), $parameter_compare, true)) {
					$parsed_params[] = $parameter_type->getName();
					continue;
				}
				break;
			}

			if(count($parsed_params) === count($params)) {
				return $parsed_params;
			}
		}

		throw new InvalidArgumentException("Closure must satisfy signature (" . implode(", ", $params) . ") : {$return_type}");
	}

}
