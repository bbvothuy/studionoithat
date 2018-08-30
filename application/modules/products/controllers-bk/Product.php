<?php namespace GoCart\Controller;
/**
 * Product Class
 *
 * @package     GoCart
 * @subpackage  Controllers
 * @category    Product
 * @author      Clear Sky Designs
 * @link        http://gocartdv.com
 */

class Product extends Front {

    public function index($slug) {
        $product = \CI::Products()->slug($slug);		

        if(!$product)
        {
            throw_404();
        }
        else
        {
            $product->images = json_decode($product->images, true);
            if($product->images)
            {
                $product->images = array_values($product->images);
            }
            else
            {
                $product->images = [];
            }

            //set product options
            $data['options'] = \CI::ProductOptions()->getProductOptions($product->id);

            $data['posted_options'] = \CI::session()->flashdata('option_values');

            //get related items
            $data['related'] = $product->related_products;

            //create view variable
            $data['page_title'] = $product->name;
            $data['meta'] = $product->meta;
            $data['seo_title'] = (!empty($product->seo_title))?$product->seo_title:$product->name;
            $data['product'] = $product;
			//echo '<pre>'; print_r($product);exit;
            //load the view
            $this->view('product', $data);
        }
    }
	
	function get_product($id){		
		$product = \CI::Products()->getProduct($id);
		//echo '<pre>';print_r($product);exit;
		echo \CI::load()->view('product_modal', $product, true);
		exit;
	}
	
	function add_cart_product($id){		
		$product = \CI::Products()->getProduct($id);
		//echo '<pre>';print_r($product);exit;
		echo \CI::load()->view('add_cart_product', $product, true);
		exit;
	}
	
	function get_list_items(){
		echo \CI::load()->view('get_list_items', null, true);
		exit;
	}

	public function add_wishlist(){
		$product_id = \CI::input()->post('product_id');
		$result = false;
		if(\CI::Login()->isLoggedIn(false, false)){
			$customer = \CI::session()->userdata('customer');
			if($customer->id > 0){
				$result = \CI::Products()->add_wishlist($customer->id, $product_id);
			}
		}
		echo $result;
		exit;
	}
	
	public function get_list_wishlist(){
		if(\CI::Login()->isLoggedIn(false, false)){
			$customer = \CI::session()->userdata('customer');
			if($customer->id > 0){
				$result = \CI::Products()->get_wishlist($customer->id);
			}			
		}
		//echo '<pre>';print_r($result);exit;
		$count_all_wishlist = \CI::Products()->count_all_wishlist($customer->id);
		
		echo \CI::load()->view('get_list_wishlist', array('result' => $result, 'count_all_wishlist' => $count_all_wishlist), true);
		
	}
}

