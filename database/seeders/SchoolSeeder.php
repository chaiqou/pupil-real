<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $oxford = School::create([
           'short_name' => 'Oxford',
           'full_name' => 'University Of Oxford',
           'long_name' => 'Masters and Scholars of the University of Oxford',
           'details' => json_encode([
               'street_address' => null,
               'country' => null,
               'city' => 'ExampleCity1',
               'state' => 'ExampleState1',
               'zip' => null,
               'email' => null,
               'contact_person' => null,
               'phone_number' => null,
               'mobile_number' => null,
               'extension' => null,
           ]),
           'school_code' => 'BEW935',
        ]);

        $harvard = School::create([
            'short_name' => 'Harvard',
            'full_name' => 'Harvard University',
            'long_name' => 'Long name for Harvard University',
            'details' => json_encode([
                'street_address' => null,
                'country' => null,
                'city' => 'ExampleCity2',
                'state' => 'ExampleState2',
                'zip' => null,
                'email' => null,
                'contact_person' => null,
                'phone_number' => null,
                'mobile_number' => null,
                'extension' => null,
            ]),
            'school_code' => 'OIP',
        ]);
    }
}
