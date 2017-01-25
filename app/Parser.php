<?php
namespace MichaelT;

use SplFileObject;
use InvalidArgumentException;

/**
 * Base Parser class
 * @package michaeltintiuc/percentilerank-example
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
     * Type holder
     * @var array
     */
    protected $type;

    /**
     * Set parser from provided type
     * @param  string $type
     * @throws InvalidArgumentException
     * @return MichaelT\CsvParser|MichaelT\JsonParser
     */
    public static function make($type)
    {
        $type = trim(strtolower($type));

        if (!in_array($type, self::$supportedTypes)) {
            self::invalidArgument();
        }

        switch ($type) {
            case self::CSV:
                $parser = new CsvParser;
                break;

            case self::JSON:
                $parser = new JsonParser;
                break;
        }

        $parser->setType($type);

        return $parser;
    }

    /**
     * Generate the exception
     * @param  string $type
     * @throws InvalidArgumentException
     * @return void
     */
    private static function invalidArgument()
    {
        $types = implode(', ', self::$supportedTypes);
        $msg = sprintf(self::INVALID_ARGUMENT_MSG, $types, $this->type);
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
     * Set type
     * @param string $type
     * @return array
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     * @param string $type
     * @return array
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * Load file
     * @param  string $file
     * @throws InvalidArgumentException
     * @return void
     */
    public function loadFile($file)
    {
        try {
            $file = new SplFileObject($file, 'r');
            $file_name = $file->getBaseName();
            App::log(sprintf('Read input file: %s', $file_name));
        } catch (\Exception $e) {
            App::log(sprintf('Error reading file: %s', $file));
            App::log($e->getMessage());
        }

        $this->loadFileData($file);
        App::log('Data loaded from file');
    }

    /**
     * Export file
     * @param  string $file
     * @param  array $data
     * @param  string|int|array $skip_index
     * @return void
     */
    public function exportFile($file, array $data, $skip_index = null)
    {
        App::log('Preparing data for export');

        if ($skip_index !== null) {
            App::log(sprintf('Skipping index(s): %s', implode(', ', (array) $skip_index)));
        }

        try {
            $file = new SplFileObject($file, 'w');
            $file_name = $file->getBaseName();
            App::log(sprintf('Opened file for write: %s', $file_name));
        } catch (\Exception $e) {
            App::log(sprintf('Error writing to file: %s', $file));
            App::log($e->getMessage());
        }

        $this->exportDataToFile($file, $data, $skip_index);
        App::log('Exported data to file');
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
