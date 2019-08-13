<?php declare(strict_types=1);

/**
 * @author Lukáš Piják 2019 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

namespace BulkGate\Utils;

use BulkGate;

class Exploder
{
    use BulkGate\Strict;

    public static function explode(string $string, string $delimiter = '|', bool $unique = false): array
    {
        if(trim($string) === '')
        {
            return [];
        }

        $output = explode($delimiter, $string);

        return $unique ? array_unique($output) : $output;
    }

    public static function implode(array $array, string $glue = '|'): string
    {
        return implode($glue, $array);
    }
}
