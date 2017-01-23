<?php

// Register the auto-loader
require __DIR__.'/../vendor/autoload.php';

/**
 * Create the application with a parser (csv or json)
 * @param string type of parser
 */
$app = new MichaelT\App('csv');

/**
 * Load CSV file
 * @param string path to file
 */
$app->parser()->loadFile(__DIR__.'/../input.csv');

/**
 * Calculate percentile rank from file data
 * @param string|int index/key of score of interest
 * @param string|int index/key to hold percentile rank
 */
$data = $app->calculateRank(2, 'rank');

/**
 * Save result to file
 * @param string path to file
 * @param array data to save
 * @param string|int|array key/index of array to skip
 */
$app->parser()->exportFile(__DIR__.'/../output.csv', $data, 0);
