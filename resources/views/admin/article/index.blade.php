@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 文章管理
    </div>
    <!--面包屑导航 结束-->


    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_title">
                <h3>文章列表</h3>
            </div>
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>添加文章</a>
                    <a href="{{url('admin/article')}}"><i class="fa fa-recycle"></i>全部文章</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">ID</th>
                        <th>标题</th>
                        <th>点击</th>
                        <th>发布人</th>
                        <th>发布时间</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                        <tr>
                            <td class="tc">{{$v->id}}</td>
                            <td>
                                <a href="#">{{$v->title}}</a>
                            </td>
                            <td>{{$v->view}}</td>
                            <td>admin</td>
                            <td>{{$v->created_at}}</td>
                            <td>
                                <a href="{{url('admin/article/'.$v->id.'/edit')}}">修改</a>
                                <a href="javascript:;" onclick="deleteArticle({{$v->id}})">删除</a>
                            </td>
                        </tr>
                    @endforeach
                </table>

                <div class="page_list">
                    {{$data->links()}}
                </div>
            </div>
        </div>
    </form>
    <style>
        .result_content ul li span {
            font-size: 15px;
            padding: 6px 12px;
        }
    </style>

    <script>
        function deleteArticle(article_id) {
            layer.confirm('确定要删除文章？', {
                btn: ['确定', '取消'] //按钮
            }, function () {
                $.post('{{url('admin/article/')}}/' + article_id, {
                    '_method': 'delete',
                    '_token': '{{csrf_token()}}'
                }, function (data) {
                    if (data.status == 0) {
                        setTimeout(refresh, 2000);
                        layer.msg(data.message, {icon: 6});
                    } else {
                        setTimeout(refresh, 2000);
                        layer.msg(data.message, {icon: 5});
                    }
                });
            }, function () {
                layer.msg('已取消删除', {
                    time: 3000, //3s后自动关闭
                });
            });
        }

        function refresh() {
            location.href = location.href;
        }
    </script>
@endsection

