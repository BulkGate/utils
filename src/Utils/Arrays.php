<?php declare(strict_types=1);

/**
 * @author Lukáš Piják 2019 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

namespace BulkGate\Utils;

use BulkGate;

class Arrays
{
    use BulkGate\Strict;

    public static function toPairArray(array $array, ?string $key = null, ?string $value = null, array $output = []): array
    {
        if($key == null && $value === null)
        {
            foreach($array as $record)
            {
                $output[] = $record;
            }
            return $output;
        }
        else if($key === null && $value !== null)
        {
            foreach($array as $record)
            {
                $output[] = $record[$value];
            }
            return $output;
        }
        else if($key !== null && $value === null)
        {
            foreach($array as $record)
            {
                $output[$record[$key]] = $record;
            }
            return $output;
        }
        else
        {
            foreach($array as $record)
            {
                $output[$record[$key]] = $record[$value];
            }
            return $output;
        }
    }


    public static function projection(array $array_data, ...$keys): array
    {
        $keys = array_flip($keys);

        return array_map(function($array) use ($keys)
        {
            return array_intersect_key((array) $array, $keys);
        }, $array_data);
    }


    public static function selfAssociative(array $array): array
    {
        return array_combine($array, $array) ?: [];
    }


    public static function valueFromPath(array $array, string $path, string $path_separator = '.')
    {
        if(strlen(trim($path)) > 0)
        {
            $path_array = explode($path_separator, $path);

            return array_reduce($path_array, function($array, $i)
            {
                if($array)
                {
                    return is_array($array) ? $array[$i] ?? null : $array->{$i} ?? null;
                }
                return null;
            }, $array);
        }
        return null;
    }


    public static function prefix(array $array, string $key_prefix = '', string $value_prefix = ''): array
    {
        $output = [];

        foreach($array as $key => $item)
        {
            $output[$key_prefix . (string) $key] = is_string($item) ? $value_prefix . $item : $item;
        }
        return $output;
    }
}
