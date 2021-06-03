@extends('layouts.admin')
@section('content')
    <div class="crumb_warp">
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 文章管理
    </div>

    <div class="result_wrap">
        <div class="result_title">
            <h3>添加文章</h3>
            @if(count($errors)>0)
                <div class="mark">
                    @if(is_object($errors))
                        @foreach($errors->all() as $error)
                            <p> {{$error}}</p>
                        @endforeach
                    @else
                        <p>{{$errors}}</p>
                    @endif
                </div>
            @endif
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>添加文章</a>
                <a href="{{url('admin/article')}}"><i class="fa fa-recycle"></i>全部文章</a>
{{--                <a href="#"><i class="fa fa-refresh"></i>更新排序</a>--}}
            </div>
        </div>
    </div>

    <div class="result_wrap">
        <form action="{{url('admin/category')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th width="120">分类：</th>
                    <td>
                        <select name="cate_id">
                            @foreach($data as $item)
                                <option value="{{$item->cate_id}}">{{$item->_cate_name}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>标题：</th>
                    <td>
                        <input type="text" class="lg" name="article_title">
                    </td>
                </tr>
                <tr>
                    <th>编辑：</th>
                    <td>
                        <input type="text" class="sm" name="article_author">
                    </td>
                </tr>
                <tr>
                    <th>封面：</th>
                    <td>
                        <input type="text" size="50" name="article_cover">
                    </td>
                </tr>
                <tr>
                    <th>标签：</th>
                    <td>
                        <input type="text" class="lg" name="article_tag">
                    </td>
                </tr>
                <tr>
                    <th>描述：</th>
                    <td>
                        <textarea name="article_description"></textarea>
                    </td>
                </tr>

                <tr>
                    <th>正文：</th>
                    <td>
                        <textarea name="article_content"></textarea>
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection

