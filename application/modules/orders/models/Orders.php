<?php
Class Orders extends CI_Model
{

    private function arrangeSalesFigures($values)
    {
        $return = [];
        foreach($values as $val)
        {			
            $return[$val->month] = $val->total;
        }
        return $return;
    }
    public function getGrossMonthlySales($year)
    {
        $reports = [];
        if(config_item('store_name') != 'default'){
            $store = config_item('store');
            $store_id = $store->id;
            if($store_id > 0){
                CI::db()->where('orders.store_id', $store_id);
            }
        }

        $products = CI::db()->select('MONTH(ordered_on) as month, sum('.\CI::db()->dbprefix('order_items').'.total_price * '.\CI::db()->dbprefix('order_items').'.quantity - '.\CI::db()->dbprefix('order_items').'.coupon_discount * '.\CI::db()->dbprefix('order_items').'.coupon_discount_quantity) as total')
        ->join('order_items', 'order_items.order_id = orders.id')
        ->where('status !=', 'cart')
        ->where('status !=', 'lỗi')
        ->where('order_items.type', 'product')
        ->where('YEAR(ordered_on)', $year)
        ->group_by(['MONTH(ordered_on)'])
        ->order_by("ordered_on", "desc")
        ->get('orders')->result();
		//echo CI::db()->last_query();exit;
		//print_r($products);
        $reports['products'] = $this->arrangeSalesFigures($products);
		//print_r($reports['products']);
        if(config_item('store_name') != 'default'){
            if($store_id > 0){
                CI::db()->where('orders.store_id', $store_id);
            }
        }
		$cost_products = CI::db()->select('MONTH(ordered_on) as month, sum('.\CI::db()->dbprefix('order_items').'.cost ) as total')
        ->join('order_items', 'order_items.order_id = orders.id')
        ->where('status !=', 'cart')
        ->where('status !=', 'lỗi')
        ->where('order_items.type', 'product')
        ->where('YEAR(ordered_on)', $year)
        ->group_by(['MONTH(ordered_on)'])
        ->order_by("ordered_on", "desc")
        ->get('orders')->result();
		//echo CI::db()->last_query();exit;
		//print_r($products);
        $reports['cost_products'] = $this->arrangeSalesFigures($cost_products);
		//print_r($reports['cost_products']);

        $decrease_orders = CI::db()->select('MONTH(ordered_on) as month, sum('.\CI::db()->dbprefix('orders').'.decrease ) as total')
            ->where('status !=', 'cart')
            ->where('status !=', 'lỗi')
            ->where('YEAR(ordered_on)', $year)
            ->group_by(['MONTH(ordered_on)'])
            ->order_by("ordered_on", "desc")
            ->get('orders')->result();
        //echo CI::db()->last_query();exit;

        $reports['decrease_orders'] = $this->arrangeSalesFigures($decrease_orders);
        //print_r($reports['decrease_orders']);
        foreach($reports['products'] as $key=>&$value){
            if(isset($reports['decrease_orders'][$key])){
                $decrease = $reports['decrease_orders'][$key];
            }else{
                $decrease = 0;
            }
            $value = $value - $decrease;
        }

		
        $couponDiscounts = CI::db()->select('MONTH(ordered_on) as month, sum('.\CI::db()->dbprefix('order_items').'.coupon_discount * '.\CI::db()->dbprefix('order_items').'.coupon_discount_quantity) as total')
        ->join('order_items', 'order_items.order_id = orders.id')
        ->where('status !=', 'cart')
        ->where('status !=', 'lỗi')
        ->where('order_items.type', 'product')
        ->where('YEAR(ordered_on)', $year)
        ->group_by(['MONTH(ordered_on)'])
        ->order_by("ordered_on", "desc")
        ->get('orders')->result();

        $reports['couponDiscounts'] = $this->arrangeSalesFigures($couponDiscounts);

        if(config_item('store_name') != 'default'){
            if($store_id > 0){
                CI::db()->where('orders.store_id', $store_id);
            }
        }
        $giftCardDiscounts = CI::db()->select('MONTH(ordered_on) as month, sum('.\CI::db()->dbprefix('order_items').'.total_price) as total')
        ->join('order_items', 'order_items.order_id = orders.id')
        ->where('status !=', 'cart')
        ->where('status !=', 'lỗi')
        ->where('order_items.type', 'gift card')
        ->where('YEAR(ordered_on)', $year)
        ->group_by(['MONTH(ordered_on)'])
        ->order_by("ordered_on", "desc")
        ->get('orders')->result();

        $reports['giftCardDiscounts'] = $this->arrangeSalesFigures($giftCardDiscounts);

        if(config_item('store_name') != 'default'){
            if($store_id > 0){
                CI::db()->where('orders.store_id', $store_id);
            }
        }
        $shipping = CI::db()->select('MONTH(ordered_on) as month, sum('.\CI::db()->dbprefix('order_items').'.total_price) as total')
        ->join('order_items', 'order_items.order_id = orders.id')
        ->where('status !=', 'cart')
        ->where('status !=', 'lỗi')
        ->where('order_items.type', 'shipping')
        ->where('YEAR(ordered_on)', $year)
        ->group_by(['MONTH(ordered_on)'])
        ->order_by("ordered_on", "desc")
        ->get('orders')->result();
        $reports['shipping'] = $this->arrangeSalesFigures($shipping);

        if(config_item('store_name') != 'default'){
            if($store_id > 0){
                CI::db()->where('orders.store_id', $store_id);
            }
        }
        $tax = CI::db()->select('MONTH(ordered_on) as month, sum('.\CI::db()->dbprefix('order_items').'.total_price) as total')
        ->join('order_items', 'order_items.order_id = orders.id')
        ->where('status !=', 'cart')
        ->where('status !=', 'lỗi')
        ->where('order_items.type', 'shipping')
        ->where('YEAR(ordered_on)', $year)
        ->group_by(['MONTH(ordered_on)'])
        ->order_by("ordered_on", "desc")
        ->get('orders')->result();
		//echo CI::db()->last_query();exit;
        $reports['tax'] = $this->arrangeSalesFigures($tax);

        return $reports;
    }

    public function getSalesYears()
    {
        if(config_item('store_name') != 'default'){
            $store = config_item('store');
            $store_id = $store->id;
            if($store_id > 0){
                CI::db()->where('orders.store_id', $store_id);
            }
        }

        CI::db()->where('status !=', 'cart');
        CI::db()->order_by("ordered_on", "desc");
        CI::db()->select('YEAR(ordered_on) as year');
        CI::db()->group_by('YEAR(ordered_on)');
        $records = CI::db()->get('orders')->result();
        $years = [];
        foreach($records as $r)
        {
            $years[] = $r->year;
        }
        return $years;
    }

    private function getAddressSelect()
    {
        $fields = \CI::db()->list_fields('customers_address_bank');
        $select = '';
        foreach($fields as $field)
        {
            $select .= ', shipping.'.$field.' as shipping_'.$field.', billing.'.$field.' as billing_'.$field.' ';
        }

        return $select;
    }

    private function getOrderSearchLike($str)
    {
        //support multiple words
        //$term = explode(' ', $str);
		$term = explode('-', $str);

        foreach($term as $t)
        {
            $not = '';
            $operator = 'OR';
            if(substr($t,0,1) == '-')
            {
                $not = 'NOT ';
                $operator = 'AND';
                //trim the - sign off
                $t = substr($t,1,strlen($t));
            }

            $like = '';
            $like .= "( `order_number` ".$not."LIKE '%".CI::db()->escape_like_str($t)."%' " ;
            $like .= $operator." `billing`.`firstname` ".$not."LIKE '%".CI::db()->escape_like_str($t)."%'  ";
            $like .= $operator." `billing`.`lastname` ".$not."LIKE '%".CI::db()->escape_like_str($t)."%'  ";
            $like .= $operator." `shipping`.`firstname` ".$not."LIKE '%".CI::db()->escape_like_str($t)."%'  ";
            $like .= $operator." `shipping`.`lastname` ".$not."LIKE '%".CI::db()->escape_like_str($t)."%'  ";
            $like .= $operator." `orders`.`status` ".$not."LIKE '%".CI::db()->escape_like_str($t)."%' ";
            $like .= $operator." `notes` ".$not."LIKE '%".CI::db()->escape_like_str($t)."%' )";
            $like .= $operator." `orders`.`invoice_number` ".$not."LIKE '%".CI::db()->escape_like_str($t)."%'  ";
			$like .= $operator." `shipping`.`email` ".$not."LIKE '%".CI::db()->escape_like_str($t)."%'  ";
			$like .= $operator." `shipping`.`phone` ".$not."LIKE '%".CI::db()->escape_like_str($t)."%'  ";

            CI::db()->where($like);
        }
    }

	/*
    public function getOrders($search=false, $sort_by='', $sort_order='DESC', $limit=0, $offset=0, $cancel = true)
    {
        $select = 'stores.store_name, orders.*, country_zones.name city_name, zone.name as district_name, ward.name as ward_name, shipping.address1'.$this->getAddressSelect();

        //\CI::db()->select($select)->join('customers_address_bank as shipping', 'shipping.id = orders.shipping_address_id', 'left')->join('customers_address_bank as billing', 'billing.id = orders.billing_address_id', 'left');

        \CI::db()->select($select)->join('customers_address_bank as shipping', 'shipping.id = orders.shipping_address_id', 'left');
        \CI::db()->join('stores', 'stores.id = orders.store_id', 'left');
        \CI::db()->join('customers_address_bank as billing', 'billing.id = orders.billing_address_id', 'left');

		\CI::db()->join('country_zones', 'country_zones.id=shipping.city', 'left');
		\CI::db()->join('zone', 'zone.zone_id=shipping.zone_id', 'left');
		\CI::db()->join('ward', 'ward.ward_id=shipping.ward_id', 'left');
		\CI::db()->where('orders.id >6684');
        if(config_item('store_name') != 'default'){
            $store = config_item('store');
            $store_id = $store->id;
            if($store_id > 0){
                \CI::db()->where('orders.store_id', $store_id);
            }
        }

        if ($search)
        {
            if(!empty($search->term))
            {
                $this->getOrderSearchLike($search->term);
            }
			if(!empty($search->search_delivery_date))
            {
                CI::db()->where('delivery_date',$search->search_delivery_date);
            }
            if(!empty($search->start_date))
            {
                CI::db()->where('ordered_on >=',$search->start_date);
            }
            if(!empty($search->end_date))
            {
                //increase by 1 day to make this include the final day
                //I tried <= but it did not public function. Any ideas why?
                $search->end_date = date('Y-m-d', strtotime($search->end_date)+86400);
                CI::db()->where('ordered_on <',$search->end_date);
            }
        }



        if($limit>0)
        {
            CI::db()->limit($limit, $offset);
        }
        if(!empty($sort_by))
        {
            CI::db()->order_by($sort_by, $sort_order);
        }

		if($cancel){
			CI::db()->where('orders.status !=', 'Lỗi');
		}
        CI::db()->where('orders.status !=', 'cart');

        return CI::db()->get('orders')->result();
    }

    public function getOrderCount($search=false, $cancel = true)
    {

        \CI::db()->join('customers_address_bank as shipping', 'shipping.id = orders.shipping_address_id', 'left');
        \CI::db()->join('customers_address_bank as billing', 'billing.id = orders.billing_address_id', 'left');
		\CI::db()->where('orders.id >6684');
        if ($search)
        {
            if(!empty($search->term))
            {
                $this->getOrderSearchLike($search->term);
            }
			if(!empty($search->search_delivery_date))
            {
                CI::db()->where('delivery_date',$search->search_delivery_date);
            }
            if(!empty($search->start_date))
            {
                CI::db()->where('ordered_on >=',$search->start_date);
            }
            if(!empty($search->end_date))
            {
                CI::db()->where('ordered_on <',$search->end_date);
            }
        }
		if($cancel){
			\CI::db()->where('orders.status !=', 'Lỗi');
		}
        return CI::db()->where('status !=', 'cart')->count_all_results('orders');
    }*/
	
	public function getOrders($search=false, $sort_by='', $sort_order='DESC', $limit=0, $offset=0, $cancel = true)
    {
        $select = 'stores.store_name, orders.*, country_zones.name city_name, zone.name as district_name, ward.name as ward_name, shipping.address1'.$this->getAddressSelect();

        //\CI::db()->select($select)->join('customers_address_bank as shipping', 'shipping.id = orders.shipping_address_id', 'left')->join('customers_address_bank as billing', 'billing.id = orders.billing_address_id', 'left');

        \CI::db()->select($select)->join('customers_address_bank as shipping', 'shipping.id = orders.shipping_address_id', 'left');
        \CI::db()->join('stores', 'stores.id = orders.store_id', 'left');
        \CI::db()->join('customers_address_bank as billing', 'billing.id = orders.billing_address_id', 'left');

		\CI::db()->join('country_zones', 'country_zones.id=shipping.city', 'left');
		\CI::db()->join('zone', 'zone.zone_id=shipping.zone_id', 'left');
		\CI::db()->join('ward', 'ward.ward_id=shipping.ward_id', 'left');
		\CI::db()->where('orders.id >6684');
        if(config_item('store_name') != 'default'){
            $store = config_item('store');
            $store_id = $store->id;
            if($store_id > 0){
                \CI::db()->where('orders.store_id', $store_id);
            }
        }

        if ($search)
        {
            if(!empty($search->term))
            {
                $this->getOrderSearchLike($search->term);
            }
			if(!empty($search->search_delivery_date))
            {
                CI::db()->where('delivery_date',$search->search_delivery_date);
            }
            if(!empty($search->start_date))
            {
                CI::db()->where('ordered_on >=',$search->start_date);
            }
			if(!empty($search->status))
            {
                CI::db()->where('orders.status',$search->status);
            }
            if(!empty($search->end_date))
            {
                //increase by 1 day to make this include the final day
                //I tried <= but it did not public function. Any ideas why?
                $search->end_date = date('Y-m-d', strtotime($search->end_date)+86400);
                CI::db()->where('ordered_on <',$search->end_date);
            }
        }



        if($limit>0)
        {
            CI::db()->limit($limit, $offset);
        }
        if(!empty($sort_by))
        {
            CI::db()->order_by($sort_by, $sort_order);
        }
		if(isset($search->status))
		{
			// do something
		}else{
			if($cancel){
				CI::db()->where('orders.status !=', 'Lỗi');
			}
		}
        CI::db()->where('orders.status !=', 'cart');

        return CI::db()->get('orders')->result();
    }

    public function getOrderCount($search=false, $cancel = true)
    {

        \CI::db()->join('customers_address_bank as shipping', 'shipping.id = orders.shipping_address_id', 'left');
        \CI::db()->join('customers_address_bank as billing', 'billing.id = orders.billing_address_id', 'left');
		\CI::db()->where('orders.id >6684');
        if ($search)
        {
            if(!empty($search->term))
            {
                $this->getOrderSearchLike($search->term);
            }
			if(!empty($search->search_delivery_date))
            {
                CI::db()->where('delivery_date',$search->search_delivery_date);
            }
            if(!empty($search->start_date))
            {
                CI::db()->where('ordered_on >=',$search->start_date);
            }
            if(!empty($search->end_date))
            {
                CI::db()->where('ordered_on <',$search->end_date);
            }
			if(!empty($search->status))
            {
                CI::db()->where('orders.status',$search->status);
            }
        }
		if(isset($search->status)){
			// do something
		}
		else{
			if($cancel){
				\CI::db()->where('orders.status !=', 'Lỗi');
			}
		}
        return CI::db()->where('orders.status !=', 'cart')->count_all_results('orders');
    }

    //get an individual customers orders
    public function getCustomerOrders($id, $offset=0)
    {
        CI::db()->order_by('ordered_on', 'DESC');
        CI::db()->where(['customer_id' => $id, 'status !=' => 'cart']);

        return CI::db()->get('orders')->result();
    }

    public function getCustomerCart($customerID)
    {
        CI::db()->where('status', 'cart');
        CI::db()->where('customer_id', $customerID);
        return CI::db()->get('orders')->row();
    }

    public function countCustomerOrders($id)
    {
        CI::db()->where(['customer_id' => $id, 'status !=' => 'cart']);
        return CI::db()->count_all_results('orders');
    }

    public function getOrder($orderNumber)
    {
        $fields = \CI::db()->list_fields('customers_address_bank');
        $select = 'orders.*, customers.*, orders.id as id, country_zones.name city_name, zone.name as district_name, ward.name as ward_name, shipping.address1 ';
        foreach($fields as $field)
        {
            $select .= ', shipping.'.$field.' as shipping_'.$field.', billing.'.$field.' as billing_'.$field.' ';
        }
				
        \CI::db()->select($select)->join('customers', 'customers.id = orders.customer_id', 'left')->join('customers_address_bank as shipping', 'shipping.id = orders.shipping_address_id', 'left')->join('customers_address_bank as billing', 'billing.id = orders.billing_address_id', 'left');
        \CI::db()->where('order_number', $orderNumber);

        CI::db()->join('country_zones', 'country_zones.id=shipping.city', 'left');
		CI::db()->join('zone', 'zone.zone_id=shipping.zone_id', 'left');
		CI::db()->join('ward', 'ward.ward_id=shipping.ward_id', 'left');
		
		$result = \CI::db()->get('orders');
        $order = $result->row();
		//echo '<pre>';print_r($order);exit;
        if(!$order)
        {
            return false;
        }
        $order->items = $this->getItems($order->id);
        $order->options = $this->getItemOptions($order->id);
        $order->files = $this->getItemFiles($order->id);
        $order->payments = $this->getPaymentInfo($order->id);

        return $order;
    }

    public function getItems($id)
    {
        CI::db()->where('order_id', $id)->order_by('type', 'ASC')->order_by('id', 'ASC');
        $items = CI::db()->get('order_items')->result();

        return $items;
    }

    public function getItemFiles($id)
    {
        $files = CI::db()->select('*, order_item_files.id as id')->where('order_id', $id)->join('digital_products', 'digital_products.id = order_item_files.file_id')->get('order_item_files')->result();

        $return = [];
        foreach($files as $file)
        {   
            if(!isset($return[$file->order_item_id]))
            {
                $return[$file->order_item_id] = [];
            }
            
            $return[$file->order_item_id][] = $file;
        }

        return $return;
    }

    public function getItemOptions($order_id)
    {
        $optionValues = CI::db()->where('order_id', $order_id)->get('order_item_options')->result();

        $return =[];

        foreach($optionValues as $optionValue)
        {
            if(!isset($return[$optionValue->order_item_id]))
            {
                $return[$optionValue->order_item_id] = [];
            }
            $return[$optionValue->order_item_id][] = $optionValue;
        }

        return $return;
    }

    public function removeItem($order_id, $id)
    {
        CI::db()->where('order_id', $order_id)->where('id', $id)->delete('order_items');
        CI::db()->where('order_item_id', $id)->delete('order_item_files');
        CI::db()->where('order_item_id', $id)->delete('order_item_options');
    }

    function saveOrderItemFile($file)
    {
        if(!empty($file['id']))
        {
            CI::db()->where('id', $file['id']);
            CI::db()->update('order_item_files', $file);
        }
        else
        {
            CI::db()->insert('order_item_files', $file);
        }
    }

    function getOrderItemFile($orderId)
    {
        return CI::db()->where('order_id', $orderId)->get('order_item_files')->result();
    }

    public function delete($id)
    {
        CI::db()->where('id', $id);
        CI::db()->delete('orders');

        //now delete the order items
        CI::db()->where('order_id', $id);
        CI::db()->delete('order_items');

        CI::db()->where('order_id', $id);
        CI::db()->delete('order_item_options');

        CI::db()->where('order_id', $id);
        CI::db()->delete('order_item_files');
    }

    public function saveItem($data)
    {
		if(isset($data['bonus_product']) && is_array($data['bonus_product'])){
			$data['bonus_product'] = json_encode($data['bonus_product']);
			/*$tmp = array();
			foreach($data['bonus_product'] as $bonus){
				$tmp[] = $bonus->bonus_id;
			}
			$data['bonus_product'] = json_encode($tmp);*/
		}else{
			//$data['bonus_product'] = '';
		}
		if(isset($data['bonus_product']) && is_array($data['combo_product'])){
			$data['combo_product'] = json_encode($data['combo_product']);
			/*$tmp = array();
			foreach($data['combo_product'] as $combo){
				$tmp[] = $combo->id;
			}
			$data['combo_product'] = json_encode($tmp);*/
		}else{
			//$data['combo_product'] = '';
		}
		
        if (isset($data['id']))
        {
            CI::db()->where('id', $data['id']);
            CI::db()->update('order_items', $data);
            return $data['id'];
        }
        else
        {
            CI::db()->insert('order_items', $data);
            return CI::db()->insert_id();
        }
    }

    public function saveItemOption($data)
    {
        if (isset($data['id']))
        {
            CI::db()->where('id', $data['id']);
            CI::db()->update('order_item_options', $data);
            return $data['id'];
        }
        else
        {
            CI::db()->insert('order_item_options', $data);
            return CI::db()->insert_id();
        }
    }

    public function moveOrderItems($oldId, $newId)
    {
        //move order items
        CI::db()->where('order_id', $oldId)->set('order_id',$newId)->update('order_items');

        //move order item options
        CI::db()->where('order_id', $oldId)->set('order_id',$newId)->update('order_item_options');
    }

    public function savePaymentInfo($info)
    {
        CI::db()->insert('payments', $info);
    }

    public function getPaymentInfo($order_id)
    {
        return CI::db()->where('order_id', $order_id)->where('status !=', 'failed')->get('payments')->result();
    }

    public function saveOrder($data, $contents = false)
    {
        if (isset($data['id']))
        {
            CI::db()->where('id', $data['id']);
            CI::db()->update('orders', $data);
            $id = $data['id'];
        }
        else
        {
            CI::db()->insert('orders', $data);
            $id = CI::db()->insert_id();
        }

        //if there are items being submitted with this order add them now
        if($contents)
        {
            // clear existing order items
            CI::db()->where('order_id', $id)->delete('order_items');
            // update order items
            foreach($contents as $item)
            {
                $save = [];
                $save['contents'] = $item;

                $item = unserialize($item);
                $save['product_id'] = $item['id'];
                $save['quantity'] = $item['quantity'];
                $save['order_id'] = $id;
                CI::db()->insert('order_items', $save);
            }
        }
        $get_shipping = CI::db()->where('order_id', $id)->where('type', 'shipping')->get('order_items')->row();
        if($get_shipping){
            CI::db()->where('id', $id)->update('orders', array('shipping' => $get_shipping->total_price));
        }
        return $id;
    }

    public function getBestSellers($start, $end)
    {
        if(config_item('store_name') != 'default'){
            $store = config_item('store');
            $store_id = $store->id;
            if($store_id > 0){
                CI::db()->where('orders.store_id', $store_id);
            }
        }
        if(!empty($start))
        {
            CI::db()->where('ordered_on >=', $start);
        }
        if(!empty($end))
        {
            CI::db()->where('ordered_on <',  $end);
        }		
        // just fetch a list of order id's
        $orders = CI::db()->select('sum(quantity) as quantity_sold, order_items.name as name, sku, slug')->group_by('product_id')->order_by('quantity_sold', 'DESC')->where('status != "cart" AND status != "Lỗi"')->where('order_items.type', 'product')->join('order_items', 'order_items.order_id = orders.id')->get('orders')->result();

        return $orders;
    }
	
	public function sale_report_detail($condition)
    {
        if(config_item('store_name') != 'default'){
            $store = config_item('store');
            $store_id = $store->id;
            if($store_id > 0){
                CI::db()->where('orders.store_id', $store_id);
            }
        }
		
		if(!empty($start))
        {
			$date = DateTime::createFromFormat('d/m/Y', $start);
			$date_start = $date->format('Y-m-d');
            CI::db()->where('ordered_on >=', $date_start);
        }
        if(!empty($end))
        {
			$date = DateTime::createFromFormat('d/m/Y', $end);
			$date_end = $date->format('Y-m-d');
            CI::db()->where('ordered_on <=', $date_end);
        }
		
		CI::db()->join('customers_address_bank', 'customers_address_bank.id = orders.shipping_address_id');
		
        if(!empty($condition['start']))
        {
            CI::db()->where('ordered_on >=', $condition['start']);
        }
        
		if(!empty($condition['end']))
        {
            CI::db()->where('ordered_on <',  $condition['end']);
        }
		
		if($condition['status'] != '')
        {
            CI::db()->where('orders.status', $condition['status']);
        }else{
			CI::db()->where('orders.status != "Lỗi"');
		}

		if($condition['type_search'] == 'email' && $condition['key_search'] != '')
        {
            CI::db()->where('customers_address_bank.email', $condition['key_search']);
        }
		
		if($condition['type_search'] == 'phone' && $condition['key_search'] != '')
        {
            CI::db()->where('customers_address_bank.phone', $condition['key_search']);
        }
		
		if($condition['type_search'] == 'name' && $condition['key_search'] != '')
        {
            CI::db()->like('customers_address_bank.firstname', $condition['key_search']);
        }
		if($condition['type_search'] == 'address' && $condition['key_search'] != '')
        {
            CI::db()->like('customers_address_bank.address1', $condition['key_search']);
        }
		if($condition['type_search'] == 'order-id' && $condition['key_search'] != '')
        {
            CI::db()->where('orders.invoice_number', $condition['key_search']);
        }
		
		if($condition['country_zone'] && $condition['country_zone'])
        {
            CI::db()->where('customers_address_bank.city', $condition['country_zone']);			
        }
		
		if(isset($condition['zone']) && $condition['zone'])
        {
            CI::db()->where('customers_address_bank.zone_id', $condition['zone']);
        }
		
		if($condition['group_by'] == 'day')
        {
            CI::db()->group_by('DATE_FORMAT(orders.ordered_on, "%d")');
			CI::db()->order_by('orders.ordered_on', 'DESC');
			CI::db()->select('DATE_FORMAT(orders.ordered_on, "%d/%m/%Y") as day');
        }
		
		if($condition['group_by'] == 'week')
        {
            CI::db()->group_by('DATE_FORMAT(orders.ordered_on, "%Y-%U")');
			CI::db()->order_by('orders.ordered_on', 'DESC');
			CI::db()->select('DATE_FORMAT(orders.ordered_on, "%U-%Y") as day');
        }
		
		if($condition['group_by'] == 'month')
        {
            CI::db()->group_by('DATE_FORMAT(orders.ordered_on, "%Y-%m")');
			CI::db()->order_by('orders.ordered_on', 'DESC');
			CI::db()->select('DATE_FORMAT(orders.ordered_on, "%m-%Y") as day');
        }
		
		if($condition['group_by'] == 'phone')
        {
            CI::db()->group_by('customers_address_bank.phone');
			CI::db()->select('customers_address_bank.phone');	
        }
		
		if($condition['group_by'] == 'email')
        {
            CI::db()->group_by('customers_address_bank.email');	
			CI::db()->select('customers_address_bank.email');
        }
		
		CI::db()->join('country_zones', 'country_zones.id = customers_address_bank.city');
		CI::db()->join('zone', 'zone.zone_id = customers_address_bank.zone_id');
		
		if($condition['group_by'] == 'country-zone')
        {			
            CI::db()->group_by('customers_address_bank.city');
			//CI::db()->order_by('orders.total', 'DESC');
			CI::db()->select('country_zones.name as city_name');		
        }
		
		if($condition['group_by'] == 'zone')
        {			
            CI::db()->group_by('customers_address_bank.city');
			CI::db()->group_by('customers_address_bank.zone_id');
			//CI::db()->order_by('orders.total', 'DESC');
			CI::db()->select('country_zones.name as city_name');
			CI::db()->select('zone.name as district_name');
        }	
		
		
        if($condition['group_by'] == ''){
			$orders = CI::db()->select('orders.*, customers_address_bank.*, country_zones.name as city_name, zone.name as district_name, orders.id as order_id')->group_by('orders.id')->order_by('orders.id', 'ASC')->where('orders.status !=','cart')->where('order_items.type', 'product')->join('order_items', 'order_items.order_id = orders.id')->get('orders')->result();
		}else{
			$orders = CI::db()->select('sum(orders.total) as total, sum(orders.decrease) as total_decrease, sum(orders.shipping) as total_shipping')->order_by('total', 'DESC')->where('orders.status !=','cart')->get('orders')->result();
		}

        return $orders;
    }

}
