<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use App\Models\UserAssinProduct;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(1)->create()->each(function ($user) {
            $employee = Employee::factory()->create(['user_id' => $user->id]);
            UserAssinProduct::factory()->count(3)->create(['employee_id'=>$employee]);
        });
    }
}
