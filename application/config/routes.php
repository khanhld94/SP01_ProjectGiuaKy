<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Frontend
$route['default_controller'] = 'frontend/home/index/';
$route['404_override'] = '';
$route['^(index)/trang-([0-9]+)$']='frontend/home/index/$2';
$route['index']='frontend/home/index/';


$route['c([0-9]+)/([a-zA-Z0-9/-]+)/trang-([0-9]+)$'] = 'frontend_article/catalogue/index/$1/$3';
$route['c([0-9]+)/([a-zA-Z0-9/-]+)$'] = 'frontend_article/catalogue/index/$1';
$route['a([0-9]+)/(exchange)$'] = 'frontend_article/exchange/index/$1';
$route['a([0-9]+)/(notification)$']='frontend/notification/$1';
// Article
$route['a([0-9]+)/([a-zA-Z0-9/-]+)$'] = 'frontend_article/post/index/$1';

// Product

// Cart
$route['^(dang-ky|register)/(\d+)$'] = 'frontend_user/register/index/$2';
$route['^(select-account-type)$'] = 'frontend_user/register/select_printer';
$route['^register/printer-account$'] = 'frontend_user/register/index/2';
$route['^register/normal-account$'] = 'frontend_user/register/index/1';

$route['^(dang-ky|register)$'] = 'frontend_user/register/index';
$route['^(dang-nhap|login)$'] = 'frontend_user/authentication/index';
$route['^(login-facebook)$'] = 'frontend_user/login/facebook';
$route['^(login-google)$'] = 'frontend_user/login/google';
$route['^(dang-xuat|logout)$'] = 'frontend_user/logout/index';
$route['^(change-information)$'] = 'frontend_user/information/index';
$route['^(change-password)$'] = 'frontend_user/password/index';
$route['^(initialize-password)$'] = 'frontend_user/password/created';
$route['^(tai-khoan|account)$'] = 'frontend_user/information/index';


$route['product/tags$'] = 'frontend_product/tags/index';

//Search
$route['^(tim-kiem|product)$'] = 'frontend_product/search/index';