@extends('layouts.public')

@section('head')
    <link rel="stylesheet" href="{{cdn('js/plugins/webuploader/single.css')}}">

    <link rel="stylesheet" href="{{cdn('js/plugins/editor.md-master/css/editormd.css')}}">
@endsection

@section('bodyattr')class="gray-bg"@endsection

@section('body')
    <div class="wrapper wrapper-content">

        <div class="row m-b">
            <div class="col-sm-12">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li><a href="{{route('admin.article.article')}}">文章列表</a></li>
                        <li @if (!isset($article))class="active"@endif><a href="{{route('admin.article.article.add')}}">添加文章</a>
                        </li>
                        @if (isset($article))
                            <li class="active"><a href="#">编辑文章</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form action="{{route('admin.article.article.save')}}" method="get"
                              class="form-horizontal ajaxForm" id="form_self">
                            <input type="hidden" name="article_id" value="{{$article->article_id or 0}}"/>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">标题</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="title" autocomplete="off"
                                           value="{{$article->title or ''}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">副标题</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="sub_title" autocomplete="off"
                                           value="{{$article->sub_title or ''}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">文章来源</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="source" autocomplete="off"
                                           value="{{$article->source or ''}}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">关键词</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="keywords" autocomplete="off"
                                           value="{{$article->keywords or ''}}" placeholder="多个词请用逗号分隔"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">所属分类</label>
                                <div class="col-sm-6">
                                    <select name="cate_id" class="form-control">
                                        <option value="">--请选择分类--</option>
                                        @foreach ($cates as $cate)
                                            @if ($cate['layer'] < 1)
                                                <option value="" disabled="disabled">--{{$cate['cate_name']}}--</option>
                                            @else
                                                <option value="{{$cate['cate_id']}}"
                                                        @if ((isset($article->cate_id) ? $article->cate_id : '') == $cate['cate_id']) selected="selected"@endif>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;{{$cate['cate_name']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">文章头图</label>
                                <div class="col-sm-10" id="imgupload">
                                    <div id="filePicker">选择图片</div>
                                    @if(isset($article) && $article->default_img != '')
                                        <div class="img-div">
                                            <img src="{{get_file_url($article->default_img)}}"/>
                                            <span class="cancel">×</span>
                                        </div>
                                    @endif
                                </div>
                                <input type="hidden" name="default_img" id="default_img"
                                       value="{{$article->default_img or ''}}"/>
                                <input type="hidden" name="file_id" id="file_id" value="0"/>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">简介</label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" name="des">{{$article->des or ''}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">

                                <label class="col-sm-2 control-label">内容</label>

                                <div class="col-sm-8">
                                    <div id="test-editor">
                                        <textarea style="display:none;">{!! $article->content or '' !!}</textarea>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-2 control-label">状态</label>
                                <div class="col-sm-10">
                                    <div class="input-group m-t-xs-2">
                                        <input type="radio" name="is_show" value="1"
                                               @if ((isset($article->is_show) ? $article->is_show : '') != '0') checked="checked"@endif/>显示
                                        <input type="radio" name="is_show" value="0"
                                               @if ((isset($article->is_show) ? $article->is_show : '') == '0') checked="checked"@endif/>不显示
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">评论</label>
                                <div class="col-sm-10">
                                    <div class="input-group m-t-xs-2">
                                        <input type="radio" name="is_comment" value="1"
                                               @if ((isset($article->is_comment) ? $article->is_comment : '') != '0') checked="checked"@endif/>允许
                                        <input type="radio" name="is_comment" value="0"
                                               @if ((isset($article->is_comment) ? $article->is_comment : '') == '0') checked="checked"@endif/>不允许
                                    </div>
                                </div>
                            </div>
                            <input type='hidden' name='content' id='content'/>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">置顶</label>
                                <div class="col-sm-10">
                                    <div class="input-group m-t-xs-2">
                                        <input type="radio" name="is_top" value="1"
                                               @if ((isset($article->is_top) ? $article->is_top : '') == '1') checked="checked"@endif/>置顶
                                        <input type="radio" name="is_top" value="0"
                                               @if ((isset($article->is_top) ? $article->is_top : '') != '1') checked="checked"@endif/>不置顶
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">推荐</label>
                                <div class="col-sm-10">
                                    <div class="input-group m-t-xs-2">
                                        <input type="radio" name="is_recommend" value="1"
                                               @if ((isset($article->is_recommend) ? $article->is_recommend : '') == '1') checked="checked"@endif/>推荐
                                        <input type="radio" name="is_recommend" value="0"
                                               @if ((isset($article->is_recommend) ? $article->is_recommend : '') != '1') checked="checked"@endif/>不推荐
                                    </div>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary" type="button" onclick="do_submit()">保存</button>
                                    <button class="btn btn-white" type="button" id="backBtn">返回</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script src="https://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <script src="{{cdn('js/plugins/editor.md-master/editormd.js')}}"></script>

    <script type="text/javascript">
        var editor = null;
        $(function () {
            editor = editormd("test-editor", {
                // width  : "100%",
                 height : "600px",
                path: "{{cdn('js/plugins/editor.md-master/lib/')}}/",
                watch:false
            });
        });

        function do_submit() {
            content = editor.getMarkdown()
            $('#content').val(content)
            $('#form_self').submit()
        }
    </script>


@endsection
