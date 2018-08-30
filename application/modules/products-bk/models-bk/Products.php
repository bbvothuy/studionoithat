<?php
/**
 * Products Class
 *
 * @package     GoCart
 * @subpackage  Models
 * @category    Products
 * @author      Clear Sky Designs
 * @link        http://gocartdv.com
 */

Class Products extends CI_Model
{
    public function __construct()
    {
        $this->customer = \CI::Login()->customer();
    }

    public function getProduct($id)
    {
        //do this again right here since it can be used for combining the cart. We want to make sure it's fresh.
        $this->customer = \GC::getCustomer();

        //find the product
        $product = CI::db()->select('*, saleprice_'.$this->customer->group_id.' as saleprice, price_'.$this->customer->group_id.' as price')->where('id', $id)->where('enabled_'.$this->customer->group_id, '1')->get('products')->row();
        $product = $this->processImageDecoding($product);
        return $product;
    }

    public function product_autocomplete($name, $limit, $bonus_or_combo = '')
    {
		if($bonus_or_combo == 'bonus'){
			return  CI::db()->like('name', $name)->get('products_bonus', $limit)->result();
		}else{
			return  CI::db()->like('name', $name)->get('products', $limit)->result();
		}
    }

    public function touchInventory($id, $quantity)
    {
        $product = $this->getProduct($id);
        if(!$product)
        {
            return false;
        }

        CI::db()->where('id', $id)->update('products', ['quantity' => ($product->quantity - $quantity)]);
    }

    public function products($data=[], $return_count=false)
    {
        if(empty($data))
        {
            //if nothing is provided return the whole shabang
            CI::db()->order_by('name', 'ASC');
            $result = CI::db()->get('products');

            return $result->result();
        }
        else
        {
            //grab the limit
            if(!empty($data['rows']))
            {
                CI::db()->limit($data['rows']);
            }

            //grab the page
            if(!empty($data['page']))
            {
                CI::db()->offset($data['page']);
            }

            //do we order by something other than category_id?
            if(!empty($data['order_by']))
            {
                //if we have an order_by then we must have a direction otherwise KABOOM
                CI::db()->order_by($data['order_by'], $data['sort_order']);
            }

            //do we have a search submitted?
            if(!empty($data['term']))
            {
                $search = json_decode($data['term']);
                //if we are searching dig through some basic fields
                if(!empty($search->term))
                {
                    CI::db()->like('name', $search->term);
                    CI::db()->or_like('description', $search->term);
                    CI::db()->or_like('excerpt', $search->term);
                    CI::db()->or_like('sku', $search->term);
                }

                if(!empty($search->category_id))
                {
                    //lets do some joins to get the proper category products
                    CI::db()->join('category_products', 'category_products.product_id=products.id', 'right');
                    CI::db()->where('category_products.category_id', $search->category_id);
                    //CI::db()->order_by('sequence', 'ASC');
                }
            }

            if($return_count)
            {
                return CI::db()->count_all_results('products');
            }
            else
            {
                return CI::db()->get('products')->result();
            }

        }
    }

	public function get_top_home(){
		CI::db()->where('top_home', 1);
		CI::db()->limit(5);
        CI::db()->order_by('id', 'DESC');
		return CI::db()->get('products')->result();
	}
	
    public function getProducts($category_id = false, $limit = false, $offset = false, $by=false, $sort=false)
    {
        //if we are provided a category_id, then get products according to category
        if ($category_id)
        {
            CI::db()->select('category_products.*, products.*, saleprice_'.$this->customer->group_id.' as saleprice, price_'.$this->customer->group_id.' as price, LEAST(IFNULL(NULLIF(saleprice_'.$this->customer->group_id.', 0), price_'.$this->customer->group_id.'), price_'.$this->customer->group_id.') as sort_price', false)->from('category_products')->join('products', 'category_products.product_id=products.id')->where(array('category_id'=>$category_id, 'enabled_'.$this->customer->group_id=>1));

            CI::db()->order_by($by, $sort);

            $result = CI::db()->limit($limit)->offset($offset)->get()->result();

            $products = [];

            foreach($result as $product)
            {
                $products[] = $this->processImageDecoding($product);
            }
            return $products;
        }
        else
        {
            //sort by alphabetically by default
            return CI::db()->order_by('name', 'ASC')->get('products')->result();
        }
    }

    public function count_all_products()
    {
        return CI::db()->count_all_results('products');
    }

    public function count_products($id)
    {
        return CI::db()->select('product_id')->from('category_products')->join('products', 'category_products.product_id=products.id')->where(array('category_id'=>$id, 'enabled_'.$this->customer->group_id=>1))->count_all_results();
    }

    public function slug($slug, $related=true)
    {
      $result = CI::db()->select('*, saleprice_'.$this->customer->group_id.' as saleprice, price_'.$this->customer->group_id.' as price')->get_where('products', array('slug'=>$slug, 'enabled_'.$this->customer->group_id=>1))->row();

      if(!$result)
        {
            return false;
        }

        $related = json_decode($result->related_products);

        if(!empty($related))
        {
            //build the where
            $where = [];
            foreach($related as $r)
            {
                $where[] = '`id` = '.$r;
            }
            CI::db()->select('*, saleprice_'.$this->customer->group_id.' as saleprice, price_'.$this->customer->group_id.' as price');
            CI::db()->where('('.implode(' OR ', $where).')', null);
            CI::db()->where('enabled_'.$this->customer->group_id, 1);

            $result->related_products   = CI::db()->get('products')->result();
			//echo CI::db()->last_query();
        }
        else
        {
            $result->related_products   = [];
        }
		
		$combo = json_decode($result->combo_product);

        if(!empty($combo))
        {
            //build the where
            $where = [];
            foreach($combo as $r)
            {
                $where[] = '`id` = '.$r;
            }
            CI::db()->select('*, saleprice_'.$this->customer->group_id.' as saleprice, price_'.$this->customer->group_id.' as price');
            CI::db()->where('('.implode(' OR ', $where).')', null);
            CI::db()->where('enabled_'.$this->customer->group_id, 1);

            $result->combo_product   = CI::db()->get('products')->result();
			//echo CI::db()->last_query();
        }
        else
        {
            $result->combo_product   = [];
        }
		
		$bonus = json_decode($result->bonus_product);

        if(!empty($bonus))
        {
            //build the where
            $where = [];
            foreach($bonus as $r)
            {
                $where[] = '`id` = '.$r;
            }
			CI::db()->select('products_bonus.id as bonus_id, products_bonus.name as bonus_name, products_bonus.bonus_type, products_bonus.quantity as bonus_quantity, products_bonus.value as bonus_value, products_bonus.note as bonus_note, products.*');
			CI::db()->join('products', 'products.id=', 'left');
            CI::db()->where('active', 1);

            $result->bonus_product   = CI::db()->get('products_bonus')->result();
			//echo CI::db()->last_query();
        }
        else
        {
            $result->bonus_product   = [];
        }
		
        $result->categories = $this->getProductCategories($result->id);

		/*if(config_item('store_name') != 'default'){
			$store = config_item('store');
			$result->price_1 = $result->price_1 + ($result->price_1 * $store->config_price)/100;
			$result->saleprice_1 = $result->saleprice_1 + ($result->saleprice_1 * $store->config_price)/100;
			$result->price = $result->price + ($result->price * $store->config_price)/100;
			$result->saleprice = $result->saleprice + ($result->saleprice * $store->config_price)/100;
		}*/
        return $result;
    }

    public function find($id, $related=true, $bonus=true, $combo=true)
    {
        $result = CI::db()->get_where('products', array('id'=>$id))->row();
        if(!$result)
        {
            return false;
        }

        if($related)
        {
            $relatedItems = json_decode($result->related_products);
            if(!empty($relatedItems))
            {
                //build the where
                $where = [];
                foreach($relatedItems as $r)
                {
                    $where[] = '`id` = '.$r;
                }

                CI::db()->where('('.implode(' OR ', $where).')', null);
                CI::db()->where('enabled_'.$this->customer->group_id, 1);

                $result->related_products   = CI::db()->get('products')->result();
            }
            else
            {
                $result->related_products   = [];
            }
        }
		if($combo)
        {
            $comboItems = json_decode($result->combo_product);
            if(!empty($comboItems))
            {
                //build the where
                $where = [];
                foreach($comboItems as $r)
                {
                    $where[] = '`id` = '.$r;
                }

                CI::db()->where('('.implode(' OR ', $where).')', null);
                CI::db()->where('enabled_'.$this->customer->group_id, 1);

                $result->combo_product   = CI::db()->get('products')->result();
            }
            else
            {
                $result->combo_product   = [];
            }
        }
		
		if($bonus)
        {
            $bonusItems = json_decode($result->bonus_product);
            if(!empty($bonusItems))
            {
                //build the where
                $where = [];
                foreach($bonusItems as $r)
                {
                    $where[] = '`id` = '.$r;
                }

                CI::db()->where('('.implode(' OR ', $where).')', null);                

                $result->bonus_product   = CI::db()->get('products_bonus')->result();
            }
            else
            {
                $result->bonus_product   = [];
            }
        }

        $result->categories = $this->getProductCategories($result->id);

        return $result;
    }

    public function getProductCategories($id)
    {
        return CI::db()->where('product_id', $id)->join('categories', 'category_id = categories.id')->get('category_products')->result();
    }

    public function save($product, $options=false, $categories=false)
    {
        if ($product['id'])
        {
            CI::db()->where('id', $product['id']);
            CI::db()->update('products', $product);

            $id = $product['id'];
        }
        else
        {
            CI::db()->insert('products', $product);
            $id = CI::db()->insert_id();
        }

        //loop through the product options and add them to the db
        if($options !== false)
        {

            // wipe the slate
            CI::ProductOptions()->clearOptions($id);

            // save edited values
            $count = 1;
            foreach ($options as $option)
            {
                $values = $option['values'];
                unset($option['values']);
                $option['product_id'] = $id;
                $option['sequence'] = $count;

                CI::ProductOptions()->saveOption($option, $values);
                $count++;
            }
        }

        if($categories !== false)
        {
            if($product['id'])
            {
                //get all the categories that the product is in
                $cats   = $this->getProductCategories($id);

                //generate cat_id array
                $ids    = [];
                foreach($cats as $c)
                {
                    $ids[]  = $c->id;
                }

                //eliminate categories that products are no longer in
                foreach($ids as $c)
                {
                    if(!in_array($c, $categories))
                    {
                        CI::db()->delete('category_products', array('product_id'=>$id,'category_id'=>$c));
                    }
                }

                //add products to new categories
                foreach($categories as $c)
                {
                    if(!in_array($c, $ids))
                    {
                        CI::db()->insert('category_products', array('product_id'=>$id,'category_id'=>$c));
                    }
                }
            }
            else
            {
                //new product add them all
                foreach($categories as $c)
                {
                    CI::db()->insert('category_products', array('product_id'=>$id,'category_id'=>$c));
                }
            }
        }

        //return the product id
        return $id;
    }

    public function delete_product($id)
    {
        // delete product
        CI::db()->where('id', $id);
        CI::db()->delete('products');

        //delete references in the product to category table
        CI::db()->where('product_id', $id);
        CI::db()->delete('category_products');

        // delete coupon reference
        CI::db()->where('product_id', $id);
        CI::db()->delete('coupons_products');
    }

    public function search_products($term, $limit=false, $offset=false, $by=false, $sort=false, $cat_id=false)
    {
        $results = [];		
		
		CI::db()->select('products.*, LEAST(IFNULL(NULLIF(products.saleprice_'.$this->customer->group_id.', 0), products.price_'.$this->customer->group_id.'), products.price_'.$this->customer->group_id.') as sort_price', false);
        //this one counts the total number for our pagination
        CI::db()->where('enabled_'.$this->customer->group_id, 1);

        $term = CI::db()->escape_like_str(preg_replace("/[^A-Za-z0-9 ]/", "", $term));

        //CI::db()->where('(products.name LIKE "%'.$term.'%" OR products.description LIKE "%'.$term.'%" OR products.excerpt LIKE "%'.$term.'%" OR products.sku LIKE "%'.$term.'%")');
		CI::db()->where('(products.name LIKE "%'.$term.'%" OR products.sku LIKE "%'.$term.'%")');
		
		if($cat_id){
			CI::db()->join('category_products', 'category_products.product_id=products.id');
			CI::db()->where('category_products.category_id', $cat_id);
		}
		
        $results['count'] = CI::db()->count_all_results('products');


        CI::db()->select('products.*, products.saleprice_'.$this->customer->group_id.' as saleprice, products.price_'.$this->customer->group_id.' as price, LEAST(IFNULL(NULLIF(products.saleprice_'.$this->customer->group_id.', 0), products.price_'.$this->customer->group_id.'), products.price_'.$this->customer->group_id.') as sort_price', false);
        //this one gets just the ones we need.
        CI::db()->where('products.enabled_'.$this->customer->group_id, 1);
        //CI::db()->where('(products.name LIKE "%'.$term.'%" OR products.description LIKE "%'.$term.'%" OR products.excerpt LIKE "%'.$term.'%" OR products.sku LIKE "%'.$term.'%")');
		CI::db()->where('(products.name LIKE "%'.$term.'%" OR products.sku LIKE "%'.$term.'%")');

		if($cat_id){
			CI::db()->join('category_products', 'category_products.product_id=products.id');
			CI::db()->where('category_products.category_id', $cat_id);
		}
		
        if($by && $sort)
        {
            CI::db()->order_by($by, $sort);
        }
        $products = CI::db()->get('products', $limit, $offset)->result();
        $results['products'] = [];
        foreach($products as $product)
        {
            $results['products'][] = $this->processImageDecoding($product);
        }

        return $results;
    }

    public function processImageDecoding($product)
    {
        if($product)
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
            return $product;
        }
        else
        {
            return $product;
        }
        
    }

    public function validate_slug($slug, $id=false, $counter=false)
    {
        CI::db()->select('slug');
        CI::db()->from('products');
        CI::db()->where('slug', $slug.$counter);
        if ($id)
        {
            CI::db()->where('id !=', $id);
        }
        $count = CI::db()->count_all_results();

        if ($count > 0)
        {
            if(!$counter)
            {
                $counter = 1;
            }
            else
            {
                $counter++;
            }
            return $this->validate_slug($slug, $id, $counter);
        }
        else
        {
             return $slug.$counter;
        }
    }
	
	function add_wishlist($customer_id, $product_id){
		$query = CI::db()->where('customer_id', $customer_id)->where('product_id', $product_id)->get('wishlists');
		if($query->num_rows() > 0 ){
			return false;
		}else{
			CI::db()->insert('wishlists', array('customer_id' => $customer_id, 'product_id' => $product_id, 'date' => date('Y-m-d : H:i:s')));
			return true;
		}
	}
	
	public function get_wishlist($customer_id){
		CI::db()->limit(5);
        CI::db()->order_by('wishlists.id', 'DESC');
		CI::db()->join('products', 'products.id=wishlists.product_id');
		$query = CI::db()->where('wishlists.customer_id', $customer_id)->get('wishlists');
		if($query->num_rows() > 0 ){
			return $query->result();
		}
		return false;
	}
	
	public function count_all_wishlist($customer_id){		
		$query = CI::db()->where('wishlists.customer_id', $customer_id)->get('wishlists');		
		return $query->num_rows();
	}

}
