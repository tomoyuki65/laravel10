<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

// カスタムフォーム
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Form\Builder;

class CustomForm extends Form
{
    // 新規作成処理後のリダイレクト処理のオーバーライド
    protected function redirectAfterStore()
    {
        // ここに行いたい処理を書く

        $resourcesPath = $this->resource(0);

        $key = $this->model->getKey();

        return $this->redirectAfterSaving($resourcesPath, $key);
    }

    // 更新処理後のオーバーライド
    public function update($id, $data = null)
    {
        // ここに行いたい処理を書く
    
        $data = ($data) ?: request()->all();

        $isEditable = $this->isEditable($data);

        if (($data = $this->handleColumnUpdates($id, $data)) instanceof Response) {
            return $data;
        }

        /* @var Model $this ->model */
        $builder = $this->model();

        if ($this->isSoftDeletes) {
            $builder = $builder->withTrashed();
        }

        $this->model = $builder->with($this->getRelations())->findOrFail($id);

        $this->setFieldOriginalValue();

        // Handle validation errors.
        if ($validationMessages = $this->validationMessages($data)) {
            if (!$isEditable) {
                return back()->withInput()->withErrors($validationMessages);
            }

            return response()->json(['errors' => Arr::dot($validationMessages->getMessages())], 422);
        }

        if (($response = $this->prepare($data)) instanceof Response) {
            return $response;
        }

        DB::transaction(function () {
            $updates = $this->prepareUpdate($this->updates);

            foreach ($updates as $column => $value) {
                /* @var Model $this ->model */
                $this->model->setAttribute($column, $value);
            }

            $this->model->save();

            $this->updateRelation($this->relations);
        });

        if (($result = $this->callSaved()) instanceof Response) {
            return $result;
        }

        if ($response = $this->ajaxResponse(trans('admin.update_succeeded'))) {
            return $response;
        }

        return $this->redirectAfterUpdate($id);
    }

    // 更新処理後のリダイレクト処理のオーバーライド
    protected function redirectAfterUpdate($key)
    {
        // ここに行いたい処理を書く

        $resourcesPath = $this->resource(-1);

        return $this->redirectAfterSaving($resourcesPath, $key);
    }

    // 保存処理後のリダイレクト処理のオーバーライド
    protected function redirectAfterSaving($resourcesPath, $key)
    {
        // ここに行いたい処理を書く

        if (request('after-save') == 1) {
            // continue editing
            $url = rtrim($resourcesPath, '/')."/{$key}/edit";
        } elseif (request('after-save') == 2) {
            // continue creating
            $url = rtrim($resourcesPath, '/').'/create';
        } elseif (request('after-save') == 3) {
            // view resource
            $url = rtrim($resourcesPath, '/')."/{$key}";
        } else {
            $url = request(Builder::PREVIOUS_URL_KEY) ?: $resourcesPath;
        }

        admin_toastr(trans('admin.save_succeeded'));

        return redirect($url);
    }

}

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'ユーザー';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        // 論理削除データも表示
        $grid->model()->query()->withTrashed()->orderBy('id', 'desc');

        $grid->column('id', __('id'));
        $grid->column('uid', __('uid'));
        $grid->column('name', __('名前'));
        $grid->column('email', __('メールアドレス'));
        $grid->column('created_at', __('作成日時'));
        $grid->column('updated_at', __('更新日時'));
        $grid->column('deleted_at', __('削除日時'));

        // フィルタ設定
        $grid->filter(function($filter){
            $filter->equal('uid', 'uid');
            $filter->like('name', '名前');
            $filter->like('email', 'メールアドレス');
            $filter->between("created_at", '作成日')->datetime();
            $filter->between("updated_at", '更新日')->datetime();
            $filter->between("deleted_at", '削除日')->datetime();

            $filter->where(function ($query) {
                if ($this->input[0] == '1') {
                    $query->where('deleted_at', NULL);
                } elseif ($this->input[0] == '2') {
                    $query->where('deleted_at', '!=', NULL);
                }
            }, 'ステータス')->radio([
                '1' => 'アクティブ',
                '2' => '削除済'
            ]);

        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        // 論理削除データも表示
        $show = new Show(User::withTrashed()->findOrFail($id));

        $show->field('id', __('id'));
        $show->field('uid', __('uid'));
        $show->field('name', __('名前'));
        $show->field('email', __('メールアドレス'));
        $show->field('created_at', __('作成日時'));
        $show->field('updated_at', __('更新日時'));
        $show->field('deleted_at', __('削除日時'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->text('uid', __('uid'));
        $form->text('name', __('名前'));
        $form->email('email', __('メールアドレス'));
        $form->datetime('deleted_at', __('削除日時'));

        return $form;
    }
}
