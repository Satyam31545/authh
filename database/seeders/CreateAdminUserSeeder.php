<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456')
        ]);
        DB::table('employees')->insert(
            array(
                'name' => 'satyam',
                'user_id' => 1,
                'salary' => 5000,
                'desigination' => 'developer',
                'dob' => '2004-05-05',
                'address' => 'varaashi'

            )
        );
        $role = Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Staff']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
