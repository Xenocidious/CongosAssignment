<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PersonModel as Person;
use App\Models\AddressModel as Address;
use App\Models\NoteModel as Note;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Persons seeder
        $JohnId = Person::insertGetId([
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'JohnDoe@example.com'
        ]);

        $JaneId = Person::insertGetId([
            'name' => 'Jane',
            'surname' => 'Doe',
            'email' => 'JaneDoe@example.com'
        ]);

        // Addresses seeder
        $JohnAddressId = Address::insert([
            'person_id' => $JohnId,
            'street_name' => 'Faraway st.',
            'street_number' => '0',
            'city' => 'Neverland'
        ]);

        $JaneAddressId = Address::insert([
            'person_id' => $JaneId,
            'street_name' => 'Faraway st.',
            'street_number' => '0',
            'city' => 'Neverland'
        ]);

        Address::insert([
            'person_id' => $JaneId,
            'street_name' => 'Nowhere st.',
            'street_number' => '17',
            'city' => 'Neverland'
        ]);

        // Notes Seeder
        Note::insert([
            'related_id' => $JohnId,
            'type' => 'person',
            'note' => 'Probably not his real name.'
        ]);

        Note::insert([
            'related_id' => $JaneId,
            'type' => 'person',
            'note' => 'Probably not her real name.'
        ]);

        Note::insert([
            'related_id' => $JohnAddressId,
            'type' => 'address',
            'note' => 'Probably not his real address.'
        ]);

        Note::insert([
            'related_id' => $JaneAddressId,
            'type' => 'address',
            'note' => 'Probably not her real address.'
        ]);
    }
}
