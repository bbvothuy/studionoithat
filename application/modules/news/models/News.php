<?php
Class News extends CI_Model
{

    var $tiered;

    function __construct()
    {
        parent::__construct();
        $this->tiered = [];
        $this->get_news_tiered();
    }
    /********************************************************************
    News functions
     ********************************************************************/
    function get_news($parent = 0)
    {
        CI::db()->order_by('sequence', 'ASC');
        CI::db()->where('parent_id', $parent);
        $result = CI::db()->get('news')->result();

        $return = [];
        foreach($result as $news)
        {

            // Set a class to active, so we can highlight our current news
            if($this->uri->segment(1) == $news->slug) {
                $news->active = true;
            } else {
                $news->active = false;
            }

            $return[$news->id]              = $news;
            $return[$news->id]->children    = $this->get_news($news->id);
        }

        return $return;
    }

    function get_news_tiered()
    {
        if(!empty($this->tiered))
        {
            return $this->tiered;
        }
        CI::db()->order_by('sequence');
        CI::db()->order_by('title', 'ASC');
        $result = CI::db()->get('news')->result();
        return $result;
    }

    function find($id)
    {
      return CI::db()->where('id', $id)->or_where('slug', $id)->get('news')->row();
    }
    
    function slug($slug)
    {
      return  CI::db()->where('slug', $slug)->get('news')->row();
    }

    function get_slug($id)
    {
        $news = $this->get_news($id);
        if($news)
        {
            return $news->slug;
        }
    }

    function save($data)
    {
        if($data['id'])
        {
            CI::db()->where('id', $data['id']);
            CI::db()->update('news', $data);
            return $data['id'];
        }
        else
        {
            CI::db()->insert('news', $data);
            return CI::db()->insert_id();
        }
    }

    function delete_news($id)
    {
        //delete the news
        CI::db()->where('id', $id);
        CI::db()->delete('news');

    }    

    function validate_slug($slug, $id=false, $counter=false)
    {
        CI::db()->select('slug');
        CI::db()->from('news');
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
                $counter    = 1;
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

    function category_find($id){
        if($id) {
            return CI::db()->where('id', $id)->or_where('slug', $id)->get('news_categories')->row();
        }else{
            return CI::db()->get('news_categories')->result();
        }
    }

    function save_category($data)
    {
        if($data['id'])
        {
            CI::db()->where('id', $data['id']);
            CI::db()->update('news_categories', $data);
            return $data['id'];
        }
        else
        {
            CI::db()->insert('news_categories', $data);
            return CI::db()->insert_id();
        }
    }

    function delete_category($id)
    {
        //delete the news categories
        CI::db()->where('id', $id);
        CI::db()->delete('news_categories');

    }
}