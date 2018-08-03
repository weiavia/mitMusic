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

// 歌单
Route::get(':version/SongList', 'api/:version.SongList/getSongList');
Route::get(':version/ListInfo', 'api/:version.SongList/getListInfo');
Route::get(':version/SongList/Songs', 'api/:version.SongList/getSongs');
Route::get(':version/SongList/index', 'api/:version.SongList/getIndexDefaultList');
Route::get(':version/SongList/recommend', 'api/:version.SongList/getRecommendList');
Route::get(':version/Songlist/user', 'api/:version.songList/getUserSongList');
Route::post(':version/SongAndList', 'api/:version.SongList/addSongAndList');
Route::post(':version/songlist', 'api/:version.songList/create');
Route::get(':version/songlist/favorites', 'api/:version.songList/getFavorites');
Route::delete(':version/songlist/song', 'api/:version.songList/removeSong');
// todo 暂时使用这个名字
Route::get(':version/songlist2', 'api/:version.songList/get');

// 歌曲
Route::get(':version/song/lyric', 'api/:version.song/getLyric');

// token
Route::get(':version/token/verify', 'api/:version.token/verifyToken');
Route::post(':version/token', 'api/:version.token/getToken');
// Route::post(':version/token/cms', 'api/:version.token/getTokenCms');

// 验证码
Route::post(':version/verify/check', 'api/:version.verify/check');
Route::get(':version/verify', 'api/:version.verify/get');

// 用户
Route::post(':version/user/register', 'api/:version.user/register');
Route::get(':version/user/avatar', 'api/:version.user/findAvatar');
Route::get(':version/user/info', 'api/:version.user/getUserInfo');
Route::post(':version/avatar/upload', 'api/:version.avatar/upload');

// 歌荒互助
Route::post(':version/forum', 'api/:version.forum/addForum');
Route::get(':version/forum', 'api/:version.forum/select');


