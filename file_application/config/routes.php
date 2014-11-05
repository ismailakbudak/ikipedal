<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

$route['default_controller'] = "main";
$route['404_override'] = '';

$route['^tr/seyahat-(.+)$'] = 'offers/detail/$1';
$route['^en/seyahat-(.+)$'] = 'offers/detail/$1';
$route['^tr/travel-(.+)$'] = 'offers/detail/$1';
$route['^en/travel-(.+)$'] = 'offers/detail/$1';

$route['^tr/ara-seyahat-sonuc(.+)$'] = 'offers/search/$1';
$route['^en/ara-seyahat-sonuc(.+)$'] = 'offers/search/$1';
$route['^tr/search-travel-result(.+)$'] = 'offers/search/$1';
$route['^en/search-travel-result(.+)$'] = 'offers/search/$1';
 
$route['^tr/ara-seyahat-sonuc'] = 'offers/search/$1'; 
$route['^en/ara-seyahat-sonuc'] = 'offers/search/$1';
$route['^tr/search-travel-result'] = 'offers/search/$1';
$route['^en/search-travel-result'] = 'offers/search/$1';

//$route['^tr/ara-seyahat-sonuc/(:any)'] = 'offers/search/$1';

$route['^tr/ara-seyahat-tarih-sonuc(.+)$'] = 'offers/searchByDate/$1';
$route['^en/ara-seyahat-tarih-sonuc(.+)$'] = 'offers/searchByDate/$1';
$route['^tr/search-travel-date-result(.+)$'] = 'offers/searchByDate/$1';
$route['^en/search-travel-date-result(.+)$'] = 'offers/searchByDate/$1';

$route['^tr/ara-seyahat-tarih-sonuc$'] = 'offers/searchByDate/$1';
$route['^en/ara-seyahat-tarih-sonuc$'] = 'offers/searchByDate/$1';
$route['^tr/search-travel-date-result$'] = 'offers/searchByDate/$1';
$route['^en/search-travel-date-result$'] = 'offers/searchByDate/$1';
 

// URI like '/en/about' -> use controller 'about'
$route['^tr/(.+)$'] = "$1";
$route['^en/(.+)$'] = "$1";
 

// '/en' and '/fr' URIs -> use default controller
$route['^tr$'] = $route['default_controller'];
$route['^en$'] = $route['default_controller'];
