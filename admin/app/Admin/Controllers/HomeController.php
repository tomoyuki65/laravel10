<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Facades\Admin;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        if (Admin::user()->isAdministrator()) {
            $res = $content
                       ->title('ダッシュボード')
                       ->row(Dashboard::title())
                       ->row(Dashboard::environment());
        } else {
            // Administrator以外はenvironmentを非表示
            $res = $content
                       ->title('ダッシュボード')
                       ->row(Dashboard::title());
        }

        return $res;
    }
}
