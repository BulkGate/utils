<?php declare(strict_types=1);

/**
 * Test: BulkGate\Utils\Connection
 * @author Lukáš Piják 2018 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

namespace Test;

use Tester\Assert;
use BulkGate\Utils\Arrays;

require __DIR__ . '/../bootstrap.php';

$deep = [
    'bulkgate' => [
        'sms' => [
            'count' => 150,
            'price' => 200,
            'parts' => 300
        ],
        'viber' => [
            'count' => 150,
            'price' => 100
        ]
    ]
];

$array = ['a', 'b', 'c', 'd'];

$associative = ['a' => 'c', 'b' => 'd'];

$associativeDeep2 = ['a' => 'c', 'b' => (object) ['d' => 'd']];

/** Arrays::selfAssociative **/
Assert::same(['a' => 'a', 'b' => 'b', 'c' => 'c', 'd' => 'd'], Arrays::selfAssociative($array));

Assert::same(['c' => 'c', 'd' => 'd'], Arrays::selfAssociative($associative));


/** Arrays::valueFromPath **/
Assert::same(300, Arrays::valueFromPath($deep, 'bulkgate.sms.parts'));

Assert::same(null, Arrays::valueFromPath($deep, 'bulkgate.viber.parts'));

Assert::same(300, Arrays::valueFromPath($deep, 'bulkgate=>sms=>parts', '=>'));

Assert::same(300, Arrays::valueFromPath($deep, 'bulkgate/sms/parts', '/'));

Assert::same('d', Arrays::valueFromPath($associativeDeep2, 'b/d', '/'));

/** Arrays::prefix **/
Assert::same(['base_a' => '_c', 'base_b' => '_d'], Arrays::prefix($associative, 'base_', '_'));

Assert::equal(['base_a' => '_c', 'base_b' => (object) ['d' => 'd']], Arrays::prefix($associativeDeep2, 'base_', '_'));

/** Arrays::projection **/
$databaseExample = [1 =>  ['a' => 'b', 'c' => 'd'], 2 => (object) ['a' => 'b', 'c' => 'd'], 3 => (object) ['a' => 'b', 'c' => 'd']];

Assert::equal([1 => ['a' => 'b'], 2 => ['a' => 'b'], 3 => ['a' => 'b']], Arrays::projection($databaseExample, 'a'));

Assert::equal([1 => ['c' => 'd'], 2 => ['c' => 'd'], 3 => ['c' => 'd']], Arrays::projection($databaseExample, 'c'));

Assert::equal([1 =>  ['a' => 'b', 'c' => 'd'], 2 => ['a' => 'b', 'c' => 'd'], 3 => ['a' => 'b', 'c' => 'd']], Arrays::projection($databaseExample, 'c', 'a'));

Assert::equal([1 => [], 2 => [], 3 => []], Arrays::projection($databaseExample));

Assert::equal([1 => [], 2 => [], 3 => []], Arrays::projection($databaseExample, 'q'));

/** Arrays::toPairArray **/
$databaseExample = [1 =>  ['a' => 'm1', 'c' => '150'], 2 => ['a' => 'm2', 'c' => '190'], 3 => ['a' => 'm3', 'c' => '250']];

Assert::equal(array_values($databaseExample), Arrays::toPairArray($databaseExample));

Assert::equal(['m1' => '150', 'm2' => '190', 'm3' => '250'], Arrays::toPairArray($databaseExample, 'a', 'c'));

Assert::equal(['m1' =>  ['a' => 'm1', 'c' => '150'], 'm2' => ['a' => 'm2', 'c' => '190'], 'm3' => ['a' => 'm3', 'c' => '250']], Arrays::toPairArray($databaseExample, 'a'));

Assert::equal(['m1', 'm2', 'm3'], Arrays::toPairArray($databaseExample, null, 'a'));

Assert::equal(['o', 'm1', 'm2', 'm3'], Arrays::toPairArray($databaseExample, null, 'a', ['o']));

