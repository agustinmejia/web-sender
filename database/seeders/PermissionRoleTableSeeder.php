<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Role;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'admin')->firstOrFail();
        $permissions = Permission::all();
        $role->permissions()->sync(
            $permissions->pluck('id')->all()
        );

        $role = Role::where('name', 'administrador')->firstOrFail();
        $permissions = Permission::whereRaw("   `key` = 'browse_admin' or
                                                `key` = 'browse_sender' or
                                                table_name = 'settings' or
                                                table_name = 'contacts' or
                                                table_name = 'users'")->get();
        $role->permissions()->sync($permissions->pluck('id')->all());
    }
}
