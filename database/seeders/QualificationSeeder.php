<?php

namespace Database\Seeders;

use App\Models\Qualification;
use Illuminate\Database\Seeder;

class QualificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        Qualification::insert([
            ['name' => '10 th'],
            ['name' => '12 th'],
            ['name' => 'Science'],
            ['name' => 'Bachelor Program In Engineering'],
            ['name' => 'Bachelor Program In Humanities'],
            ['name' => 'Bachelor Program In Technology Studies'],
            ['name' => 'Bachelor Program In Business Studies'],
            ['name' => 'Bachelor Program In Economic Studies'],
            ['name' => 'Bachelor Program In Social Sciences'],
            ['name' => 'Bachelor Program In Management Studies'],
            ['name' => 'Bachelor Program In Natural  Science'],
            ['name' => 'Bachelor Program In Arts Studies'],
            ['name' => 'Bachelor Program In Medical Science'],
            ['name' => 'Bachelor Program In Journalism & Mass Communication'],
            ['name' => 'ITI ( Industrial Training Institute)'],
            ['name' => 'Doctorate of Medicine (D.M.)'],
            ['name' => 'Master of Chirurgiae (M.Ch)'],
            ['name' => 'PHD / M. Phill / NETSET'],
            ['name' => 'DME / DEE'],
        ]);
    }
}
