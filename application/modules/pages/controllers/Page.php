<?php namespace GoCart\Controller;
/**
 * Page Class
 *
 * @package     GoCart
 * @subpackage  Controllers
 * @category    Page
 * @author      Clear Sky Designs
 * @link        http://gocartdv.com
 */

class Page extends Front{

    public function homepage()
    {
		$data['product_top_home'] = \CI::Products()->get_top_home();
		$data['cat_top_home'] = \CI::Categories()->get_top_home($data['product_top_home']);		
		//echo '<pre>';print_r($data['cat_top_home']);exit;
        //do we have a homepage view?
        if(file_exists(FCPATH.'themes/'.config_item('theme').'/views/homepage.php'))
        {
            $this->view('homepage', $data);
            return;
        }
        else
        {
            //if we don't have a homepage view, check for a registered homepage
            if(config_item('homepage'))
            {
                if(isset($this->pages['all'][config_item('homepage')]))
                {
                    //we have a registered homepage and it's active
                    $this->index($this->pages['all'][config_item('homepage')]->slug, false);
                    return;
                }
            }
        }

        // wow, we do not have a registered homepage and we do not have a homepage.php
        // let's give them something default to look at.
        $this->view('homepage_fallback', $data);
    }

    public function show404()
    {
        $this->view('404');
    }

    public function index($slug=false, $show_title=true)
    {

        $page = false;

        //this means there's a slug, lets see what's going on.
        foreach($this->pages['all'] as $p)
        {
            if($p->slug == $slug)
            {
                $page = $p;
                continue;
            }
        }

        if(!$page)
        {
            throw_404();
        }
        else
        {
            //create view variable
            $data['page_title'] = false;
            if($show_title)
            {
                $data['page_title'] = $page->title;
            }
            $data['meta'] = $page->meta;
            $data['seo_title'] = (!empty($page->seo_title))?$page->seo_title:$page->title;
            $data['page'] = $page;

            //load the view
			if($page->id == 1){
				$this->view('page_list', $data);	
			}else{
				$this->view('page', $data);	
			}
            
        }
    }

    public function api($slug)
    {
        \CI::load()->language('page');

        $page = $this->Page_model->slug($slug);

        if(!$page)
        {
            $json = json_encode(['error'=>lang('error_page_not_found')]);
        }
        else
        {
            $json = json_encode($page);
        }

        $this->view('json', ['json'=>json_encode($json)]);
    }
}

/* End of file Page.php */
/* Location: ./GoCart/controllers/Page.php */