<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

Route::get('hello/:name', 'index/hello');
Route::get(':name/:temp','index/getluodi/getLuodi')->pattern(['name' => '.*', 'temp' => '.*']);
Route::get(':name','index/getluodi/getLuodi')->pattern(['name' => '.*']);

return [

    //新版找落地
    'create/:temp' => 'index/getluodi/getLuodi',//模块 控制器 方法名 分享成功基数
    'image/:temp' => 'index/getluodi/getLuodi',//模块 控制器 方法名 分享成功基数
    'video/:temp' => 'index/getluodi/getLuodi',//模块 控制器 方法名 分享成功基数
    'getsome/:temp' => 'index/getluodi/getLuodi',//模块 控制器 方法名 分享成功基数
    'info/:temp' => 'index/getluodi/getLuodi',//模块 控制器 方法名 分享成功基数
    'wxapp/:temp' => 'index/getluodi/getLuodi',//模块 控制器 方法名 分享成功基数
    'wxopen/:temp' => 'index/getluodi/getLuodi',//模块 控制器 方法名 分享成功基数

    //第二轮
    'hanbanger/:temp' => 'index/getluodi/getLuodi',//模块 控制器 方法名 分享成功基数
    'holiday/:temp' => 'index/getluodi/getLuodi',//模块 控制器 方法名 分享成功基数
    'weekend/:temp' => 'index/getluodi/getLuodi',//模块 控制器 方法名 分享成功基数
    'mondy/:temp' => 'index/getluodi/getLuodi',//模块 控制器 方法名 分享成功基数
    'tom/:temp' => 'index/getluodi/getLuodi',//模块 控制器 方法名 分享成功基数
    'emily/:temp' => 'index/getluodi/getLuodi',//模块 控制器 方法名 分享成功基数

];
