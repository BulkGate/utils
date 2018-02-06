<?php declare(strict_types=1);

/**
 * @author Lukáš Piják 2018 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

namespace BulkGate;

trait Strict
{
    /**
     * @param string $name
     * @throws StrictException
     */
    public function &__get(string $name)
    {
        throw new StrictException('You can\'t read from undeclared property '.__CLASS__.'::$'.$name);
    }


    /**
     * @param string $name
     * @param mixed $value
     * @throws StrictException
     */
    public function __set(string $name, $value)
    {
        throw new StrictException('You can\'t write to undeclared property '.__CLASS__.'::$'.$name);
    }


    /**
     * @param string $name
     * @return bool
     */
    public function __isset(string $name)
    {
        return false;
    }


    /**
     * @param string $name
     * @throws StrictException
     */
    public function __unset(string $name)
    {
        throw new StrictException('You can\'t unset undeclared property '.__CLASS__.'::$'.$name);
    }


    /**
     * @param string $name
     * @param array $arguments
     * @throws StrictException
     */
    public function __call(string $name, array $arguments)
    {
        throw new StrictException('You can\'t call undeclared method '.__CLASS__.'::$'.$name);
    }


    /**
     * @param string $name
     * @param array $arguments
     * @throws StrictException
     */
    public static function __callStatic(string $name, array $arguments)
    {
        throw new StrictException('You can\'t statically call undeclared method '.__CLASS__.'::$'.$name);
    }
}
