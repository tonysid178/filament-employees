<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\State;
use App\Models\Country;
use App\Models\City;
use App\Models\Department;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name'=> fake() ->firstName(),
            'last_name'=>fake() ->lastName(),
            'address' => fake() ->address(),
            'city_id' => City::factory(),
            'state_id' => State::factory(),
            'country_id' => Country::factory(),
            'department_id' => Department::factory(),
            'zip_code' => fake() ->postcode(),
            'birth_date' => fake() ->date('Y-m-d', 'now'),
            'date_hired' => fake() ->date('Y-m-d', 'now'),
        ];
    }
}
