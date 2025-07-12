<?php

namespace App\Helpers;

use App\Adverb;
use Illuminate\Support\Facades\DB;

/**
 * Import adverbs from a CSV file
 * User: brianetheridge
 * Date: 10/07/2025
 */
class ImportAdverb
{
    /**
     * Import adverb data for a given language
     * Expected format is:
     *
     *      adverb name, corresponding english adverb(s)
     *
     * @param string $lang
     */
    public function import($csvFileName, $languageCode='fr', $clearTable='n')
    {
        if (!file_exists($csvFileName)) {
            die("File '$csvFileName' not found.");
        }

        if ('y' == $clearTable) {
            DB::table('adverbs')->delete();
        }

        $file = fopen($csvFileName, 'r');

        while (($line = fgets($file)) !== false) {
            // Expected comma-separated data
            if (null == trim($line)) {
                continue;
            }
            $data = str_getcsv($line);

            $adverb = new Adverb();
            $adverb->adverb = $data[0];
            $adverb->english = $data[1];
            $adverb->lang = $languageCode;
            $adverb->save();
        }

        fclose($file);
        echo "Data imported successfully.";
    }
}