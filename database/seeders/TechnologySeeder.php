<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Technology;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $technologies = ['Laravel', 'Vue.js', 'React', 'JavaScript', 'HTML', 'CSS'];

        foreach ($technologies as $tech) {
            Technology::create(['name' => $tech]);
        }
    }
}
