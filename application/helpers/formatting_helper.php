<?php
function format_address($fields)
{
    if(empty($fields))
    {
        return ;
    }

    // Default format
    //$default = "<strong>{% if company %} {{company}}, {% endif %}{{firstname}} {{lastname}}</strong><br><small>{{phone}} | {{email}}<br>{{address1}}<br>{% if address2 %}{{address2}}<br>{% endif %}{{city}}, {{zone}} {{zip}}<br>{{country}}</small>";
	$default = "<strong>{{firstname}} {{lastname}}</strong><br><small>{{phone}} | {{email}}<br>{{address1}}<br>{% if address2 %}{{address2}}<br>{% endif %}{{city}}, {{zone}} {{zip}}<br>{{country}}</small>";

    // Fetch country record to determine which format to use
    $CI = &get_instance();
    $CI->load->model('Locations');
    $c_data = $CI->Locations->get_country($fields['country_id']);

    if(empty($c_data->address_format))
    {
        $formatted  = $default;
    } else {
        $formatted  = $c_data->address_format;
    }

    $loader = new Twig_Loader_String();
    $twig = new Twig_Environment($loader);

    $formatted = $twig->render($formatted, $fields);

    return $formatted;
}
function format_address_2($fields)
{
    if(empty($fields))
    {
        return ;
    }

    // Default format
    $default = "<strong>{{firstname}} {{lastname}}</strong><br><small>{{phone}} | {{email}}<br>{{address1}}<br>{% if address2 %}{{address2}}<br>{% endif %}{{city}}</small>";

    // Fetch country record to determine which format to use
    $formatted  = $default;

    $loader = new Twig_Loader_String();
    $twig = new Twig_Environment($loader);

    $formatted = $twig->render($formatted, $fields);

    return $formatted;
}
function format_currency($value, $symbol=true)
{
    //$fmt = numfmt_create( config_item('locale'), NumberFormatter::CURRENCY );
	//return numfmt_format_currency($fmt, round($value,2), config_item('currency_iso'));	
	$fmt = numfmt_create( 'vi', 2 );
    return numfmt_format_currency($fmt, round($value,2), 'VND');
}

function get_price_sale($price, $price_sale, $sale_start_date = '', $sale_end_date = '')
{	
	$tmp = array();
	if($sale_start_date != '' && $sale_end_date != '') {
		if ($price_sale > 0 && $price_sale < $price && date('Y-m-d') >= $sale_start_date && date('Y-m-d') <= $sale_end_date) {
			$tmp['price'] = $price_sale;
			$tmp['price_old'] = $price;
			$tmp['sale'] = true;
		} else {
			$tmp['price'] = $price;
			$tmp['price_old'] = 0;
			$tmp['sale'] = false;
		}
	}else{
		if ($price_sale > 0 && $price_sale) {
			$tmp['price'] = $price_sale;
			$tmp['price_old'] = $price;
			$tmp['sale'] = true;
		} else {
			$tmp['price'] = $price;
			$tmp['price_old'] = 0;
			$tmp['sale'] = false;
		}
	}
	$store = config_item('store');
	if(config_item('store_name') != 'default'){
		$tmp['price'] = $tmp['price'] + ($tmp['price'] * $store->config_price)/100;
		$tmp['price_old'] = $tmp['price_old'] + ($tmp['price_old'] * $store->config_price)/100;
	}	
	return $tmp;
    
}

function get_image($images, $folder = 'small'){
	$images = json_decode($images, true);
	//print_r($images);exit;
	$photo  = theme_img('no_picture.png');
	if(!empty($images))
	{

		$index = 0;
		foreach($images as $photo)
		{
			if($index++ == 0){
				$tmp_prime = $photo;
			}
			if(isset($photo['primary']))
			{
				$primary    = $photo;
			}
		}
		if(!isset($primary)){
			$primary = $tmp_prime;
		}
		$photo  = base_url('uploads/images/'.$folder.'/'.$primary['filename']);
	}
	return $photo;
}

function get_image_primary($product, $path_folder = 'medium'){
	$photo  = $img_default = theme_img('no_picture.png');
	if(!empty($product->images[0]))
	{
		$primary    = $product->images[0];
		foreach($product->images as $photo)
		{
			if(isset($photo['primary']))
			{
				$primary    = $photo;
			}
		}
		if(file_exists('./uploads/images/'.$path_folder.'/' . $primary['filename'])) {
			$photo = base_url('uploads/images/'.$path_folder.'/' . $primary['filename']);
		}else{
			$photo = $img_default;
		}
	}
	return $photo;
}

function get_image_primary_2($images, $path_folder = 'medium'){
	$photo  = theme_img('no_picture.png');
	if(!empty($images[0]))
	{
		$primary    = $images[0];
		foreach($images as $photo)
		{
			if(isset($photo['primary']))
			{
				$primary    = $photo;
			}
		}

		$photo  = base_url('uploads/images/'.$path_folder.'/'.$primary['filename']);
	}
	return $photo;
}

function get_image_primary_3($images, $path_folder = 'medium'){
	$photo  = theme_img('no_picture.png');
	if(!empty($images))
	{
		$tmp_index = 0;
		foreach($images as $key=>$photo)
		{
			if($tmp_index == 0){
				$primary = $photo;
			}
			if(isset($photo['primary']))
			{
				$primary    = $photo;
			}
			$tmp_index++;
		}
		//print_r($images);
		$photo  = base_url('uploads/images/'.$path_folder.'/'.$primary['filename']);
	}
	return $photo;
}

function get_src_img($img, $folder = 'small'){
	$photo  = theme_img('no_picture.png');
	if($img !=''){
		$photo  = base_url('uploads/images/'.$folder.'/'.$img);
	}
	return $photo;
}

function url_product($slug, $cate_slug = ''){
	if($cate_slug != ''){		
		return site_url('/'.$cate_slug.PRODUCT.'/'.$slug.'.html');
	}else{
		return site_url(PRODUCT.'/'.$slug.'.html');
	}
}

function url_cate($slug){
	return site_url(CATEGORY.'/'.$slug);
}

function url_page_info($slug){
	return site_url('page/'.$slug);
}

function url_news($slug){
	return site_url('page/'.$slug);
}