<?php
/**
 * Novactive Collection.
 *
 * @author    Luke Visinoni <l.visinoni@novactive.us, luke.visinoni@gmail.com>
 * @author    Sébastien Morel <s.morel@novactive.us, morel.seb@gmail.com>
 * @copyright 2017 Novactive
 * @license   MIT
 */

namespace Novactive\Tests;

use Novactive\Collection\Factory;
use Novactive\Tests\Perfs\ArrayMethodCollection;

/**
 * Class MergeCollectionTest.
 */
class MergeCollectionTest extends UnitTestCase
{
    public function testMergeCollection()
    {
        $coll  = Factory::create($this->fixtures['names']);
        $coll2 = Factory::create($this->fixtures['assoc']);
        $tab   = ['plop', 'plop'];

        $newColl = $coll->merge($coll2)->merge($tab);

        if (!$coll instanceof ArrayMethodCollection) {
            $this->assertEquals($coll->atIndex(0), 'Chelsea');
            $this->assertEquals($newColl->atIndex(0), 'plop');
        }
        $this->assertNotSame($coll, $newColl);
        $this->assertEquals($newColl->keyOf('third'), '3rd');
    }

    public function testMergeInPlaceCollection()
    {
        $coll  = Factory::create($this->fixtures['names']);
        $coll2 = Factory::create($this->fixtures['assoc']);
        $tab   = ['plop', 'plop'];

        $newColl = $coll->coalesce($coll2)->coalesce($tab);

        $this->assertEquals($newColl->keyOf('third'), '3rd');

        if (!$coll instanceof ArrayMethodCollection) {
            $this->assertNotEquals($coll->atIndex(0), 'Chelsea');
            $this->assertEquals($newColl->atIndex(0), 'plop');
        }
        $this->assertSame($newColl, $coll);
    }

    public function exceptionProvider()
    {
        return [
            ['plop', 'merge'],
            [new \stdClass(), 'merge'],
            [123112.31, 'merge'],
            ['plop', 'coalesce'],
            [new \stdClass(), 'coalesce'],
            [123112.31, 'coalesce'],
        ];
    }

    /**
     * @dataProvider exceptionProvider
     * @expectedException \InvalidArgumentException
     */
    public function testMergeExceptionCollection($items, $method)
    {
        $coll = Factory::create([123, 123, 123, 123, 123, 12312, 33]);
        $coll->$method($items);
    }
}
