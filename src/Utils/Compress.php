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
    public static function compress($data, int $encoding_mode = 9): ?string
    {
        $data = gzencode(serialize($data), $encoding_mode);

        if ($data !== false)
        {
            return base64_encode($data);
        }

        return null;
    }


    /**
     * @param string $data
     * @return mixed
     */
    public static function decompress(string $data)
    {
        $data = base64_decode($data);

        if ($data !== false)
        {
            $data = gzdecode($data);

            if ($data !== false)
            {
                $data = @unserialize($data);

                if ($data !== false)
                {
                    return $data;
                }
            }
        }

        return null;
    }
}
