@extends('layouts.public')

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">
        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route('admin.info.fundList')}}">基金列表</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <form role="form" class="form-inline" method="get">
                            <div class="form-group">
                                <label class="sr-only">规模</label>
                                <input type="text" name="jjdm" placeholder="基金代码" class="form-control"
                                       value="{{request('jjdm')}}">
                                <input type="text" name="name" placeholder="基金名称" class="form-control"
                                       value="{{request('name')}}">
                                <select class="form-control" name="status">
                                    <option value="0" > 全部</option>
                                    <option value="1" @if(request('status') == 1) selected @endif> 正常</option>
                                    <option value="2" @if(request('status') == 2) selected @endif> 非正常</option>
                                </select>
                                
                            </div>

                            <button type="submit" class="btn btn-primary">搜索</button>
                            <button type="button" class="btn btn-white"
                                    onclick="location.href='{{route('admin.info.fundList')}}'">重置
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <table class="table table-striped table-bordered table-hover dataTables-example dataTable">
                            <thead>
                            <tr role="row">
                                <th>id</th>
                                <th>名称</th>
                                <th>基金类型</th>
                                <th>基金规模</th>
                                <th>创建日期</th>
                                <th>状态</th>
                                <th>操作</th>

                            </tr>
                            </thead>
                            @foreach($info as $user)
                                <tr class="gradeA">
                                    <td>
                                        <a target="_blank" href="http://fund.eastmoney.com/{{$user['jjdm']}}.html">
                                            {{$user['jjdm']}} </a></td>
                                    <td>

                                        {{$user->name}}

                                    </td>
                                    <td>{{$user->jijin_type}}</td>
                                    <td>{{$user->jijin_guimo}}</td>
                                    <td>{{$user->jijin_create_day}}</td>
                                    <td>
                                        @if($user->status == 1)
                                            正常
                                        @else
                                            非正常
                                        @endif
                                    </td>
                                    <td>
                                        <a class="ajaxBtn" href="javascript:void(0);" uri="{{route('admin.info.fundSet',[$user->jjdm])}}" msg="是否删除该基金状态？">设置</a>
                                    </td>

                                </tr>
                            @endforeach
                        </table>
                        <div class="row">
                            <div class="col-sm-12">
                                {{--<div>共 {{ $users->total() }} 条记录</div>--}}
                                {!! $info->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
