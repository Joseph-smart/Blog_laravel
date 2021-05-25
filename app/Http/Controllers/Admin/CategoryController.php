<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends CommonController
{
    //通过ORM方式来读取模型里有哪些东西
    //get admin/category 全部分类列表
    public function index()
    {
        $categories = (new Category)->tree();
        return view('admin.category.index')->with('data', $categories);
    }

    public function changeOrder()
    {
        $input = Input::all();
        $cate = Category::find($input['cate_id']);
        $cate->cate_order = $input['cate_order'];
        $message = $cate->update();
        //执行成功
        if ($message) {
            $data = [
                'status' => 0,
                'message' => '分类排序更新成功！',
            ];
        } else {
            $data = [
                'status' => 1,
                'message' => '分类排序更新失败！',
            ];
        }
        return $data;
    }

    //post admin/category 添加分类提交
    public function store()
    {
        $input = Input::except('_token'); //除了token，其他的数据都要写入数据库
        $rules = [
            'cate_name' => 'required',
        ];
        $message = [
            'cate_name.required' => '分类名称不能为空！',
        ];
        $validator = Validator::make($input, $rules, $message);
        //验证通过
        if ($validator->passes()) {
            $result = Category::create($input);
            if ($result) {
                return redirect('admin/category');
            } else {
                return back()->with('errors', '请求数据库失败！');
            }
        } else {
            return back()->withErrors($validator);
        }
    }

    //get admin/category/create 添加分类
    public function create()
    {
        //查询后使用compact方法把参数带入模板
        $data = Category::where('cate_pid', 0)->get();
        return view('admin/category/add', compact('data'));
    }

    //get admin/category/{category} 显示单个分类信息
    public function show()
    {

    }

    //delete admin/category/{category} 删除单个分类
    public function destroy()
    {

    }

    //put admin/category/{category} 更新分类
    public function update($cate_id)
    {
        $input = Input::except('_token', '_method');
        $result = Category::where('cate_id', $cate_id)
            ->update($input);
        if ($result) {
            return redirect('admin/category');
        } else {
            return back()->with('errors', '更新失败！');
        }
    }

    //get admin/category/{category}/edit 编辑分类
    public function edit($cate_id)
    {
        $data = Category::where('cate_pid', 0)->get(); //父级分类
        $category = Category::findOrFail($cate_id);
        return view('admin/category.edit', compact('category', 'data'));
    }

}
