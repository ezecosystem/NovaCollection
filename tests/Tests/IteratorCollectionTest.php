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

class IteratorCollectionTest extends UnitTestCase
{
    public function testCurrentReturnsCurrentValue(): void
    {
        $coll = Factory::create($this->fixtures['names']);
        $this->assertEquals('Chelsea', $coll->current());
    }

    public function testNextMovesCollectionInternalPointer(): void
    {
        $coll = Factory::create($this->fixtures['names']);
        $this->assertEquals(
            'Chelsea',
            $coll->current(),
            'Initial call to current() should return first item in collection.'
        );
        $this->assertEquals(
            'Chelsea',
            $coll->current(),
            'Subsequent calls to current() should continue to return the same value.'
        );
        $coll->next();
        $this->assertEquals(
            'Adella',
            $coll->current(),
            'After calling next(), current() should return the next item in the collection.'
        );
        $coll->next();
        $this->assertEquals(
            'Monte',
            $coll->current(),
            'Subsequent calls to next() and current() should return the next item in the collection.'
        );
        $coll->next();
        $coll->next();
        $coll->next();
        $coll->next();
        $coll->next();
        $coll->next();
        $coll->next();
        $this->assertEquals('Nakia', $coll->current(), 'We should now be at the last item in the collection.');
        $coll->next();
        $this->assertFalse(
            $coll->current(),
            "Subsequent calls to current() should return false because we have next'd past the end of the collection."
        );
        $coll->next();
        $this->assertFalse(
            $coll->current(),
            "Subsequent calls to current() should return false because we have next'd past the end of the collection."
        );
    }

    public function testKeyReturnsCurrentKeyInCollection(): void
    {
        $coll = Factory::create($this->fixtures['names']);
        $this->assertSame(0, $coll->key(), 'Initial call to key() should return first item in collection.');
        $this->assertSame(0, $coll->key(), 'Subsequent calls to key() should continue to return the same value.');
        $coll->next();
        $this->assertSame(
            1,
            $coll->key(),
            'After calling next(), key() should return the next item in the collection.'
        );
        $coll->next();
        $this->assertSame(
            2,
            $coll->key(),
            'Subsequent calls to next() and key() should return the next item in the collection.'
        );
        $coll->next();
        $coll->next();
        $coll->next();
        $coll->next();
        $coll->next();
        $coll->next();
        $coll->next();
        $this->assertSame(9, $coll->key(), 'We should now be at the last item in the collection.');
        $coll->next();
        $this->assertNull(
            $coll->key(),
            'Subsequent calls to key() should continue to return null because'.
            " we have next'd past the end of the collection."
        );
        $coll->next();
        $this->assertNull(
            $coll->key(),
            'Subsequent calls to key() should continue to return null because'.
            " we have next'd past the end of the collection."
        );
    }

    public function testValidReturnsFalseWhenCollectionHasBeenIteratedBeyondItsLastItem(): void
    {
        $coll = Factory::create($this->fixtures['names']);
        $this->assertTrue($coll->valid(), 'Initial call to valid() should always return true.');
        $coll->next();
        $this->assertTrue($coll->valid(), 'Subsequent calls to valid() should continue to return true.');
        $coll->next();
        $this->assertTrue($coll->valid(), 'Subsequent calls to valid() should continue to return true.');
        $coll->next();
        $coll->next();
        $coll->next();
        $coll->next();
        $coll->next();
        $coll->next();
        $coll->next();
        $this->assertTrue($coll->valid(), 'When at the last item in the collection, valid() should still return true.');
        $coll->next();
        $this->assertFalse(
            $coll->valid(),
            'Finally, valid() should return false because we have iterated beyond the end of the collection.'
        );
    }

    public function testRewindWillReturnInternalPointerToItsInitialPosition(): void
    {
        $coll = Factory::create($this->fixtures['names']);
        $this->assertEquals('Chelsea', $coll->first());
        $this->assertTrue($coll->valid(), 'Initial call to valid() should always return true.');
        $coll->next();
        $this->assertTrue($coll->valid(), 'Subsequent calls to valid() should continue to return true.');
        $coll->next();
        $this->assertTrue($coll->valid(), 'Subsequent calls to valid() should continue to return true.');
        $coll->next();
        $coll->next();
        $coll->next();
        $coll->next();
        $coll->next();
        $coll->next();
        $coll->next();
        $this->assertTrue($coll->valid(), 'When at the last item in the collection, valid() should still return true.');
        $this->assertEquals($coll->last(), $coll->current(), 'Current value should be the last value now.');
        $coll->next();
        $this->assertFalse(
            $coll->valid(),
            'Finally, valid() should return false because we have iterated beyond the end of the collection.'
        );
        $this->assertNull($coll->rewind(), 'Rewind MUST NOT have a return value.');
        $this->assertTrue(
            $coll->valid(),
            'The rewind() method should have returned us to the beginning now so valid() should return true.'
        );
        $this->assertEquals(
            $coll->first(),
            $coll->current(),
            'The rewind() method should have returned us to the beginning now so'.
            ' current() should return the first item in the collection.'
        );

        $coll->next();
        $coll2 = clone $coll;
        $this->assertEquals($coll2->first(), $coll2->current(), 'A clone of a collection should be reset.');
    }

    public function testInstantiationShouldRewindArrayArgsInternalPointer(): void
    {
        $arr = $this->fixtures['names'];
        $this->assertEquals('Chelsea', current($arr));
        next($arr);
        $this->assertEquals('Adella', current($arr));
        $coll = Factory::create($arr);
        $this->assertEquals('Chelsea', $coll->current());
    }
}
