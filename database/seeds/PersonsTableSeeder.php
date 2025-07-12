<?php

use Illuminate\Database\Seeder;
use App\Person;
use Illuminate\Support\Facades\DB;

class PersonsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('persons')->delete();

        $person = new Person();
        $person->person = '1ère personne du singulier';
        $person->english = '1st person singular';
        $person->lang = 'fr';
        $person->save();

        $person = new Person();
        $person->person = '2e personne du singulier';
        $person->english = '2nd person singular';
        $person->lang = 'fr';
        $person->save();

        $person = new Person();
        $person->person = '3e personne du singulier (masculin)';
        $person->english = '3rd person singular (male)';
        $person->lang = 'fr';
        $person->save();

        $person = new Person();
        $person->person = '3e personne du singulier (féminin)';
        $person->english = '3rd person singular (female)';
        $person->lang = 'fr';
        $person->save();

        $person = new Person();
        $person->person = '1ère personne du pluriel';
        $person->english = '1st person plural';
        $person->lang = 'fr';
        $person->save();

        $person = new Person();
        $person->person = '2e personne du pluriel';
        $person->english = '2nd person plural';
        $person->lang = 'fr';
        $person->save();

        $person = new Person();
        $person->person = '3e personne du pluriel (masculin ou les deux)';
        $person->english = '3rd person plural (male or both)';
        $person->lang = 'fr';
        $person->save();

        $person = new Person();
        $person->person = '3e personne du pluriel (féminin)';
        $person->english = '3rd person plural (female)';
        $person->lang = 'fr';
        $person->save();

        $person = new Person();
        $person->person = '1a persona singolare';
        $person->english = '1st person singular';
        $person->lang = 'it';
        $person->save();

        $person = new Person();
        $person->person = '2a persona singolare';
        $person->english = '2nd person singular';
        $person->lang = 'it';
        $person->save();

        $person = new Person();
        $person->person = '3a persona singolare (maschile)';
        $person->english = '3rd person singular (male)';
        $person->lang = 'it';
        $person->save();

        $person = new Person();
        $person->person = '3a persona singolare (femminile)';
        $person->english = '3rd person singular (female)';
        $person->lang = 'it';
        $person->save();

        $person = new Person();
        $person->person = '1a persona plurale';
        $person->english = '1st person plural';
        $person->lang = 'it';
        $person->save();

        $person = new Person();
        $person->person = '2a persona plurale';
        $person->english = '2nd person plural';
        $person->lang = 'it';
        $person->save();

        $person = new Person();
        $person->person = '3a persona plurale (maschile o entrambi)';
        $person->english = '3rd person plural (male or both)';
        $person->lang = 'it';
        $person->save();

        $person = new Person();
        $person->person = '3a persona plurale (femminile)';
        $person->english = '3rd person plural (female)';
        $person->lang = 'it';
        $person->save();
    }

}
