<?php namespace GoCart\Controller;
/**
 * Addresses Class
 *
 * @package     GoCart
 * @subpackage  Controllers
 * @category    Addresses
 * @author      Clear Sky Designs
 * @link        http://gocartdv.com
 */

class Addresses extends Front {

    var $customer;

    public function __construct()
    {
        parent::__construct();

        \CI::load()->model(array('Locations'));
        $this->customer = \CI::Login()->customer();
    }

    public function index()
    {
        //make sure they're logged in
        \CI::Login()->isLoggedIn('my_account/');
        $data['customer'] = $this->customer;
        $data['addresses'] = \CI::Customers()->get_address_list($this->customer->id);

        $this->partial('addresses', $data);
    }

    public function form($id = 0)
    {
        $data['addressCount'] = \CI::Customers()->count_addresses($this->customer->id);
        $customer = \CI::Login()->customer();

        //grab the address if it's available
        $data['id'] = false;
        $data['company'] = $customer->company;
        $data['firstname'] = $customer->firstname;
        $data['lastname'] = $customer->lastname;
        $data['email'] = $customer->email;
        $data['phone'] = $customer->phone;
        $data['address1'] = '';
        $data['address2'] = '';
        $data['city'] = '';
        $data['country_id'] = '';
        $data['zone_id'] = '';
        $data['zip'] = '';

		$data['zones_menu_2'] = \CI::Locations()->get_zones_menu(230);
        if($id != 0)
        {
            $a  = \CI::Customers()->get_address($id);

            if($a['customer_id'] != $this->customer->id)
            {
                redirect('addresses/form'); // don't allow cross-customer editing
            }

            $data = array_merge($data, $a);
            //$data['zones_menu'] = \CI::Locations()->get_zones_menu($data['country_id']);
			$data['zones_menu_2'] = \CI::Locations()->get_zones_menu(230);
			if($data['city'] > 0){
                $data['city_zone'] 	= \CI::Locations()->get_city_zones_menu($data['city'], false);
            }else{
                $data['city_zone'] = false;
            }
            if($data['zone_id'] > 0){
                $data['ward'] 		= \CI::Locations()->get_ward_menu($data['zone_id'], false);
            }else{
                $data['ward'] = false;
            }
			//$data['city_zone'] 	= \CI::Locations()->get_city_zones_menu($data['city']);
			//$data['ward'] 		= \CI::Locations()->get_ward_menu($data['zone_id']);
			//print_r($data['zones_menu']);exit;
			//echo \CI::db()->last_query();exit;
			$data['edit_address'] = true;
        }

        //get the countries list for the dropdown
        $data['countries_menu'] = \CI::Locations()->get_countries_menu();

        if($id==0)
        {
            //if there is no set ID, the get the zones of the first country in the countries menu
            //$data['zones_menu'] = \CI::Locations()->get_zones_menu(array_shift( (array_keys($data['countries_menu'])) ));
			$data['zones_menu'] = \CI::Locations()->get_zones_menu(230);
        } else {
            $data['zones_menu'] = \CI::Locations()->get_zones_menu($data['country_id']);
        }

        \CI::load()->library('form_validation');
        \CI::form_validation()->set_rules('company', 'lang:address_company', 'trim|max_length[128]');
        \CI::form_validation()->set_rules('firstname', 'lang:address_firstname', 'trim|required|max_length[128]');
        \CI::form_validation()->set_rules('lastname', 'lang:address_lastname', 'trim|max_length[128]');
        \CI::form_validation()->set_rules('email', 'lang:address_email', 'trim|required|valid_email|max_length[128]');
        \CI::form_validation()->set_rules('phone', 'lang:address_phone', 'trim|required|max_length[32]');
        \CI::form_validation()->set_rules('address1', 'lang:address', 'trim|required|max_length[128]');
        \CI::form_validation()->set_rules('address2', 'lang:address2', 'trim|max_length[128]');
        \CI::form_validation()->set_rules('city', 'lang:address_city', 'trim|required|max_length[32]');
        \CI::form_validation()->set_rules('country_id', 'lang:address_country', 'trim|numeric');
        //\CI::form_validation()->set_rules('zone_id', 'lang:address_state', 'trim|required|numeric');
		//\CI::form_validation()->set_rules('ward_id', 'lang:address_state', 'trim|numeric');
        \CI::form_validation()->set_rules('zip', 'lang:address_zip', 'trim|max_length[32]');

        if (\CI::form_validation()->run() == FALSE)
        {
			//echo '<pre>'; print_r($data);exit;
            $this->partial('address_form', $data);
        }
        else
        {
            $a = [];
            $a['id'] = ($id==0) ? '' : $id;
            $a['customer_id'] = $this->customer->id;
            $a['company'] = \CI::input()->post('company');
            $a['firstname'] = \CI::input()->post('firstname');
            $a['lastname'] = \CI::input()->post('lastname');
            $a['email'] = \CI::input()->post('email');
            $a['phone'] = \CI::input()->post('phone');
            $a['address1'] = \CI::input()->post('address1');
            $a['address2'] = \CI::input()->post('address2');
            $a['city'] = \CI::input()->post('city');
			$a['zone_id'] = \CI::input()->post('zone_id');
			$a['ward_id'] = \CI::input()->post('ward_id');
            $a['zip'] = \CI::input()->post('zip');

            // get zone / country data using the zone id submitted as state
            $country = \CI::Locations()->get_country(assign_value('country_id'));
            $zone    = \CI::Locations()->get_zone(assign_value('zone_id'));
            /*if(!empty($country))
            {
                $a['zone'] = $zone->code;  // save the state for output formatted addresses
                $a['country'] = $country->name; // some shipping libraries require country name
                $a['country_code'] = $country->iso_code_2; // some shipping libraries require the code
                $a['country_id'] = \CI::input()->post('country_id');
                $a['zone_id'] = \CI::input()->post('zone_id');
            }*/

            \CI::Customers()->save_address($a);
            echo 1;
        }
    }

    public function delete($id)
    {
        \CI::Customers()->delete_address($id, $this->customer->id);
        echo 1;
    }

    /*public function getZoneOptions($id, $type = 'country')
    {
		if($id > 0){
			if($type == 'country'){
				$zones  = \CI::Locations()->get_zones_menu($id);
			}elseif($type == 'zone'){
				$zones  = \CI::Locations()->get_city_zones_menu($id);
			}else{
				$zones  = \CI::Locations()->get_ward_menu($id);
			}

			foreach($zones as $id=>$z):?>

				<option value="<?php echo $id;?>"><?php echo $z;?></option>

			<?php endforeach;
		}
		exit;
    }*/
	public function getZoneOptions($id, $type = 'country')
    {
		if($id > 0){
			if($type == 'country'){
				$zones  = \CI::Locations()->get_zones_menu($id);
			}elseif($type == 'zone'){
				$zones  = \CI::Locations()->get_city_zones_menu($id);
                if($zones){
                    echo '<option value="0">-- Quận/Huyện --</option>';
                }
			}else{
				$zones  = \CI::Locations()->get_ward_menu($id);
                if($zones){
                    echo '<option value="0">-- Phường/Xã --</option>';
                }
			}

			foreach($zones as $id=>$z) {
                echo '<option value="' . $id . '">' . $z .'</option>';
            }
		}
		exit;
    }
}
