<?php namespace GoCart\Controller;
/**
 * AdminProducts Class
 *
 * @package     GoCart
 * @subpackage  Controllers
 * @category    AdminProducts
 * @author      Clear Sky Designs
 * @link        http://gocartdv.com
 */

class AdminProducts extends Admin {

    public function __construct()
    {
        parent::__construct();

        \CI::auth()->check_access('Admin', true);

        \CI::load()->model(['Products', 'Categories']);
        \CI::load()->helper('form');
        \CI::lang()->load('products');
    }

    public function index($rows=100, $order_by="id", $sort_order="DESC", $code=0, $page=0)
    {
        $data['groups'] = \CI::Customers()->get_groups();
        $data['page_title'] = lang('products');

        $data['code'] = $code;
        $term = false;

        //get the category list for the drop menu
        $data['categories'] = \CI::Categories()->getCategoryOptionsMenu();

        $post = \CI::input()->post(null, false);
        \CI::load()->model('Search');
        if($post)
        {
            $term = json_encode($post);
            $code = \CI::Search()->recordTerm($term);
            $data['code'] = $code;
        }
        elseif ($code)
        {
            $term = \CI::Search()->getTerm($code);
        }

        //store the search term
        $data['term'] = $term;
        $data['order_by'] = $order_by;
        $data['sort_order'] = $sort_order;
        $data['rows'] = $rows;
        $data['page'] = $page;

        $data['products'] = \CI::Products()->products(array('term'=>$term, 'order_by'=>$order_by, 'sort_order'=>$sort_order, 'rows'=>$rows, 'page'=>$page));
        //echo '<pre>'; print_r($data['products']);exit;
        //total number of products
        $data['total'] = \CI::Products()->products(array('term'=>$term, 'order_by'=>$order_by, 'sort_order'=>$sort_order), true);


        \CI::load()->library('pagination');

        $config['base_url'] = site_url('admin/products/'.$rows.'/'.$order_by.'/'.$sort_order.'/'.$code.'/');
        $config['total_rows'] = $data['total'];
        $config['per_page'] = $rows;
        $config['uri_segment'] = 7;
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

        $this->view('products', $data);
    }

    //basic category search
    public function product_autocomplete()
    {
        $name = trim(\CI::input()->post('name'));
        $limit = \CI::input()->post('limit');
		$type = \CI::input()->post('type');
		$bonus_or_combo = \CI::input()->post('bonus_or_combo');
        if(empty($name))
        {
            echo json_encode([]);
        }
        else
        {
			$results = \CI::Products()->product_autocomplete($name, $limit, $bonus_or_combo);
			$return = [];
			if($type == 2){
				foreach($results as $r)
				{
					$tmp = array();
					$tmp['id'] = $r->id;
					$tmp['value'] = $r->name;
                    //$tmp['cost'] = $r->cost;
					$return[] = (object)$tmp;
				}
			}else{
				foreach($results as $r)
				{
					if($bonus_or_combo == 'combo'){
                        $return[$r->id] = $r->name.','.$r->cost;
                    }
                    else{
                        $return[$r->id] = $r->name;
                    }
				}
			}
            echo json_encode($return);
        }

    }

    public function bulk_save()
    {
        $products = \CI::input()->post('product');

        if(!$products)
        {
            \CI::session()->set_flashdata('error', lang('error_bulk_no_products'));
            redirect('admin/products');
        }

        foreach($products as $id=>$product)
        {
            //print_r($product);exit;
            $product['id'] = $id;
            if(($product['saleprice_2'] == 0 && $product['saleprice_1'] > 0) || ($product['saleprice_2'] > $product['saleprice_1'] && $product['saleprice_1'] > 0)){
                $product['saleprice_2'] = $product['saleprice_1'];
            }
            if($product['sale_start_date'] == ''){
                unset($product['sale_start_date']);
            }

            if($product['sale_end_date'] == ''){
                unset($product['sale_end_date']);
            }

            $product['enabled_2'] = $product['enabled_1'];
            \CI::Products()->save($product);
            \CI::Products()->set_best_price($id);
        }

        \CI::session()->set_flashdata('message', lang('message_bulk_update'));
        redirect('admin/products');
    }

    public function form($id = false, $duplicate = false)
    {
        $this->product_id = $id;
        \CI::load()->library('form_validation');
        \CI::load()->model(array('ProductOptions', 'Categories', 'DigitalProducts', 'Customers'));
        \CI::lang()->load('digital_products');
        \CI::form_validation()->set_error_delimiters('<div class="error">', '</div>');

        $data['groups'] = \CI::Customers()->get_groups();
        $data['categories'] = \CI::Categories()->get_categories_tiered();
        $data['file_list'] = \CI::DigitalProducts()->getList();
        $data['manufacturers'] = \CI::db()->get('manufacturer')->result();

        $data['page_title'] = lang('product_form');

        //default values are empty if the product is new
        $data['id'] = '';
        $data['sku'] = '#';
        $data['primary_category'] = '';
        $data['name'] = '';
        $data['slug'] = '';
        $data['description'] = '';
        $data['excerpt'] = '';
        $data['weight'] = '';
        $data['track_stock'] = '';
        $data['seo_title'] = '';
        $data['meta'] = '';
        $data['shippable'] = '';
        $data['taxable'] = '';
        $data['fixed_quantity'] = '';
        $data['quantity'] = '';
        $data['enabled'] = '';
        $data['related_products'] = [];
        $data['product_categories'] = [];
        $data['images'] = [];
        $data['product_files'] = [];
        $data['productOptions'] = [];
		$data['top_home'] = '';
		$data['label_new'] = '';
		$data['size'] = '';
		$data['cost'] = '';
		$data['bonus_product'] = '';
		$data['combo_product'] = '';
		$data['product_type'] = 0;
        $data['manufacturer_id'] = 0;
        $data['keyword'] = '';
        $data['sale_start_date'] = null;
        $data['sale_end_date'] = null;
		
        foreach($data['groups'] as $group)
        {
            $data['enabled_'.$group->id] = 1;
            $data['price_'.$group->id] = '';
            $data['saleprice_'.$group->id] = '';
        }
        

        //create the photos array for later use
        $data['photos'] = [];

        if ($id)
        {
            // get the existing file associations and create a format we can read from the form to set the checkboxes
            $pr_files = \CI::DigitalProducts()->getAssociationsByProduct($id);
            foreach($pr_files as $f)
            {
                $data['product_files'][]  = $f->file_id;
            }

            // get product & options data
            $data['productOptions'] = \CI::ProductOptions()->getProductOptions($id);
            $product = \CI::Products()->find($id, true);
			//echo '<pre>'; print_r($product);exit;
            //if the product does not exist, redirect them to the product list with an error
            if (!$product)
            {
                \CI::session()->set_flashdata('error', lang('error_not_found'));
                redirect('admin/products');
            }

            //helps us with the slug generation
            $this->product_name = \CI::input()->post('slug', $product->slug);

            //set values to db values
            $data['id'] = $id;
            $data['sku'] = $product->sku;
            $data['primary_category'] = $product->primary_category;
            $data['name'] = $product->name;
            $data['seo_title'] = $product->seo_title;
            $data['meta'] = $product->meta;
            $data['slug'] = $product->slug;
            $data['description'] = $product->description;
            $data['excerpt'] = $product->excerpt;
            
            $data['weight'] = $product->weight;
            $data['track_stock'] = $product->track_stock;
            $data['shippable'] = $product->shippable;
            $data['quantity'] = $product->quantity;
            $data['taxable'] = $product->taxable;
            $data['fixed_quantity'] = $product->fixed_quantity;
			$data['top_home'] = $product->top_home;
			$data['label_new'] = $product->label_new;
			$data['size'] = $product->size;
			$data['cost'] = $product->cost;
			$data['bonus_product'] = $product->bonus_product;
			$data['combo_product'] = $product->combo_product;
			$data['product_type'] = $product->product_type;
            $data['manufacturer_id'] = $product->manufacturer_id;
            $data['keyword'] = $product->keyword;
            $data['sale_start_date'] = $product->sale_start_date;
            $data['sale_end_date'] = $product->sale_end_date;

            foreach($data['groups'] as $group)
            {
                $data['enabled_'.$group->id] = $product->{'enabled_'.$group->id};
                $data['price_'.$group->id] = $product->{'price_'.$group->id};
                $data['saleprice_'.$group->id] = $product->{'saleprice_'.$group->id};
            }

            //make sure we haven't submitted the form yet before we pull in the images/related products from the database
            if(!\CI::input()->post('submit'))
            {

                $data['product_categories'] = [];
                foreach($product->categories as $product_category)
                {
                    $data['product_categories'][] = $product_category->id;
                }

                $data['related_products'] = $product->related_products;
				$data['bonus_product'] = $product->bonus_product;
				$data['combo_product'] = $product->combo_product;
                $data['images'] = (array)json_decode($product->images);
            }
        }

        //if $data['related_products'] is not an array, make it one.
        if(!is_array($data['related_products']))
        {
            $data['related_products']   = [];
        }
		if(!is_array($data['bonus_product']))
        {
            $data['bonus_product']   = [];
        }
		if(!is_array($data['combo_product']))
        {
            $data['combo_product']   = [];
        }
        if(!is_array($data['product_categories']))
        {
            $data['product_categories'] = [];
        }


        //no error checking on these
        \CI::form_validation()->set_rules('caption', 'Caption');
        \CI::form_validation()->set_rules('primary_photo', 'Primary');

        \CI::form_validation()->set_rules('sku', 'lang:sku', 'trim');
        \CI::form_validation()->set_rules('seo_title', 'lang:seo_title', 'trim');
        \CI::form_validation()->set_rules('meta', 'lang:meta_data', 'trim');
        \CI::form_validation()->set_rules('name', 'lang:name', 'trim|required|max_length[64]');
        \CI::form_validation()->set_rules('slug', 'lang:slug', 'trim');
        \CI::form_validation()->set_rules('description', 'lang:description', 'trim');
        \CI::form_validation()->set_rules('excerpt', 'lang:excerpt', 'trim');
        \CI::form_validation()->set_rules('weight', 'lang:weight', 'trim|numeric|floatval');
        \CI::form_validation()->set_rules('track_stock', 'lang:track_stock', 'trim|numeric');
        \CI::form_validation()->set_rules('quantity', 'lang:quantity', 'trim|numeric');
        \CI::form_validation()->set_rules('shippable', 'lang:shippable', 'trim|numeric');
        \CI::form_validation()->set_rules('taxable', 'lang:taxable', 'trim|numeric');
        \CI::form_validation()->set_rules('fixed_quantity', 'lang:fixed_quantity', 'trim|numeric');

        foreach($data['groups'] as $group)
        {
            \CI::form_validation()->set_rules('enabled_'.$group->id, lang('enabled').'('.$group->name.')', 'trim|numeric');
            \CI::form_validation()->set_rules('price_'.$group->id, lang('price').'('.$group->name.')', 'trim|numeric|floatval');
            \CI::form_validation()->set_rules('saleprice_'.$group->id, lang('saleprice').'('.$group->name.')', 'trim|numeric|floatval');
        }

        /*
        if we've posted already, get the photo stuff and organize it
        if validation comes back negative, we feed this info back into the system
        if it comes back good, then we send it with the save item

        submit button has a value, so we can see when it's posted
        */

        if($duplicate)
        {
            $data['id'] = false;
        }
        if(\CI::input()->post('submit'))
        {
            //reset the product options that were submitted in the post
            $data['ProductOptions'] = \CI::input()->post('option');
            $data['related_products'] = \CI::input()->post('related_products');
            $data['product_categories'] = \CI::input()->post('categories');
            $data['images'] = \CI::input()->post('images');
            $data['product_files'] = \CI::input()->post('downloads');

        }
        //print_r($data['combo_product']) ;exit;
        if (\CI::form_validation()->run() == FALSE)
        {
            $this->view('product_form', $data);
        }
        else
        {
            \CI::load()->helper('text');

            //first check the slug field
            $slug = \CI::input()->post('slug');

            //if it's empty assign the name field
            if(empty($slug) || $slug=='')
            {
                $slug = \CI::input()->post('name');
            }

            $slug = url_title(convert_accented_characters($slug), '-', TRUE);

            //validate the slug
            $slug = ($id) ? \CI::Products()->validate_slug($slug, $product->id) : \CI::Products()->validate_slug($slug);


            $save['id'] 			= $id;
            $save['sku'] 			= \CI::input()->post('sku');
            $save['name'] 			= \CI::input()->post('name');
            $save['seo_title'] 		= \CI::input()->post('seo_title');
            $save['meta'] 			= \CI::input()->post('meta');
            $save['description'] 	= \CI::input()->post('description');
            $save['excerpt'] 		= \CI::input()->post('excerpt');
            $save['weight'] 		= \CI::input()->post('weight');
            $save['track_stock'] 	= \CI::input()->post('track_stock');
            $save['fixed_quantity'] = \CI::input()->post('fixed_quantity');
            $save['quantity'] 		= \CI::input()->post('quantity');
            $save['shippable'] 		= \CI::input()->post('shippable');
            $save['taxable'] 		= \CI::input()->post('taxable');
			$save['top_home'] 		= \CI::input()->post('top_home');
			$save['label_new'] 		= \CI::input()->post('label_new');
			$save['size']			= \CI::input()->post('size');
			$save['cost']			= \CI::input()->post('cost');
			$save['product_type']	= \CI::input()->post('product_type');
            $save['manufacturer_id']= \CI::input()->post('manufacturer_id');
            $save['keyword']        = \CI::input()->post('keyword');
            $save['sale_start_date']= (\CI::input()->post('sale_start_date') != '') ? \CI::input()->post('sale_start_date') : null;
            $save['sale_end_date']  = (\CI::input()->post('sale_end_date') != '') ? \CI::input()->post('sale_end_date') : null;
            
            $post_images = \CI::input()->post('images');

            foreach($data['groups'] as $group)
            {
                $save['enabled_'.$group->id] 	= \CI::input()->post('enabled_'.$group->id);
                $save['price_'.$group->id] 		= \CI::input()->post('price_'.$group->id);
                $save['saleprice_'.$group->id] 	= \CI::input()->post('saleprice_'.$group->id);
            }

            $save['slug'] = $slug;


            if($primary = \CI::input()->post('primary_image'))
            {
                if($post_images)
                {
                    foreach($post_images as $key => &$pi)
                    {
                        if($primary == $key)
                        {
                            $pi['primary']  = true;
                            continue;
                        }
                    }
                }

            }

            $save['images'] = json_encode($post_images);


            if(\CI::input()->post('related_products'))
            {
                $save['related_products'] = json_encode(\CI::input()->post('related_products'));
            }
            else
            {
                $save['related_products'] = '';
            }

			if(\CI::input()->post('bonus_products'))
            {
                $save['bonus_product'] = json_encode(\CI::input()->post('bonus_products'));
            }
            else
            {
                $save['bonus_product'] = '';
            }
			
			if(\CI::input()->post('combo_products'))
            {
                $save['combo_product'] = json_encode(\CI::input()->post('combo_products'));
            }
            else
            {
                $save['combo_product'] = '';
            }
			
            //save categories
            $categories = \CI::input()->post('categories');


            if(!$categories || !in_array(1, $categories))
            {
                $categories[] = 1;
            }

             //(\CI::input()->post('primary_category')) ? \CI::input()->post('primary_category') : 0;
            if(!\CI::input()->post('primary_category') && $categories)
            {
                $save['primary_category'] = $categories[0];
            }
            elseif(!\CI::input()->post('primary_category') && !$categories)
            {
                $save['primary_category'] = 0;
            }
            else
            {
                $save['primary_category'] = \CI::input()->post('primary_category');
            }


            // format options
            $options = [];
            if(\CI::input()->post('option'))
            {
                foreach (\CI::input()->post('option') as $option)
                {
                    $options[]  = $option;
                }

            }

            // save product
            $product_id = \CI::Products()->save($save, $options, $categories);
            \CI::Products()->set_best_price($product_id);

            // add file associations
            // clear existsing
            \CI::DigitalProducts()->disassociate(false, $product_id);
            // save new
            $downloads = \CI::input()->post('downloads');
            if(is_array($downloads))
            {
                foreach($downloads as $d)
                {
                    \CI::DigitalProducts()->associate($d, $product_id);
                }
            }

            \CI::session()->set_flashdata('message', lang('message_saved_product'));

            //go back to the product list
            redirect('admin/products');
        }
    }

    public function giftCardForm($id = false, $duplicate = false)
    {
        $this->product_id = $id;
        \CI::load()->library('form_validation');
        \CI::load()->model(array('ProductOptions', 'Categories'));
        \CI::form_validation()->set_error_delimiters('<div class="error">', '</div>');

        $data['categories'] = \CI::Categories()->get_categories_tiered();
        $data['page_title'] = lang('giftcard_product_form');
        $data['groups'] = \CI::Customers()->get_groups();

        //default values are empty if the product is new
        $data['id'] = '';
        $data['sku'] = '';
        $data['primary_category'] = '';
        $data['name'] = '';
        $data['slug'] = '';
        $data['description'] = '';
        $data['excerpt'] = '';
        $data['track_stock'] = '';
        $data['seo_title'] = '';
        $data['meta'] = '';
        $data['is_giftcard'] = 1;
        $data['taxable'] = '';
        $data['images'] = [];
        $data['product_categories'] = [];
        $data['product_files'] = [];

        foreach($data['groups'] as $group)
        {
            $data['enabled_'.$group->id] = '';
        }

        //create the photos array for later use
        $data['photos'] = [];

        if ($id)
        {

            // get product & options data
            $data['ProductOptions'] = \CI::ProductOptions()->getProductOptions($id);
            $product = \CI::Products()->find($id, true);

            //if the product does not exist, redirect them to the product list with an error
            if (!$product)
            {
                \CI::session()->set_flashdata('error', lang('error_not_found'));
                redirect('admin/products');
            }

            //helps us with the slug generation
            $this->product_name = \CI::input()->post('slug', $product->slug);

            //set values to db values
            $data['id']                 = $id;
            $data['sku']                = $product->sku;
            $data['primary_category']   = $product->primary_category;
            $data['name']               = $product->name;
            $data['seo_title']          = $product->seo_title;
            $data['meta']               = $product->meta;
            $data['slug']               = $product->slug;
            $data['description']        = $product->description;
            $data['excerpt']            = $product->excerpt;
            $data['quantity']           = $product->quantity;
            $data['taxable']            = $product->taxable;
            $data['fixed_quantity']     = $product->fixed_quantity;
            $data['is_giftcard']        = $product->is_giftcard;
            foreach($data['groups'] as $group)
            {
                $data['enabled_'.$group->id] = $product->{'enabled_'.$group->id};
            }

            //make sure we haven't submitted the form yet before we pull in the images/related products from the database
            if(!\CI::input()->post('submit'))
            {

                $data['product_categories'] = [];
                foreach($product->categories as $product_category)
                {
                    $data['product_categories'][] = $product_category->id;
                }

                $data['related_products']   = $product->related_products;
                $data['images']             = (array)json_decode($product->images);
            }
        }

        if(!is_array($data['product_categories']))
        {
            $data['product_categories'] = [];
        }


        //no error checking on these
        \CI::form_validation()->set_rules('caption', 'Caption');
        \CI::form_validation()->set_rules('primary_photo', 'Primary');

        \CI::form_validation()->set_rules('sku', 'lang:sku', 'trim');
        \CI::form_validation()->set_rules('seo_title', 'lang:seo_title', 'trim');
        \CI::form_validation()->set_rules('meta', 'lang:meta_data', 'trim');
        \CI::form_validation()->set_rules('name', 'lang:name', 'trim|required|max_length[64]');
        \CI::form_validation()->set_rules('slug', 'lang:slug', 'trim');
        \CI::form_validation()->set_rules('description', 'lang:description', 'trim');
        \CI::form_validation()->set_rules('excerpt', 'lang:excerpt', 'trim');
        \CI::form_validation()->set_rules('taxable', 'lang:taxable', 'trim|numeric');
        \CI::form_validation()->set_rules('fixed_quantity', 'lang:fixed_quantity', 'trim|numeric');
        
        \CI::form_validation()->set_rules('option[giftcard_values]', 'lang:giftcard_values', 'required');
        foreach($data['groups'] as $group)
        {
            \CI::form_validation()->set_rules('enabled_'.$group->id, lang('enabled').'('.$group->name.')', 'trim|numeric');
        }
        /*
        if we've posted already, get the photo stuff and organize it
        if validation comes back negative, we feed this info back into the system
        if it comes back good, then we send it with the save item

        submit button has a value, so we can see when it's posted
        */

        if($duplicate)
        {
            $data['id'] = false;
        }
        if(\CI::input()->post('submit'))
        {
            //reset the product options that were submitted in the post
            $data['ProductOptions'] = \CI::input()->post('option');
            $data['product_categories'] = \CI::input()->post('categories');
            $data['images'] = \CI::input()->post('images');

        }

        if (\CI::form_validation()->run() == FALSE)
        {
            $this->view('giftcard_product_form', $data);
        }
        else
        {
            \CI::load()->helper('text');

            //first check the slug field
            $slug = \CI::input()->post('slug');

            //if it's empty assign the name field
            if(empty($slug) || $slug=='')
            {
                $slug = \CI::input()->post('name');
            }

            $slug   = url_title(convert_accented_characters($slug), '-', TRUE);

            //validate the slug
            $slug = ($id) ? \CI::Products()->validate_slug($slug, $product->id) : \CI::Products()->validate_slug($slug);


            $save['id'] = $id;
            $save['sku'] = \CI::input()->post('sku');
            $save['name'] = \CI::input()->post('name');
            $save['seo_title'] = \CI::input()->post('seo_title');
            $save['meta'] = \CI::input()->post('meta');
            $save['description'] = \CI::input()->post('description');
            $save['excerpt'] = \CI::input()->post('excerpt');
            
            foreach($data['groups'] as $group)
            {
                $save['enabled_'.$group->id] = \CI::input()->post('enabled_'.$group->id);
                $save['price_'.$group->id] = '0.00';
                $save['saleprice_'.$group->id] = '0.00';
            }

            $save['is_giftcard'] = 1;
            $save['taxable'] = \CI::input()->post('taxable');
            $save['taxable'] = \CI::input()->post('taxable');
            $post_images = \CI::input()->post('images');

            $save['slug'] = $slug;


            if($primary = \CI::input()->post('primary_image'))
            {
                if($post_images)
                {
                    foreach($post_images as $key => &$pi)
                    {
                        if($primary == $key)
                        {
                            $pi['primary'] = true;
                            continue;
                        }
                    }
                }

            }

            $save['images'] = json_encode($post_images);


            if(\CI::input()->post('related_products'))
            {
                $save['related_products'] = json_encode(\CI::input()->post('related_products'));
            }
            else
            {
                $save['related_products'] = '';
            }

            //save categories
            $categories = \CI::input()->post('categories');
            if(!$categories)
            {
                $categories = [];
            }

             //(\CI::input()->post('primary_category')) ? \CI::input()->post('primary_category') : 0;
            if(!\CI::input()->post('primary_category') && $categories)
            {
                $save['primary_category'] = $categories[0];
            }
            elseif(!\CI::input()->post('primary_category') && !$categories)
            {
                $save['primary_category'] = 0;
            }
            else
            {
                $save['primary_category'] = \CI::input()->post('primary_category');
            }


            // format options
            $options = [];
            array_push($options, [
                                    'type' => 'textfield',
                                    'name' => 'from',
                                    'required' => 1,
                                    'values' =>
                                    [
                                        '0' =>
                                        [
                                            'name' => 'from',
                                            'value' => '',
                                            'price' => 0,
                                            'limit' => 0
                                        ]
                                    ]
                                ]);

            array_push($options, [
                                    'type' => 'textfield',
                                    'name' => 'to_email',
                                    'required' => 1,
                                    'values' =>
                                    [
                                        '0' =>
                                        [
                                            'name' => 'to_email',
                                            'value' => '',
                                            'price' => 0,
                                            'limit' => 0
                                        ]
                                    ]
                                ]);

            array_push($options, [
                                    'type' => 'textarea',
                                    'name' => 'personal_message',
                                    'required' => 1,
                                    'values' =>
                                    [
                                        '0' =>
                                        [
                                            'name' => 'personal_message',
                                            'value' => '',
                                            'price' => 0
                                        ]
                                    ]
                                ]);

            $giftcard_values = [];
            $postedValues = \CI::input()->post('option[giftcard_values]');
            if($postedValues)
            {
                foreach($postedValues as $giftcard_value)
                {
                    array_push($giftcard_values, ['name'=> 'beginning_amount', 'value' => $giftcard_value, 'weight'=>'', 'price' => $giftcard_value]);
                }
            }
            

            array_push($options, [
                                    'type' => 'droplist',
                                    'name' => 'beginning_amount',
                                    'required' => 1,
                                    'values' => $giftcard_values
                                ]);


            // save product
            $product_id = \CI::Products()->save($save, $options, $categories);


            \CI::session()->set_flashdata('message', lang('message_saved_giftcard_product'));

            //go back to the product list
            redirect('admin/products');
        }

    }


    public function product_image_form()
    {
        $data['file_name'] = false;
        $data['error']  = false;
        $this->partial('iframe/product_image_uploader', $data);
    }

    public function product_image_upload()
    {
        $data['file_name'] = false;
        $data['error']  = false;

        $config['allowed_types'] = 'gif|jpg|png';
        //$config['max_size']   = config_item('size_limit');
        $config['upload_path'] = 'uploads/images/full';
        $config['encrypt_name'] = true;
        $config['remove_spaces'] = true;

        \CI::load()->library('upload', $config);

        if ( \CI::upload()->do_upload())
        {
            $upload_data    = \CI::upload()->data();

            \CI::load()->library('image_lib');

            $config['image_library'] = 'gd2';
            $config['source_image'] = 'uploads/images/full/'.$upload_data['file_name'];
            $config['new_image'] = 'uploads/images/medium/'.$upload_data['file_name'];
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 600;
            $config['height'] = 502;
            \CI::image_lib()->initialize($config);
            \CI::image_lib()->resize();
            \CI::image_lib()->clear();

            //small image
            $config['image_library'] = 'gd2';
            $config['source_image'] = 'uploads/images/medium/'.$upload_data['file_name'];
            $config['new_image'] = 'uploads/images/small/'.$upload_data['file_name'];
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 300;
            $config['height'] = 251;
            \CI::image_lib()->initialize($config);
            \CI::image_lib()->resize();
            \CI::image_lib()->clear();

            $config['source_image'] = 'uploads/images/small/'.$upload_data['file_name'];
            $config['new_image'] = 'uploads/images/small/'.$upload_data['file_name'];

            list($width, $height, $type, $attr) = getimagesize($config['source_image']);
            //echo $width.':'.$height.':'.$type.':'.$attr;exit;
            $new_width = 300;
            $new_height = 251;
            // Resample
            $image_p = imagecreatetruecolor($new_width, $new_height);
            $white = imagecolorallocate($image_p, 255, 255, 255);
            imagefill($image_p, 0, 0, $white);

            if($type == IMAGETYPE_JPEG) {
                $image = imagecreatefromjpeg($config['source_image']);
                imagecopyresampled($image_p, $image, ($new_width - $width) / 2, ($new_height - $height) / 2, 0, 0, $width, $height, $width, $height);
               // Output
                imagejpeg($image_p, $config['new_image'], 100);
            }
            if($type == IMAGETYPE_PNG) {
                $image = imagecreatefrompng($config['source_image']);
                imagecolortransparent($image, imagecolorallocatealpha($image, 0, 0, 0, 127));
                imagealphablending($image, false);
                imagesavealpha($image, true);
                imagecopyresampled($image_p, $image, ($new_width - $width) / 2, ($new_height - $height) / 2, 0, 0, $width, $height, $width, $height);
                // Output
                imagepng($image_p, $config['new_image']);
            }


            //cropped thumbnail
            $config['image_library'] = 'gd2';
            $config['source_image'] = 'uploads/images/small/'.$upload_data['file_name'];
            $config['new_image'] = 'uploads/images/thumbnails/'.$upload_data['file_name'];
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 74;
            $config['height'] = 85;
            \CI::image_lib()->initialize($config);
            \CI::image_lib()->resize();
            \CI::image_lib()->clear();

            $data['file_name'] = $upload_data['file_name'];
        }

        if(\CI::upload()->display_errors() != '')
        {
            $data['error'] = \CI::upload()->display_errors();
        }
        $this->partial('iframe/product_image_uploader', $data);
    }

    public function delete($id = false)
    {
        if ($id)
        {
            $product = \CI::Products()->find($id);
            //if the product does not exist, redirect them to the customer list with an error
            if (!$product)
            {
                \CI::session()->set_flashdata('error', lang('error_not_found'));
                redirect('admin/products');
            }
            else
            {

                //if the product is legit, delete them
                \CI::Products()->delete_product($id);

                \CI::session()->set_flashdata('message', lang('message_deleted_product'));
                redirect('admin/products');
            }
        }
        else
        {
            //if they do not provide an id send them to the product list page with an error
            \CI::session()->set_flashdata('error', lang('error_not_found'));
            redirect('admin/products');
        }
    }
	
	function product_bonus(){
		$data = array();		
		//echo '<pre>';print_r($_POST);exit;
		//echo '<pre>';print_r($data);exit;
		if(isset($_POST['submit']) && $_POST['submit'] == 'Add New'){
			if($_POST['name'] != ''){
				unset($_POST['submit']);
				unset($_POST['product_name']);
				\CI::db()->insert('products_bonus', $_POST);
			}
		}
		if(isset($_POST['submit']) && $_POST['submit'] == 'Update'){
			if($_POST['name'] != '' && $_POST['product_id'] != '' && $_POST['value'] != '' ){
				unset($_POST['submit']);
				unset($_POST['product_name']);
				\CI::db()->where('id', $_POST['id'])->update('products_bonus', $_POST);	
			}
		}
		if(isset($_POST['submit']) && $_POST['submit'] == 'Delete'){
			\CI::db()->where('id', $_POST['id'])->delete('products_bonus');	
		}
		\CI::db()->select('products_bonus.*, products.name as product_name')->join('products', 'products.id=products_bonus.product_id', 'left');
		$data['products'] = \CI::db()->order_by('id', 'DESC')->get('products_bonus')->result();
		$this->view('product_bonus', $data);
	}
}
