<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Dotenv\Validator;
use http\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TestController extends Controller
{
    public static function curl_post($url, $array)
    {

        $curl = curl_init();
        //设置提交的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        //设置post数据
        $post_data = $array;
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        //执行命令
        $data = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //获得数据并返回
        return $data;
    }

    public function timeCompare()
    {


        //比较时间函数demo
//        $startdate="2010-12-11 11:40:00";
//        $enddate="2012-12-12 11:45:09";
//        $date=floor((strtotime($enddate)-strtotime($startdate))/86400);
//        $hour=floor((strtotime($enddate)-strtotime($startdate))%86400/3600);
//        $minute=floor((strtotime($enddate)-strtotime($startdate))%86400/60);
//        $second=floor((strtotime($enddate)-strtotime($startdate))%86400%60);
//        echo $date."天<br>";
//        echo $hour."小时<br>";
//        echo $minute."分钟<br>";
//        echo $second."秒<br>";

        $test = date('Y-m-d H:i:s');
        echo $test . "<br>";
        $time = 1618833502;
        $result = date("Y-m-d H:i:s", $time);
        echo $result . "<br>";

        echo '改成时间戳<br>';
        $change1 = strtotime($test);
        echo $change1 . '<br>';
        $change2 = strtotime($result);
        echo $change2 . '<br>';

    }

    public function getTime()
    {
        $sent_at = date('Y-m-d H:i:s', time());
        return $sent_at;
    }
}
