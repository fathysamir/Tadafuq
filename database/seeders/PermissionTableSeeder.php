<?php

namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
  
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
           'post-list',
           'post-create',
           'post-edit',
           'post-delete',
           'user-list',
           'user-create',
           'user-edit',
           'user-delete',
           

        ];
     
        foreach ($permissions as $permission) {
          
             Permission::create(['name' => $permission,'guard_name'=>'web']);
        }
    }
}