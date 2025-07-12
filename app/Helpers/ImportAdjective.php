<?php

namespace App\Helpers;

use App\Adjective;
use Illuminate\Support\Facades\DB;

/**
 * Import adjectives from a CSV file
 * User: brianetheridge
 * Date: 10/07/2025
 */
class ImportAdjective
{
    /**
     * Import adjective data for a given language
     * Expected format is:
     *
     *      Adjective name, corresponding english adjective(s)
     *
     * @param string $lang
     */
    public function import($csvFileName, $languageCode='fr', $clearTable='n')
    {
        if (!file_exists($csvFileName)) {
            die("File '$csvFileName' not found.");
        }

        if ('y' == $clearTable) {
            DB::table('adjectives')->delete();
        }

        $file = fopen($csvFileName, 'r');

        while (($line = fgets($file)) !== false) {
            // Expected comma-separated data
            if (null == trim($line)) {
                continue;
            }
            $data = str_getcsv($line);
            
            $adverb = new Adjective();
            $adverb->adjective = $data[0];
            $adverb->english = $data[1];
            $adverb->lang = $languageCode;
            $adverb->save();
        }

        fclose($file);
        echo "Data imported successfully.";
    }
}