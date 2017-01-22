<?php
namespace MichaelT;

use SplFileObject;
use InvalidArgumentException;

/**
 * Base Parser class
 * @package default
 * @author Michael Tintiuc
 **/
abstract class Parser
{
    const CSV = 'csv';
    const JSON = 'json';
    const INVALID_ARGUMENT_MSG = "Accepted types: [%s], but %s was provided.";

    /**
     * Supported parser types
     * @var array
     */
    private static $supportedTypes = [self::CSV, self::JSON];

    /**
     * Data holder
     * @var array
     */
    protected $data;

    /**
     * Set parser from provided type
     * @param  string $type
     * @throws InvalidArgumentException
     * @return MichaelT\Parser
     */
    public static function make($type)
    {
        $type = trim(strtolower($type));

        if (!in_array($type, self::$supportedTypes)) {
            self::invalidArgument($type);
        }

        switch ($type) {
            case self::CSV:
                return new CsvParser;
                break;

            case self::JSON:
                return new JsonParser;
                break;
        }
    }

    /**
     * Generate the exception
     * @param  string $type
     * @throws InvalidArgumentException
     * @return void
     */
    private static function invalidArgument($type)
    {
        $types = implode(', ', self::$supportedTypes);
        $msg = sprintf(self::INVALID_ARGUMENT_MSG, $types, $type);
        throw new InvalidArgumentException($msg);
    }

    /**
     * Get data
     * @return array
     */
    public function data()
    {
        return $this->data;
    }

    /**
     * Load file
     * @param  string $type
     * @throws InvalidArgumentException
     * @return void
     */
    public function loadFile($file)
    {
        $file = new SplFileObject($file, 'r');
        $this->loadFileData($file);
    }

    /**
     * Export file
     * @param  string $type
     * @param  array $data
     * @param  string|int|array $skip_index
     * @throws InvalidArgumentException
     * @return void
     */
    public function exportFile($file, array $data, $skip_index = null)
    {
        $file = new SplFileObject($file, 'w');
        $this->exportDataToFile($file, $data, $skip_index);
    }

    /**
     * Load data from file
     * @param  SplFileObject $file
     * @return void
     */
    abstract protected function loadFileData(SplFileObject $file);

    /**
     * Export data to file
     * @param  SplFileObject $file
     * @param  array $data
     * @param  string|int|array $skip_index
     * @return void
     */
    abstract protected function exportDataToFile(SplFileObject $file, array $data, $skip_index);
}
