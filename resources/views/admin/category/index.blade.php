@extends('layouts.admin')
@section('content')
    <div class="crumb_warp">
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 分类管理
    </div>

    {{--    <!--结果页快捷搜索框 开始-->--}}
    {{--    <div class="search_wrap">--}}
    {{--        <form action="" method="post">--}}
    {{--            <table class="search_tab">--}}
    {{--                <tr>--}}
    {{--                    <th width="120">选择分类:</th>--}}
    {{--                    <td>--}}
    {{--                        <select onchange="javascript:location.href=this.value;">--}}
    {{--                            <option value="">全部</option>--}}
    {{--                            <option value="http://www.baidu.com">百度</option>--}}
    {{--                            <option value="http://www.sina.com">新浪</option>--}}
    {{--                        </select>--}}
    {{--                    </td>--}}
    {{--                    <th width="70">关键字:</th>--}}
    {{--                    <td><input type="text" name="keywords" placeholder="关键字"></td>--}}
    {{--                    <td><input type="submit" name="sub" value="查询"></td>--}}
    {{--                </tr>--}}
    {{--            </table>--}}
    {{--        </form>--}}
    {{--    </div>--}}
    {{--    <!--结果页快捷搜索框 结束-->--}}

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>分类管理</h3>
            </div>
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/category/create')}}"><i class="fa fa-plus"></i>添加分类</a>
                    <a href="{{url('admin/category')}}"><i class="fa fa-recycle"></i>全部分类</a>
                </div>
            </div>
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%">排序</th>
                        <th class="tc" width="5%">ID</th>
                        <th>分类名称</th>
                        <th>标题</th>
                        <th>查看次数</th>
                        <th>操作</th>
                    </tr>

                    @foreach($data as $v)
                        <tr>
                            <td class="tc">
                                <input type="text" onchange="changeOrder(this,{{$v->cate_id}})"
                                       value="{{$v->cate_order}}">
                            </td>
                            <td class="tc">{{$v->cate_id}}</td>
                            <td>
                                <a href="#">{{$v->_cate_name}}</a>
                            </td>
                            <td>{{$v->cate_title}}</td>
                            <td>{{$v->cate_view}}</td>
                            <td>
                                <a href="{{url('admin/category/'.$v->cate_id.'/edit')}}">修改</a>
                                <a href="javascript:;" onclick="deleteCategory({{$v->cate_id}})">删除</a>
                            </td>
                        </tr>
                    @endforeach

                </table>

                {{--分页待完善--}}
                <div class="page_nav">
                    <div>
                        <a class="first" href="/wysls/index.php/Admin/Tag/index/p/1.html">第一页</a>
                        <a class="prev" href="/wysls/index.php/Admin/Tag/index/p/7.html">上一页</a>
                        <a class="num" href="/wysls/index.php/Admin/Tag/index/p/6.html">6</a>
                        <a class="num" href="/wysls/index.php/Admin/Tag/index/p/7.html">7</a>
                        <span class="current">8</span>
                        <a class="num" href="/wysls/index.php/Admin/Tag/index/p/9.html">9</a>
                        <a class="num" href="/wysls/index.php/Admin/Tag/index/p/10.html">10</a>
                        <a class="next" href="/wysls/index.php/Admin/Tag/index/p/9.html">下一页</a>
                        <a class="end" href="/wysls/index.php/Admin/Tag/index/p/11.html">最后一页</a>
                        <span class="rows">11 条记录</span>
                    </div>
                </div>


            </div>
        </div>
    </form>

    <script>
        function refresh() {
            location.href = location.href;
        }

        function changeOrder(obj, cate_id) {
            var cate_order = $(obj).val();
            $.post('{{url('admin/cate/changeorder')}}', {
                '_token': '{{csrf_token()}}',
                'cate_id': cate_id,
                'cate_order': cate_order,
            }, function (data) {
                if (data.status == 0) {
                    layer.msg(data.message, {icon: 6});
                } else {
                    //失败
                    layer.msg(data.message, {icon: 5});
                }
            });
        }

        //删除分类
        function deleteCategory(cate_id) {
            layer.confirm('确定要删除分类？', {
                btn: ['确定', '取消'] //按钮
            }, function () {
                $.post('{{url('admin/category/')}}/' + cate_id, {
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

    </script>
@endsection



