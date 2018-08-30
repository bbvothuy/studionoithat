<?php namespace GoCart;

use \GoCart\Libraries\View as View;

class Controller {

    public $views;

    public function __construct()
    {
        \CI::load()->helper('form');
        \CI::load()->library('breadcrumbs');
        
        $this->views = View::getInstance();
    }

    function get_price_store($product){
        if(config_item('store_name') != 'default'){
            $store = config_item('store');
            $product->price_1 = $product->price_1 + ($product->price_1 * $store->config_price)/100;
            $product->saleprice_1 = $product->saleprice_1 + ($product->saleprice_1 * $store->config_price)/100;
            $product->price = $product->price + ($product->price * $store->config_price)/100;
            $product->saleprice = $product->saleprice + ($product->saleprice * $store->config_price)/100;
        }
        return $product;
    }

}