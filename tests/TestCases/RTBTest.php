<?php

namespace oxidmod\MyRTB;

use Fleshgrinder\Core\Comparable;
use Fleshgrinder\Core\ComparableDummy;
use Fleshgrinder\Core\UncomparableException;

/**
 * Class RTBTest
 *
 * @package oxidmod\MyRTB
 *
 * @author oxidmod <oxidmod@gmail.com>
 */
class RTBTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RTB
     */
    private $rtb;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->rtb = new RTB();
        parent::setUp();
    }

    /**
     * @test
     * @small
     *
     * @dataProvider providerForEmptyArrayTest
     *
     * @param int $count
     * @param array $items
     */
    public function shouldReturnEmptyArray(int $count, array $items)
    {
        $sorted = $this->rtb->getItems($count, $items);
        $this->assertEmpty($sorted);
    }

    /**
     * @return array
     */
    public function providerForEmptyArrayTest() : array
    {
        $fakeComparable = $this->createMock(Comparable::class);
        $fakeComparable->method('compareTo')
            ->withAnyParameters()
            ->willThrowException(new UncomparableException());

        $list = [
            new ComparableDummy,
            $fakeComparable,
            new ComparableDummy,
        ];

        return [
            [10, []],
            [10, $list],
        ];
    }

    /**
     * @test
     * @small
     */
    public function shouldReturnSameArray()
    {
        $items = [
            new ComparableDummy,
            new ComparableDummy,
        ];

        $sortedItems = $this->rtb->getItems(3, $items);
        $this->assertEquals($items, $sortedItems);
    }

    /**
     * @test
     * @small
     */
    public function shouldReturnFilteredArray()
    {
        $returned = new ComparableDummy(-1);
        $filtered = new ComparableDummy(1);
        $items = [
            $returned,
            $filtered,
        ];

        $sortedItems = $this->rtb->getItems(1, $items);

        $this->assertCount(1, $sortedItems);
        $this->assertSame($returned, $sortedItems[0]);
    }
}
