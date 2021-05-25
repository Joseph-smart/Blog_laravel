<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

require_once 'resources/org/code/Code.class.php';

class LoginController extends CommonController
{
    //登录视图
    public function login()
    {
        if ($input = Input::all()) {
            $code = new \Code;
            $_code = $code->get();
            if (strtoupper($input['code']) != $_code) {
                return back()->with('msg', '验证码错误');
            }
            $user = User::first();//用户模型
            if ($user->user_name != $input['user_name'] || Crypt::decrypt($user->user_pass) != $input['user_pass']) {
                return back()->with('msg', '用户名或密码错误');
            }
            session(['user' => $user]);//user信息写入session
            return redirect('admin/index');
        } else {
            session(['user' => null]);
            return view('admin.login');
        }
    }

    //生成验证码
    public function code()
    {
        $code = new \Code;
        $code->make();
    }

    //获取验证码
    public function getcode()
    {
        $code = new \Code;
        echo $code->get();
    }

    public function quit()
    {
        session(['user' => null]);
        return redirect('admin/login');
    }
    //加密
//    public function crypt()
//    {
//        //字符小于250个,长度在定义字段的时候用
//        $str = '123456';
//        echo Crypt::encrypt($str);
//        $str_p = Crypt::encrypt($str);
//        $str1 = Crypt::decrypt($str_p);
//        echo '<br/>';
//        echo $str1;
//    }
}
