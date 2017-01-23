# Percentile Rank
An example application for calculating percentile ranks

## Installation

Create a folder for your project and enter it

```bash
mkdir percentilerank-example && cd "$_"
```

Pull the project files
```bash
composer create-project michaeltintiuc/percentilerank-example .
```

## Usage

When running application via Web Server set the Document Root to `public/`

Run application via `CLI`

```bash
php public/index.php
```

Create the application with a parser (csv or json)

```php
/**
 * @param string type of parser
 */
$app = new MichaelT\App('csv');
```

Load file to be read by the parser

```php
/**
 * @param string path to file
 */
$app->parser()->loadFile(__DIR__.'/../input.csv');
```

Calculate percentile rank from file data

```php
/**
 * @param string|int index/key of score of interest
 * @param string|int index/key to hold percentile rank
 */
$data = $app->calculateRank(2, 'rank');
```

Save result to file via created parser

```php
/**
 * @param string path to file
 * @param array data to save
 * @param string|int|array key/index of array to skip
 */
$app->parser()->exportFile(__DIR__.'/../output.csv', $data, 0);
```
