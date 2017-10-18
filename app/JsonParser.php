<?php
namespace MichaelT;

use SplFileObject;

/**
 * Class to parse json
 * @package michaeltintiuc/percentilerank-example
 * @author Michael Tintiuc
 **/
class JsonParser extends Parser
{
    /**
     * {@inheritdoc}
     */
    protected function loadFileData(SplFileObject $file)
    {
        $this->data = json_decode($file->fread($file->getSize()), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function exportDataToFile(SplFileObject $file, array $data, $skip_index = null)
    {
        foreach ($data as &$row) {
            if ($skip_index !== null) {
                $skip_index = (array) $skip_index;

                foreach ($skip_index as $index) {
                    unset($row[$index]);
                }
            }
        }

        $file->fwrite(json_encode($data));
    }
}
