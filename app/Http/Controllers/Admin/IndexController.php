<?php

namespace App\Http\Controllers\Admin;


use App\Http\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class IndexController extends CommonController
{
    public function index()
    {
        return view('admin.index');
    }

    public function info()
    {
        return view('admin.info');
    }

    //change your Administrator password
    public function pass()
    {
        if ($input = Input::all()) {
            $rules = [
                'password' => 'required|between:6,20|confirmed',
            ];

            $message = [
                'password.required' => '新密码不能为空！',
                'password.between' => '新密码必须在6-20位！',
                'password.confirmed' => '新密码和确认密码不一致！',
            ];
            $validator = Validator::make($input, $rules, $message);

            if ($validator->passes()) {
                $user = User::first();
                $_password = Crypt::decrypt($user->user_pass);
                if ($input['password_o'] == $_password) {
                    $user->user_pass = Crypt::encrypt($input['password']);
                    $user->update();
                    return view('admin.info');
                } else {
                    return back()->with('errors', '原密码错误！');
                }
            } else {
                //打印错误信息
                //dd($validator->errors()->all());
                return back()->withErrors($validator);
            }

        } else {
            return view('admin.pass');
        }
    }
}
