<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Client;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $clients = ['Alkhair' , 'Hamed'];

        foreach ($clients as $client) {

        Client::create([

            'name' => $client,
            'phone' => '0920016568',
            'address' => 'Sudan-Rabak',

        ]);

    }// end of foreach
    }
}
