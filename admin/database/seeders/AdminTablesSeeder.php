<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// 追加
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Auth\Database\Role;
use Encore\Admin\Auth\Database\Permission;
use Encore\Admin\Auth\Database\Menu;
use Illuminate\Support\Facades\Hash;

class AdminTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create a user.
        Administrator::truncate();
        Administrator::create([
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'name'     => 'Administrator',
        ]);

        // create a role.
        Role::truncate();
        Role::create([
            'name' => 'Administrator',
            'slug' => 'administrator',
        ]);

        // ロール追加
        Role::create([
            'name' => 'ユーザー管理者',
            'slug' => 'user.administrator',
        ]);

        // add role to user.
        Administrator::first()->roles()->save(Role::first());

        //create a permission
        Permission::truncate();
        Permission::insert([
            [
                'name'        => 'All permission',
                'slug'        => '*',
                'http_method' => '',
                'http_path'   => '*',
            ],
            [
                'name'        => 'Dashboard',
                'slug'        => 'dashboard',
                'http_method' => 'GET',
                'http_path'   => '/',
            ],
            [
                'name'        => 'Login',
                'slug'        => 'auth.login',
                'http_method' => '',
                'http_path'   => "/auth/login\r\n/auth/logout",
            ],
            [
                'name'        => 'User setting',
                'slug'        => 'auth.setting',
                'http_method' => 'GET,PUT',
                'http_path'   => '/auth/setting',
            ],
            [
                'name'        => 'Auth management',
                'slug'        => 'auth.management',
                'http_method' => '',
                'http_path'   => "/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs",
            ],

            // パーミッション追加
            [
                'name'        => 'ユーザー管理',
                'slug'        => 'user.management',
                'http_method' => '',
                'http_path'   => "/users*",
            ],
        ]);

        Role::first()->permissions()->save(Permission::first());

        // ロールにパーミンションを設定
        Role::where('slug', 'user.administrator')->first()->permissions()->save(Permission::where('slug', 'user.management')->first());
        Role::where('slug', 'user.administrator')->first()->permissions()->save(Permission::where('slug', 'dashboard')->first());
        Role::where('slug', 'user.administrator')->first()->permissions()->save(Permission::where('slug', 'auth.setting')->first());

        // add default menus.
        Menu::truncate();

        // 追加するメニューの修正
        Menu::insert([
            [
                'parent_id' => 0,
                'order'     => 1,
                'title'     => 'Dashboard',
                'icon'      => 'fa-bar-chart',
                'uri'       => '/',
            ],
            [
                'parent_id' => 0,
                'order'     => 2,
                'title'     => 'ユーザー管理',
                'icon'      => 'fa-user',
                'uri'       => '',
            ],
            [
                'parent_id' => 2,
                'order'     => 3,
                'title'     => 'ユーザー',
                'icon'      => 'fa-users',
                'uri'       => '/users',
            ],
            [
                'parent_id' => 0,
                'order'     => 4,
                'title'     => 'Admin',
                'icon'      => 'fa-tasks',
                'uri'       => '',
            ],
            [
                'parent_id' => 4,
                'order'     => 5,
                'title'     => 'Users',
                'icon'      => 'fa-users',
                'uri'       => 'auth/users',
            ],
            [
                'parent_id' => 4,
                'order'     => 6,
                'title'     => 'Roles',
                'icon'      => 'fa-user',
                'uri'       => 'auth/roles',
            ],
            [
                'parent_id' => 4,
                'order'     => 7,
                'title'     => 'Permission',
                'icon'      => 'fa-ban',
                'uri'       => 'auth/permissions',
            ],
            [
                'parent_id' => 4,
                'order'     => 8,
                'title'     => 'Menu',
                'icon'      => 'fa-bars',
                'uri'       => 'auth/menu',
            ],
            [
                'parent_id' => 4,
                'order'     => 9,
                'title'     => 'Operation log',
                'icon'      => 'fa-history',
                'uri'       => 'auth/logs',
            ],
        ]);

        // メニューに追加するロール設定を追加修正
        // add role to menu.
        Menu::where('title', 'Dashboard')->first()->roles()->save(Role::first());
        Menu::where('title', 'Admin')->first()->roles()->save(Role::first());
        Menu::where('title', 'ユーザー管理')->first()->roles()->save(Role::where('slug', 'user.administrator')->first());
    }
}
