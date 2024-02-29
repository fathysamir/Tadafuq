<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@tadafuq.com',
            'phone' => '01154857080',
            'password' => \Hash::make('password'),
        ]);

        $role = Role::where('name', 'Admin')->first();

        $user->assignRole([$role->id]);
    }
}
