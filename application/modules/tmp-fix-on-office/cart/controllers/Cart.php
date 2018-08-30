<?php namespace GoCart\Controller;
/**
 * Cart Class
 *
 * @package     GoCart
 * @subpackage  Controllers
 * @category    Cart
 * @author      Clear Sky Designs
 * @link        http://gocartdv.com
 */

class Cart extends Front {

    public function summary()
    {
		if(isset($_POST['notes_customer'])) {
			\GC::set_notes_customer(\CI::input()->post('notes_customer'));
		}
        $data['inventoryCheck'] = \GC::checkInventory();
        $this->partial('cart_summary', $data);
    }

    public function addToCart()
    {
        // Get our inputs
        $productId = intval( \CI::input()->post('id') );
        $quantity = intval( \CI::input()->post('quantity') );
        $options = \CI::input()->post('option');
        
        $message = \GC::insertItem(['product'=>$productId, 'quantity'=>$quantity, 'postedOptions'=>$options]);
        
        //save the cart
        \GC::saveCart();

        echo $message;
    }

    public function updateCart()
    {
        // see if we have an update for the cart
        $product_id = \CI::input()->post('product_id');
        $quantity = \CI::input()->post('quantity');
        
        $item = \GC::getCartItem($product_id);
        
        if(!$item)
        {
            return json_encode(['error'=>lang('error_product_not_found')]);
        }
        if(intval($quantity) === 0)
        {
            \GC::removeItem($product_id);
            echo json_encode(['success'=>true]);
        }
        else
        {
            //create a new list of relevant items
            $item->quantity = $quantity;
            $insert = \GC::insertItem(['product'=>$item, 'quantity'=>$quantity]);
            echo $insert;
        }

        //save the cart updates
        \GC::saveCart();
        return true;
    }

    public function submitCoupon()
    {
        $coupon = \GC::addCoupon(\CI::input()->post('coupon'));
        \GC::saveCart();
        echo $coupon;
    }

    public function submitGiftCard()
    {
        //get the giftcards from the database
        $giftCard = \CI::GiftCards()->getGiftCard(\CI::input()->post('gift_card'));

        if(!$giftCard)
        {
            echo json_encode(['error'=>lang('gift_card_not_exist')]);
        }
        else
        {
            //does the giftcard have any value left?
            if(\CI::GiftCards()->isValid($giftCard))
            {
                $message = \GC::addGiftCard($giftCard);
                if($message['success'])
                {
                    \GC::saveCart();
                    echo json_encode(['message'=>lang('gift_card_balance_applied')]);
                }
                else
                {
                    echo json_encode($message);
                }
            }
            else
            {
                echo json_encode(['error'=>lang('gift_card_zero_balance')]);
            }
        }
    }
	
	public function getProducts(){
		$cartItems = \GC::getCartItems();
		//echo'<pre>'; print_r($cartItems);exit;
		foreach ($cartItems as $item){
			if($item->type == 'gift card')
			{
				$charges['giftCards'][] = $item;
				continue;
			}
			elseif($item->type == 'coupon')
			{
				$charges['coupons'][] = $item;
				continue;
			}
			elseif($item->type == 'tax')
			{
				$charges['tax'][] = $item;
				continue;
			}
			elseif($item->type == 'shipping')
			{
				$charges['shipping'][] = $item;
				continue;
			}
			elseif($item->type == 'product')
			{
				$charges['products'][] = $item;
			}
		}
		return $charges['products'];
	}
	
	public function hasShipping() {
		$shipping = 1;
		
		foreach ($this->getProducts() as $product) {
	  		if ($product['size']) {
	    		$shipping = $product['size'];
				
				break;
	  		}		
		}
		
		return $shipping;
	}
	
	public function hasShippingLarge() {
		$shipping = 0;
		
		foreach ($this->getProducts() as $product) {
	  		if ($product->size==2) {
	    		$shipping = $shipping + 1;
				//break;
	  		}		
		}
		
		return $shipping;
	}
	
	public function hasShippingMedium() {
		$shipping = 0;
		
		foreach ($this->getProducts() as $product) {
	  		if ($product->size==1) {
	    		$shipping = $shipping + 1;
				
				//break;
	  		}		
		}
		return $shipping;
	}

	public function hasShippingSmall() {
		$shipping = 0;
		
		foreach ($this->getProducts() as $product) {
	  		if ($product->size==0) {
	    		$shipping = $shipping + 1;
				
				//break;
	  		}		
		}
		return $shipping;
	}
	
	public function addShiping() {
		$getSubTotal = \GC::getSubtotal();		
		$json = array();
		$total_s = 0;
		$country_zone_id 	= intval( \CI::input()->post('country_zone_id'));
		$zone_id 		= intval( \CI::input()->post('city_zone_id'));
		$ward_id		= intval( \CI::input()->post('ward_id'));
		
		//echo $getSubTotal;exit;
		//print_r(\CI::input()->post());
		$results = $this->getGeo($country_zone_id, $zone_id, $ward_id);
		$r_hn = $this->getGeo($country_zone_id, 0, 0);
		
		if (($country_zone_id == 0) || ($results == FALSE)) {
			 $json['error']			= '(Giá bán tại kho Tp.HCM, chưa bao gồm phí vận chuyển và VAT)';
		} else {
				 if ($getSubTotal<1200000) {
						if ($this->hasShippingLarge()>0) {
							$total_s =  $results['large'];
							$s_hn = $r_hn['large'];
						}  elseif ($this->hasShippingMedium()>0) {
							$total_s =  $results['medium'];
							$s_hn = $r_hn['medium'];
						} else {
							$total_s	=  $results['small'];
							$s_hn = $r_hn['small'];
						}
					
				 } elseif ($getSubTotal<4000000)  {
							if ($this->hasShippingLarge()>0) {
								$total_s =  $results['large'];
								$s_hn = $r_hn['large'];
							} elseif ($this->hasShippingMedium()>0) {
								$total_s =  $results['medium'];
								$s_hn = $r_hn['medium'];
							} elseif ($this->hasShippingSmall()>=2) {
								$total_s =  $results['medium'];
								$s_hn = $r_hn['medium'];
							} else {
								$total_s	=  $results['small'];
								$s_hn = $r_hn['small'];
							}
				 }
				 elseif ($getSubTotal<8000000) {
							if ($this->hasShippingLarge()>=2) {
								$total_s =  $results['big'];
								$s_hn = $r_hn['big'];
							} elseif ($this->hasShippingMedium()>=3) {
								$total_s	=  $results['big'];
								$s_hn = $r_hn['big'];
							} else {	
								$total_s =  $results['large'];
								$s_hn = $r_hn['large'];
							}
				  }
				  elseif ($getSubTotal<15000000) {
							if ($this->hasShippingLarge()>=3) {
								$total_s =  $results['bigger'];
								$s_hn = $r_hn['bigger'];
							} else {
								$total_s	=  $results['big'];
								$s_hn = $r_hn['big'];
							}
				  }
				  else {
								$total_s	=  $results['bigger'];
								$s_hn = $r_hn['bigger'];
				  }
			 if ($country_zone_id != 230 & $zone_id != 0 ) {
			 	$total_s = $total_s + $s_hn;
			 }
			    		
			 $json['success']=  'Tiền vận chuyển: '.$total_s;//. $this->currency->format($total_s);
			 $json['total_shipping'] = format_currency($total_s);
		}
		
		\GC::setShippingMethod(' ', $total_s, 'b91ac87777df8ad5330a91acf87ad4f0');
		//save the cart
		\GC::saveCart();
		//echo'<pre>'; print_r(\GC::getCartItems());//exit;			
		$json['total_price'] = format_currency(\GC::getGrandTotal());
		echo json_encode($json);
		exit;
		//$this->load->library('json');
		//$this->response->setOutput(Json::encode($json));
	}
	
	public function addShiping1($country_id=251, $zone_id=0,$ward_id=0) {
		$this->load->model('localisation/currency');	
		$this->load->language('checkout/cart');
		$this->load->model('localisation/ward');
		
		$total_s = 0;
			//$country_id 	= (int)$this->request->post['country_id'];
			//$zone_id 		= (int)$this->request->post['zone_id'];
			//$ward_id		= (int)$this->request->post['ward_id'];
		
		$results = $this->getGeo($country_id, $zone_id, $ward_id);
		$r_hn = $this->getGeo($country_id, 0, 0);
		
		if (($country_id == 0) || ($results == FALSE)) {
			 return $this->language->get('text_note');
		} else {
				 if ($this->cart->getSubTotal()<1200000) {
						if ($this->cart->hasShippingLarge()>0) {
							$total_s =  $results['large'];
							$s_hn = $r_hn['large'];
						}  elseif ($this->cart->hasShippingMedium()>0) {
							$total_s =  $results['medium'];
							$s_hn = $r_hn['medium'];
						} else {
							$total_s	=  $results['small'];
							$s_hn = $r_hn['small'];
						}
					
				 } elseif ($this->cart->getSubTotal()<4000000)  {
							if ($this->cart->hasShippingLarge()>0) {
								$total_s =  $results['large'];
								$s_hn = $r_hn['large'];
							} elseif ($this->cart->hasShippingMedium()>0) {
								$total_s =  $results['medium'];
								$s_hn = $r_hn['medium'];
							} elseif ($this->cart->hasShippingSmall()>=2) {
								$total_s =  $results['medium'];
								$s_hn = $r_hn['medium'];
							} else {
								$total_s	=  $results['small'];
								$s_hn = $r_hn['small'];
							}
				 }
				 elseif ($this->cart->getSubTotal()<8000000) {
							if ($this->cart->hasShippingLarge()>=2) {
								$total_s =  $results['big'];
								$s_hn = $r_hn['big'];
							} elseif ($this->cart->hasShippingMedium()>=3) {
								$total_s	=  $results['big'];
								$s_hn = $r_hn['big'];
							} else {	
								$total_s =  $results['large'];
								$s_hn = $r_hn['large'];
							}
				  }
				  elseif ($this->cart->getSubTotal()<15000000) {
							if ($this->cart->hasShippingLarge()>=3) {
								$total_s =  $results['bigger'];
								$s_hn = $r_hn['bigger'];
							} else {
								$total_s	=  $results['big'];
								$s_hn = $r_hn['big'];
							}
				  }
				  else {
								$total_s	=  $results['bigger'];
								$s_hn = $r_hn['bigger'];
				  }
			 if ($country_id == 251 & $zone_id != 0 ) {
			 	$total_s = $total_s + $s_hn;
			 }
			    		
			 return $total_s;
		}
	}	
	
	public function ward() {
		$output = '<option value="0">' . $this->language->get('text_select') . '</option>';
		
		$this->load->model('localisation/ward');

    	$results = $this->getWardsByZoneId($this->request->get['zone_id']);
        
      	foreach ($results as $result) {
        	$output .= '<option value="' . $result['ward_id'] . '"';
	
	    	if (isset($this->request->get['ward_id']) && ($this->request->get['ward_id'] == $result['ward_id'])) {
	      		$output .= ' selected="selected"';
	    	}
	
	    	$output .= '>' . $result['name'] . '</option>';
    	} 
		
		if (!$results) {
			if (!$this->request->get['ward_id']) {
		  		$output .= '<option value="0" selected="selected">' . $this->language->get('text_none') . '</option>';
			} else {
				$output .= '<option value="0">' . $this->language->get('text_none') . '</option>';
			}
		}
	
		$this->response->setOutput($output, $this->config->get('config_compression'));
  	}
	
	public function getWard($ward_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ward WHERE ward_id = '" . (int)$ward_id . "'");
		
		return $query->row;
	}		
	
	public function getWardsByZoneId($zone_id) {
		$ward_data = $this->cache->get('ward.' . $zone_id);
	
		if (!$ward_data) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "ward WHERE zone_id = '" . (int)$zone_id . "' ORDER BY name");
	
			$ward_data = $query->rows;
			
			$this->cache->set('ward.' . $zone_id, $ward_data);
		}
	
		return $ward_data;
	}
	
	public function getGeo($country_zone_id, $zone_id, $ward_id) {
		$query = \CI::db()->query("SELECT g.* FROM geo_zone g, zone_to_geo_zone zg WHERE g.geo_zone_id = zg.geo_zone_id and ward_id = '" . (int)$ward_id . "' and zone_id = '" . (int)$zone_id . "' and country_zone_id = '". (int)$country_zone_id . "' ORDER BY zg.date_added");		
		return $query->row_array();
	}
}

