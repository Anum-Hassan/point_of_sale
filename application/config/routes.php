<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'AuthController/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['login'] = 'AuthController/login';
$route['register'] = 'AuthController/register';
$route['authenticate'] = 'AuthController/authenticate';
$route['dashboard'] = 'DashboardController';
$route['logout'] = 'AuthController/logout'; 
$route['admins'] = 'AdminController/index'; 
$route['categories'] = 'CategoryController';
$route['subCategories'] = 'SubController';
$route['products'] = 'ProductController';
$route['category/add-sub-category'] = 'CategoryController/add_sub_category';