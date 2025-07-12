<?php

namespace App\Helpers;

use App\Verb;
use Illuminate\Support\Facades\DB;

/**
 * Import verbs from a CSV file
 * User: brianetheridge
 * Date: 10/07/2025
 */
class ImportVerb
{
    /**
     * Import adverb data for a given language
     * Expected format is:
     *
     *      verb name (infinitive), corresponding english verb(s)
     *
     * @param string $lang
     */
    public function import($csvFileName, $languageCode='fr', $clearTable='n')
    {
        if (!file_exists($csvFileName)) {
            die("File '$csvFileName' not found.");
        }

        if ('y' == $clearTable) {
            DB::table('verbs')->delete();
        }

        $file = fopen($csvFileName, 'r');

        while (($line = fgets($file)) !== false) {
            // Assuming comma-separated data
            if (null == trim($line)) {
                continue;
            }
            $data = str_getcsv($line);

            $reflexive = 0;
            if (substr($data[0], 0, 3) == 'se ') {
                $data[0] = substr($data[0], 3);
                $reflexive = 1;
            }

            $verb = new Verb();
            $verb->infinitive = $data[0];
            $verb->english = $data[1];
            $verb->reflexive = $reflexive;
            $verb->lang = $languageCode;
            $verb->save();
        }

        fclose($file);
        echo "Data imported successfully.";
    }
}