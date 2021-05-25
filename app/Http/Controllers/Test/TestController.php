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

    //在blade中使用@php()来实现正则匹配代码嵌入
    public function picReplace()
    {
        $img = '<img src="https://ur-withzz-1254078007.cos.ap-guangzhou.myqcloud.com/richText/e3dd-2021051710/417/2b69dfd047bda1b373ecbd29df0e293_(2).jpg">';
        $test = htmlspecialchars($img);
//        echo $test;
        preg_match_all('/<img.*?src="(.*?)".*?>/is', $img, $arrImg);
        $arr = $arrImg[1][0];
        $img = str_replace($arr, asset($arr), $img);
        echo $img;
//        dd($arr);
    }
//https://ur-withzz-1254078007.cos.ap-guangzhou.myqcloud.com/richText/e3dd-2021051710/417/2b69dfd047bda1b373ecbd29df0e293_(2).jpg
//在src=后添加cid:

//ELASTIC SEARCH 相关代码学习
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'index' => [
                'nullable',
                Rule::in(['all', 'webcast', 'projects', 'spaces', 'articles', 'feeds', 'users', 'videos', 'webcasts_videos', 'tags'])
            ],
            'key' => 'required|string',
            'page' => 'nullable|int|min:1'
        ], [
            'key.required' => '请输入搜索关键字',
        ]);
        if ($validator->fails()) return response($validator->getMessageBag(), 422);
        //获取索引名
        $index = $request->query('index', 'all');
        empty($index) && $index = 'all';
        //获取索引关键字
        $key = str_replace("\\", ' ', $request->query('key', null));
        //获取搜索偏移
        $page = $request->query('page', 1);
        empty($page) && $page = 1;
        $from = $page - 1 > 0 ? ($page - 1) * 10 : 0;
        $url = $this->baseUrl . static::getIndexAlias($index) . "_search?ignore_unavailable=true&allow_no_indices=true&from={$from}";
        $json = call_user_func_array(array(static::class, "{index}Json"), array($key));
        $headers = array();
        $headers['headers'] = ['Content-Type' => 'application/json'];
        $headers['body'] = $json;
        $client = new Client($headers);
        $response = $client->get($url);
        $result = json_decode($response->getbody()->getContents(), true);
        return $this->filter($result, $page);
    }

}
