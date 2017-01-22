<?php
namespace MichaelT;

/**
 * Calculates the percentile rank
 * @package default
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
     */
    public function calculateRank($index, $rank_index)
    {
        $data = $this->parser->data();

        if (!$data) {
            throw new \Exception('No data to work with');
        }

        // Calculate the percentile rank
        PercentileRank::calculate($data, $index, $rank_index);

        return $data;
    }

    /**
     * Export data to file
     * @param  string $file
     * @param  array $data
     * @param  string|int|array $skip_index
     * @throws Exception
     */
    public function export($file, $data, $skip_index = null)
    {
        $this->parser->exportFile($file, $data, $skip_index);
    }
}
