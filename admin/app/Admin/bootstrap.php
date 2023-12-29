<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

Encore\Admin\Form::forget(['map', 'editor']);

// カスタマイズのため、「/resources/views/laravel-admin」に配置したファイルを読み取る設定
app('view')->prependNamespace('admin', resource_path('views/laravel-admin'));

// ヘッダーの背景色をカスタマイズ
use Encore\Admin\Admin;
$env = config('app.display_env');
if ($env == 'local') {
    Admin::style('.skin-blue-light .main-header .logo {background-color: dimgray;}');
    Admin::style('.skin-blue-light .main-header .navbar {background-color: dimgray;}');
    Admin::style('.navbar-nav>.user-menu>.dropdown-menu>li.user-header {background-color: dimgray;}');
} elseif ($env == 'development') {
    Admin::style('.skin-blue-light .main-header .logo {background-color: #009977;}');
    Admin::style('.skin-blue-light .main-header .navbar {background-color: #009977;}');
    Admin::style('.navbar-nav>.user-menu>.dropdown-menu>li.user-header {background-color: #009977;}');
} elseif ($env == 'staging') {
    Admin::style('.skin-blue-light .main-header .logo {background-color: #B384FF;}');
    Admin::style('.skin-blue-light .main-header .navbar {background-color: #B384FF;}');
    Admin::style('.navbar-nav>.user-menu>.dropdown-menu>li.user-header {background-color: #B384FF;}');
} elseif ($env == 'production') {
    Admin::style('.skin-blue-light .main-header .logo {background-color: #2C7CFF;}');
    Admin::style('.skin-blue-light .main-header .navbar {background-color: #2C7CFF;}');
    Admin::style('.navbar-nav>.user-menu>.dropdown-menu>li.user-header {background-color: #2C7CFF;}');
}