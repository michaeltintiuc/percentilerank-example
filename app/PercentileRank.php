<?php
namespace MichaelT;

/**
 * Calculates the percentile rank
 * @package michaeltintiuc/percentilerank-example
 * @author Michael Tintiuc
 **/
class PercentileRank
{
    /**
     * Sort array in ascending order
     * @param  array &$data
     * @param  int|string $index
     */
    protected static function sort(array &$data, $index)
    {
        usort($data, function ($a, $b) use ($index) {
            $item1 = trim((float) $a[$index]);
            $item2 = trim((float) $b[$index]);

            if ($item1 == $item2) {
                return 0;
            }

            return ($item1 < $item2) ? -1 : 1;
        });
    }

    /**
     * Calculate percentile rank
     * @param  array &$data
     * @param  int|string $index
     * @param  int|string $key
     */
    public function calculate(array &$data, $index, $key)
    {
        // Sort provided data in ascending order
        PercentileRank::sort($data, $index);

        // Generate an array of values
        // Make sure values are of the same type
        $values = [];
        foreach ($data as $arr) {
            $values[] = trim((float) $arr[$index]);
        }

        // Number of examinees in the sample
        $count = count($values);

        // Array to use when checking scores less than the score of interest
        $count_less = array_flip(array_unique($values));

        // Array to use when checking frequency of the score of interest
        $count_values = array_count_values($values);

        foreach ($values as $i => $value) {
            $freq = $count_values[$value];
            $data[$i][$key] = (($count_less[$value] + 0.5 * $freq) / $count) * 100;
        }
    }
}
