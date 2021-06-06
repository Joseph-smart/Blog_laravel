<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Model\Article;
use App\Http\Model\Category;
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


}
