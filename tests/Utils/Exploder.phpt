<?php declare(strict_types=1);

/**
 * Test: BulkGate\Utils\Exploder
 * @author Lukáš Piják 2019 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

namespace Test;

use Tester\Assert;
use BulkGate\Utils\Exploder;

require __DIR__ . '/../bootstrap.php';

$string = 'a|b|c|d';

$array = ['a', 'b', 'c', 'd'];

$delimiter = ':';

Assert::same($array, Exploder::explode($string));

Assert::same([], Exploder::explode(''));

Assert::same([], Exploder::explode('   '));

Assert::same(['a'], Exploder::explode('a'));

Assert::same($array, Exploder::explode('a,b,c,d', ','));

Assert::same($string, Exploder::implode($array));

Assert::same($array, Exploder::explode(Exploder::implode($array, $delimiter), $delimiter));
