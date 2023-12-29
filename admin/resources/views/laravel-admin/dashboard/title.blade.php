<style>
    .title {
        font-size: 50px;
        color: #636b6f;
        font-family: 'Raleway', sans-serif;
        font-weight: 100;
        display: block;
        text-align: center;
        margin: 20px 0 10px 0px;
    }

    .links {
        text-align: center;
        margin-bottom: 20px;
    }

    .links > a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }

    /* ダッシュボードメニュー用 */
    .main {
        width: 100%;
        margin-bottom: 20px;
    }

    .main .content {
        width: 80%;
        height: 90%;
        background-color: white;
    }

    .main .content h3 {
        margin-bottom: 30px;
    }

    .main .content ul {
        font-size: large;
    }

    .main .content li {
        margin-bottom: 20px;
    }

    .main .content .fa-angle-left:before {
        display: none;
    }

    .main .content li .treeview-menu {
        margin-top: 10px;
        margin-bottom: 20px;
    }

</style>

<div class="title">
    管理メニュー
</div>
<div class="main">
    <div class="content">
        <ul>
            @each('admin::partials.menu', Admin::menu(), 'item')
        </ul>
    </div>
</div>