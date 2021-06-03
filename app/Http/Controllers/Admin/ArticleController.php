<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Model\Category;

class ArticleController extends CommonController
{
    //get admin/article
    public function index()
    {
        echo '文章列表';
    }

    //get admin/article/create
    public function create()
    {
        $data = (new Category())->tree();;
        return view('admin.article.add', compact('data'));
    }


}
