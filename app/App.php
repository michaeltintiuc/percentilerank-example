<?php
namespace MichaelT;

/**
 * Calculates the percentile rank
 * @package michaeltintiuc/percentilerank-example
 * @author Michael Tintiuc
 **/
class App
{
    /**
     * Parser created from provided type
     * @var MichaelT\Parser
     */
    private $parser;

    /**
     * Generate a relevant parser
     * @param  string $type
     * @return void
     */
    public function __construct($type)
    {
        $this->parser = Parser::make($type);
        self::log(sprintf('App started with "%s" parser', $type));
    }

    /**
     * Return generated parser
     * @return MichaelT\Parser
     */
    public function parser()
    {
        return $this->parser;
    }

    /**
     * Calculate the percentile rank from loaded data
     * @param  int|string $index
     * @throws Exception
     * @return array
     */
    public function calculateRank($index, $rank_index)
    {
        $data = $this->parser->data();

        if (!$data) {
            throw new \Exception('No data to work with');
        }

        // Calculate the percentile rank
        $data = PercentileRank::calculate($data, $index, $rank_index);

        self::log(sprintf('Percentile Rank calculated from index: %s', $index));
        self::log(sprintf('Percentile Rank stored in index: %s', $rank_index));
        self::log(sprintf('Calculated %d items', count($data)));

        return $data;
    }

    /**
     * Helper to log output
     * @param string $text
     */
    public static function log($text)
    {
        // Define the end of line constant
        if (!defined('EOL')) {
            define('EOL', php_sapi_name() === 'cli' ? PHP_EOL : '<br>');
        }

        echo $text . EOL;
    }
}
