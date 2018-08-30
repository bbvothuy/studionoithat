<?php namespace GoCart\Controller;
/**
 * Category Class
 *
 * @package     GoCart
 * @subpackage  Controllers
 * @category    Category
 * @author      Clear Sky Designs
 * @link        http://gocartdv.com
 */

class Category extends Front {

    public function index($slug, $page=0) {
		$sort='id';
		$dir="DESC";
        \CI::lang()->load('categories');
        \CI::load()->library('form_validation');
        //define the URL for pagination
        //$pagination_base_url = site_url('category/'.$slug.'/'.$sort.'/'.$dir);
		
		//how many products do we want to display per page?
        //this is configurable from the admin settings page.
        $per_page = config_item('products_per_page');		
		$pagination_base_url = site_url('/'.$slug);        

        //grab the categories
        $categories = \CI::Categories()->get($slug, $sort, $dir, $page, $per_page);	
		/*
		if(config_item('store_name') != 'default'){
			$store = config_item('store');
			foreach($categories['products'] as &$product){
				$product->price_1 = $product->price_1 + ($product->price_1 * $store->config_price)/100;
				$product->saleprice_1 = $product->saleprice_1 + ($product->saleprice_1 * $store->config_price)/100;
				$product->price = $product->price + ($product->price * $store->config_price)/100;
				$product->saleprice = $product->saleprice + ($product->saleprice * $store->config_price)/100;
				$product->sort_price = $product->sort_price + ($product->sort_price * $store->config_price)/100;
			}
		}
		*/
		//echo '<pre>'; print_r($categories);exit;        
		if(!$categories){			
			$old_url = \CI::db()->where('old_url', '/'.uri_string())->limit(1)->get('url_old_site')->row();
			if($old_url){				
				//redirect($old_url->new_url);
				if($old_url->type == 0){
					$slug = trim($old_url->new_url, '/');
					$pagination_base_url = site_url('/'.$slug);
					$categories = \CI::Categories()->get($slug, $sort, $dir, $page, $per_page);	
				}else{
					redirect($old_url->new_url);
				}
			}
		}
		//no category? show 404
        if(!$categories)
        {
            throw_404();
            return;
        }

        $categories['sort'] = $sort;
        $categories['dir'] = $dir;
        $categories['slug'] = $slug;
        $categories['page'] = $page;
        
        //load up the pagination library
        \CI::load()->library('pagination');
        $config['base_url'] = $pagination_base_url;
        //$config['uri_segment'] = 5;
		$config['uri_segment'] = 2; 
        $config['per_page'] = $per_page;
        $config['num_links'] = 5;
        $config['total_rows'] = $categories['total_products'];

		$config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['full_tag_open'] = '<nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
		
        \CI::pagination()->initialize($config);
		//echo '<pre>'; print_r($categories);exit;
        //load the view
		if($categories['category']->id == 16){
            $post = \CI::input()->post();
            if($post && $post['fullname'] != '' && $post['email'] != '' && $post['content'] != ''){
				//cấu hình thông tin do google cung cấp
				$api_url     = 'https://www.google.com/recaptcha/api/siteverify';
				$site_key    = '6LeDCFgUAAAAAC43Kc3Ow50k_0InVa7mh6q-xU-A';
				$secret_key  = '6LeDCFgUAAAAAGxQ5VrmY6fjjItoNqqCRnapxPPv';
				
				//lấy dữ liệu được post lên
				$site_key_post    = $_POST['g-recaptcha-response'];
				  
				//lấy IP của khach
				if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
					$remoteip = $_SERVER['HTTP_CLIENT_IP'];
				} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
					$remoteip = $_SERVER['HTTP_X_FORWARDED_FOR'];
				} else {
					$remoteip = $_SERVER['REMOTE_ADDR'];
				}
								
				$api_url = $api_url.'?secret='.$secret_key.'&response='.$site_key_post.'&remoteip='.$remoteip;				
				$response = file_get_contents($api_url);
				$response = json_decode($response);
				$recaptcha = false;
				if(!isset($response->success))
				{
					//echo 'Captcha khong dung';
					$recaptcha = false;
				}
				if($response->success == true)
				{
					//echo 'Captcha dung';
					$recaptcha = true;
				}else{
					//echo 'Captcha khong dung';
					$recaptcha = false;
				}
					
				if($recaptcha == true){
					\CI::db()->insert('contacts', array(
						'fullname' => $post['fullname'],
						'email' => $post['email'],
						'content' => $post['content'],
						'date' => date("Y-m-d H:i:s")
					));
					$categories['thanks_for_contact'] = true;
				}else{
					$categories['recaptcha'] = false;
					$categories['post'] = $post;
				}
                
            }

			$this->view('categories/contact', $categories);
		}else{
			$categories['cate_slug'] = $slug;
			$this->view('categories/category', $categories);
		}
    }

    public function shortcode($slug = false, $perPage = false)
    {
        if(!$perPage)
        {
            $perPage = config_item('products_per_page');
        }

        $products = \CI::Categories()->get($slug, 'id', 'ASC', 0, $perPage);

        return $this->partial('categories/products', $products);
    }

}
