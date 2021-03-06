<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
    <meta name="applicable-device" content="mobile">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta http-equiv="Cache-Control" content="no-transform" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>{{$info->exhibit_name or ''}}</title>
</head>
<body>
<h1>展品名称</h1>
{{$info->exhibit_name or ''}}
<h1>展品详情图</h1>
@if(!empty($info->exhibit_img))
    @foreach(json_decode($info->exhibit_img,true)['exhibit_imgs'] as $k=>$g)
        <img src="{{get_file_url($g)}}">
    @endforeach
@endif
<h1>展品语音</h1>
<audio src="{{$info->audio or ''}}" id="audio"></audio>
<h1>展品内容</h1>
{!! $info->content or '' !!}
<h1>展品科普知识</h1>
{!! $info->knowledge or '' !!}
</body>
