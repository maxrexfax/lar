<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\City;
class CitySeeder extends Seeder
{
    public function run()
    {
        $cities = [
            [
                'name' => 'ZP',
                'lat' => '47.8562077',
                'lon' => '35.1053143',
                'description' => 'City description',
            ],
            [
                'name' => 'Kiev',
                'lat' => '50.4019514',
                'lon' => '30.3926094',
                'description' => 'City description',
            ],
            [
                'name' => 'Lviv',
                'lat' => '49.8326679',
                'lon' => '23.9421963',
                'description' => 'City description',
            ],
            [
                'name' => 'Dnepr',
                'lat' => '48.4622135',
                'lon' => '34.8602751',
                'description' => 'City description',
            ],
        ];
        foreach ($cities as $city) {
            City::create($city);
        }

    }
}
