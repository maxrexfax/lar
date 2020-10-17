<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\City;
class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            [
                'name' => 'ZP'
            ],
            [
                'name' => 'Kiev'
            ],
            [
                'name' => 'Lviv'
            ],
            [
                'name' => 'Dnepr'
            ],
        ];
        foreach ($cities as $city) {
            City::create($city);
        }

    }
}
