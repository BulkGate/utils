<?php declare(strict_types=1);

/**
 * @author Lukáš Piják 2018 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

namespace BulkGate\Utils;

use BulkGate;

class Json
{
	use BulkGate\Strict;

	public static function encode($data, $options = null): string
	{
		$json = json_encode($data, $options ?? (JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRESERVE_ZERO_FRACTION));

		if($error = json_last_error())
		{
			throw new JsonException(json_last_error_msg(), $error);
		}

		return $json;
	}

	public static function decode(string $json, bool $force_array = false)
	{
		$data = json_decode($json, $force_array, 512, JSON_BIGINT_AS_STRING);

		if($error = json_last_error())
		{
			throw new JsonException(json_last_error_msg(), $error);
		}

		return $data;
	}
}
