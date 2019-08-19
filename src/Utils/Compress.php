<?php declare(strict_types=1);

/**
 * @author Lukáš Piják 2019 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

namespace BulkGate\Utils;

use BulkGate;

class Compress
{
	use BulkGate\Strict;

	/**
	 * @param $data
	 * @param int $encoding_mode
	 * @return string
	 */
	public static function compress($data, int $encoding_mode = 9): string
	{
		return base64_encode(gzencode(serialize($data), $encoding_mode));
	}


	/**
	 * @param string $data
	 * @return mixed
	 */
	public static function decompress($data)
	{
		return unserialize(gzdecode(base64_decode($data)));
	}
}
