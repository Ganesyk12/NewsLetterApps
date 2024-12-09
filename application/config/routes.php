<?php
defined('BASEPATH') or exit('No direct script access allowed');

// $route['default_controller'] = 'auth';
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//check database connection
$route['menu'] = 'menu';
