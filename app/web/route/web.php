<?php
use think\facade\Route;

Route::get('home/menus', '\app\web\controller\HomeController@menus');
Route::get('article/detail', '\app\web\controller\ArticleController@detail');
Route::get('article/list', '\app\web\controller\ArticleController@list');
Route::get('category/info', '\app\web\controller\CategoryController@info');
Route::get('tags/all', '\app\web\controller\TagController@all');
Route::get('tag/info', '\app\web\controller\TagController@info');
Route::post('tools/fanQie', '\app\web\controller\ToolsController@fanQie');
