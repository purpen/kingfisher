<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleInitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = config('roles');
        
        echo "Start to init role...\n";
        
        $counter = 0;
        foreach ($roles as $role) {
            $ok = Role::create($role);
            $counter++;
        }
        
        echo "Role init ok.\n";
    }
}