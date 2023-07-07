<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DataTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('data_types')->delete();
        
        \DB::table('data_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'users',
                'slug' => 'users',
                'display_name_singular' => 'User',
                'display_name_plural' => 'Users',
                'icon' => 'voyager-person',
                'model_name' => 'TCG\\Voyager\\Models\\User',
                'policy_name' => 'TCG\\Voyager\\Policies\\UserPolicy',
                'controller' => 'TCG\\Voyager\\Http\\Controllers\\VoyagerUserController',
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"desc","default_search_key":null,"scope":null}',
                'created_at' => '2021-06-02 17:55:30',
                'updated_at' => '2022-08-14 23:31:50',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'menus',
                'slug' => 'menus',
                'display_name_singular' => 'Menu',
                'display_name_plural' => 'Menus',
                'icon' => 'voyager-list',
                'model_name' => 'TCG\\Voyager\\Models\\Menu',
                'policy_name' => NULL,
                'controller' => '',
                'description' => '',
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => NULL,
                'created_at' => '2021-06-02 17:55:30',
                'updated_at' => '2021-06-02 17:55:30',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'roles',
                'slug' => 'roles',
                'display_name_singular' => 'Role',
                'display_name_plural' => 'Roles',
                'icon' => 'voyager-lock',
                'model_name' => 'TCG\\Voyager\\Models\\Role',
                'policy_name' => NULL,
                'controller' => 'TCG\\Voyager\\Http\\Controllers\\VoyagerRoleController',
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"desc","default_search_key":null,"scope":null}',
                'created_at' => '2021-06-02 17:55:31',
                'updated_at' => '2022-08-14 23:40:05',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'permissions',
                'slug' => 'permissions',
                'display_name_singular' => 'Permiso',
                'display_name_plural' => 'Permisos',
                'icon' => 'voyager-list',
                'model_name' => 'App\\Models\\Permission',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":"table_name","order_display_column":"table_name","order_direction":"asc","default_search_key":null}',
                'created_at' => '2022-05-24 15:21:20',
                'updated_at' => '2022-05-24 15:21:20',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'servers',
                'slug' => 'servers',
                'display_name_singular' => 'Servidor',
                'display_name_plural' => 'Servidores',
                'icon' => 'voyager-harddrive',
                'model_name' => 'App\\Models\\Server',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null}',
                'created_at' => '2023-07-07 10:01:08',
                'updated_at' => '2023-07-07 10:01:08',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'contacts',
                'slug' => 'contacts',
                'display_name_singular' => 'Contacto',
                'display_name_plural' => 'Contactos',
                'icon' => 'voyager-people',
                'model_name' => 'App\\Models\\Contact',
                'policy_name' => NULL,
                'controller' => NULL,
                'description' => NULL,
                'generate_permissions' => 1,
                'server_side' => 0,
                'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}',
                'created_at' => '2023-07-07 10:29:56',
                'updated_at' => '2023-07-07 16:15:31',
            ),
        ));
        
        
    }
}