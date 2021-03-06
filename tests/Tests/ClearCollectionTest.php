<?php
/**
 * Novactive Collection.
 *
 * @author    Luke Visinoni <l.visinoni@novactive.us, luke.visinoni@gmail.com>
 * @author    Sébastien Morel <s.morel@novactive.us, morel.seb@gmail.com>
 * @copyright 2017 Novactive
 * @license   MIT
 */
declare(strict_types=1);

namespace Novactive\Tests;

use Novactive\Collection\Factory;

class ClearCollectionTest extends UnitTestCase
{
    public function testClearCollection(): void
    {
        $coll = Factory::create($this->fixtures['names']);
        $coll->clear();
        $this->assertEquals($coll->toArray(), []);
        $this->assertTrue($coll->isEmpty());
    }
}
