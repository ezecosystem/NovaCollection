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

use Novactive\Collection\Collection;
use Novactive\Collection\Factory;

/**
 * Class CollectionTest.
 */
class CollectionTest extends UnitTestCase
{
    public function testInstantiateCollectionWithNoParams()
    {
        $coll = Factory::create();
        $this->assertInstanceOf(Collection::class, $coll);
    }
}
