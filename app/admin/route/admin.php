<?php
use think\facade\Route;

Route::post('login', '\app\admin\controller\admin\LoginController@act');
Route::post('refresh_token', '\app\admin\controller\admin\LoginController@refreshToken');

Route::group(function (){
    Route::post('logout', '\app\admin\controller\admin\LoginController@logout');

    Route::post('upload/image', '\app\admin\controller\article\CommonController@uploadImage');

    Route::get('article/detail', '\app\admin\controller\article\ArticleController@detail');
    Route::get('article/list', '\app\admin\controller\article\ArticleController@list');
    Route::post('article/save', '\app\admin\controller\article\ArticleController@save');

    Route::get('article/category/parent', '\app\admin\controller\article\CategoryController@parent');
    Route::get('article/category/select', '\app\admin\controller\article\CategoryController@select');
    Route::get('article/category/list', '\app\admin\controller\article\CategoryController@list');
    Route::post('article/category/save', '\app\admin\controller\article\CategoryController@save');
    Route::delete('article/category/del', '\app\admin\controller\article\CategoryController@del');

    Route::get('article/tag/select', '\app\admin\controller\article\TagController@select');
    Route::get('article/tag/list', '\app\admin\controller\article\TagController@list');
    Route::post('article/tag/save', '\app\admin\controller\article\TagController@save');
    Route::delete('article/tag/del', '\app\admin\controller\article\TagController@del');
})->middleware('\app\middleware\AdminAuth');
