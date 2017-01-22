<?php
namespace MichaelT;

use SplFileObject;

/**
 * Class to parse csv
 * @package default
 * @author Michael Tintiuc
 **/
class CsvParser extends Parser
{
    /**
     * {@inheritdoc}
     */
    protected function loadFileData(SplFileObject $file)
    {
        $file->setFlags(
            SplFileObject::READ_CSV |
            SplFileObject::READ_AHEAD |
            SplFileObject::SKIP_EMPTY |
            SplFileObject::DROP_NEW_LINE
        );

        foreach ($file as $row) {
            $this->data[] = $row;
        }
    }
    /**
     * {@inheritdoc}
     */
    protected function exportDataToFile(SplFileObject $file, array $data, $skip_index = null)
    {
        foreach ($data as $row) {
            if ($skip_index !== null) {
                $skip_index = (array) $skip_index;

                foreach ($skip_index as $index) {
                    unset($row[$index]);
                }
            }

            $file->fputcsv($row);
        }
    }
}
