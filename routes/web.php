<?php

use Conqui\Router;

Router::get('/test/{:id}/{:idd}', function($id,$idd){

});

//Main Page
Router::get('/', [App\Controller\HomeController::class, 'index']);
Router::get('/projects',[App\Controller\HomeController::class,'projects']);
Router::get('/contact',[App\Controller\HomeController::class,'contact']);

//Auth
Router::get('/login', [App\Controller\AuthenticationController::class, 'login']);
Router::get('/register', [App\Controller\AuthenticationController::class, 'register']);
Router::post('/register', [App\Controller\AuthenticationController::Class, 'registerUser']);
Router::post('/login', [App\Controller\AuthenticationController::class, 'authenticate']);
Router::post('/logout', [App\Controller\AuthenticationController::class, 'logout']);

//Blog
Router::get('/blog',[App\Controller\BlogController::class,'projects']);
Router::get('/blog/{:post}',[App\Controller\BlogController::class,'projects']);

// Admin Section
Router::get('/admin',[App\Controller\Admin\DashboardController::class,'index']);

Router::get('/admin/blog',[App\Controller\Admin\BlogController::class,'index']);
Router::get('/admin/blog/create',[App\Controller\Admin\BlogController::class,'create']);
Router::post('/admin/blog',[App\Controller\Admin\BlogController::class,'store']);
Router::get('/admin/blog/{:post}',[App\Controller\Admin\BlogController::class,'show']);
Router::get('/admin/blog/{:post}/edit',[App\Controller\Admin\BlogController::class,'edit']);
Router::patch('/admin/blog/{:post}',[App\Controller\Admin\BlogController::class,'update']);
Router::delete('/admin/blog/{:post}',[App\Controller\Admin\BlogController::class,'delete']);

