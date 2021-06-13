<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController
{
    //get admin/article
    public function index()
    {
        $data = Article::orderBy('created_at', 'desc')->paginate(10);
        return view('admin/article.index', compact('data'));
    }

    //get admin/article/create
    public function create()
    {
        $data = (new Category())->tree();;
        return view('admin.article.add', compact('data'));
    }

    //post admin/article
    public function store()
    {
        $input = Input::except('_token');
        $rules = [
            'title' => 'required',
            'content' => 'required',

        ];
        $message = [
            'title.required' => '标题不能为空！',
            'content.required' => '内容不能为空！',
        ];
        $validator = Validator::make($input, $rules, $message);
        //验证通过
        if ($validator->passes()) {
            $response = Article::create($input);
            if ($response) {
                return redirect('admin/article');
            } else {
                return back()->with('errors', '创建失败');
            }
        } else {
            return back()->withErrors($validator);
        }

    }

    //get admin/article/{article_id}/edit 编辑文章
    public function edit($article_id)
    {
        $data = (new Category())->tree();
        $article = Article::where('id', $article_id)->firstOrFail();
        return view('admin.article.edit', compact('data', 'article'));
    }

    //put admin/article/{article_id}
    public function update($article_id)
    {
        $input = Input::except('_token', '_method');
        $result = Article::where('id', $article_id)
            ->update($input);
        if ($result) {
            return redirect('admin/article');
        } else {
            return back()->with('errors', '更新失败！');
        }
    }

    public function destroy($article_id)
    {
        $response = Article::where('id', $article_id)->delete();
        if ($response) {
            $data = [
                'status' => 0,
                'message' => '删除成功'
            ];
        } else {
            $data = [
                'status' => 1,
                'message' => '删除失败'
            ];
        }
        return $data;
    }


}
