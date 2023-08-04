<?php

namespace Database\Seeders;

use Database\Factories\CountryFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Department;
use App\Models\Employee;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        Country::factory(20)->create();

        $countryTotal = Country::count();

        State::factory(20)->create([
            'country_id' => fn() => rand(1, $countryTotal)
        ]);

        $stateTotal = State::count();

        City::factory(20)->create([
            'state_id' => fn() => rand(1, $stateTotal),
            'country_id' => fn() => rand(1, $countryTotal)
        ]);

        $cityTotal = City::count();

        Department::factory(1)->create([
            'name' => 'Marketing',
        ]);

        $departmentTotal = Department::count();

        Employee::factory(20)->create([
            'city_id' => fn() => rand(1, $cityTotal),
            'department_id' => fn() => rand(1, $departmentTotal),
            'country_id' => fn() => rand(1, $countryTotal),
            'city_id' => fn() => rand(1, $cityTotal),
        ]);
    }
}
