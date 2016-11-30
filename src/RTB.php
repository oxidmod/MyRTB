<?php

declare(strict_types=1);

namespace oxidmod\MyRTB;

use Fleshgrinder\Core\Comparable;
use Fleshgrinder\Core\UncomparableException;

/**
 * Class RTB
 *
 * @package oxidmod\MyRTB
 *
 * @author oxidmod <oxidmod@gmai.com>
 */
class RTB
{
    /**
     * @param int $count
     * @param Comparable[] $items
     * @return Comparable[]
     */
    public function getItems(int $count, array $items) : array
    {
        if (count ($items) === 0) {
            return [];
        }

        $sortedItems = call_user_func_array([$this, 'sortItems'], $items);
        return array_slice($sortedItems, 0, $count);
    }

    /**
     * @param Comparable[] ...$items
     * @return Comparable[]
     */
    private function sortItems(...$items) : array
    {
        try {
            usort($items, function ($a, $b) {
                return $a->compareTo($b);
            });

            return $items;
        } catch (UncomparableException $e) {
            return [];
        }
    }
}
