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

class ContainsKeyCollectionTest extends UnitTestCase
{
    public function testContainsKeyReturnsTrueIfItemExistsByKey(): void
    {
        $exp  = $this->fixtures['assoc'];
        $coll = Factory::create($exp);
        $this->assertTrue($coll->containsKey('2nd'));
        $coll->remove('2nd');
        $this->assertFalse($coll->containsKey('2nd'));
    }
}
