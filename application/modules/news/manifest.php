<?php

$routes[] = ['GET', '/admin/news', 'GoCart\Controller\AdminNews#index'];
$routes[] = ['GET|POST', '/admin/news/form/[i:id]?', 'GoCart\Controller\AdminNews#form'];
$routes[] = ['GET|POST', '/admin/news/category_form/[i:id]?', 'GoCart\Controller\AdminNews#category_form'];
$routes[] = ['GET|POST', '/admin/news/category/[i:id]?', 'GoCart\Controller\AdminNews#category'];
$routes[] = ['GET|POST', '/admin/news/delete/[i:id]', 'GoCart\Controller\AdminNews#delete'];
$routes[] = ['GET|POST', '/admin/news/delete_category/[i:id]', 'GoCart\Controller\AdminNews#delete_category'];
$routes[] = ['GET|POST', '/news/category/[:slug]', 'GoCart\Controller\News#category'];
$routes[] = ['GET|POST', '/news/search/[:slug]', 'GoCart\Controller\News#search'];
$routes[] = ['GET|POST', '/news/[:slug]', 'GoCart\Controller\News#index'];