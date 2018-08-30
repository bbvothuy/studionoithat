<?php

$routes[] = ['GET|POST', '/admin/products/product_autocomplete', 'GoCart\Controller\AdminProducts#product_autocomplete'];
$routes[] = ['GET|POST', '/admin/products/bulk_save', 'GoCart\Controller\AdminProducts#bulk_save'];
$routes[] = ['GET|POST', '/admin/products/product_image_form', 'GoCart\Controller\AdminProducts#product_image_form'];
$routes[] = ['GET|POST', '/admin/products/add_wishlist', 'GoCart\Controller\Product#add_wishlist'];
$routes[] = ['GET|POST', '/admin/products/product_image_upload', 'GoCart\Controller\AdminProducts#product_image_upload'];
$routes[] = ['GET|POST', '/admin/products/form/[i:id]?/[i:copy]?', 'GoCart\Controller\AdminProducts#form'];
$routes[] = ['GET|POST', '/admin/products/gift-card-form/[i:id]?/[i:copy]?', 'GoCart\Controller\AdminProducts#giftCardForm'];
$routes[] = ['GET|POST', '/admin/products/delete/[i:id]', 'GoCart\Controller\AdminProducts#delete'];
$routes[] = ['GET|POST', '/admin/products/product_bonus', 'GoCart\Controller\AdminProducts#product_bonus'];
$routes[] = ['GET|POST', '/admin/products/[i:rows]?/[:order_by]?/[:sort_order]?/[:code]?/[i:page]?', 'GoCart\Controller\AdminProducts#index'];
$routes[] = ['GET|POST', '/product/get_product/[:id]', 'GoCart\Controller\Product#get_product'];
$routes[] = ['GET|POST', '/product/add_cart_product/[:id]', 'GoCart\Controller\Product#add_cart_product'];
$routes[] = ['GET|POST', '/product/get_list_items', 'GoCart\Controller\Product#get_list_items'];
$routes[] = ['GET|POST', '/product/get_list_wishlist', 'GoCart\Controller\Product#get_list_wishlist'];
$routes[] = ['GET|POST', '/product/get_update', 'GoCart\Controller\Product#get_update'];
$routes[] = ['GET|POST', '/product/get_all_data_products/[:pid]/[:cid]', 'GoCart\Controller\Product#get_all_data_products'];
$routes[] = ['GET|POST', '/product/[:slug]', 'GoCart\Controller\Product#index']; 