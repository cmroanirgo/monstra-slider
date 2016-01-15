<?php

/**
 *  Slider plugin
 *
 *  @package Monstra
 *  @subpackage Plugins
 *  @author cmroanirgo
 *  @copyright 2016 cmroanirgo / kodespace.com
 *  @version 1.0.0
 *
 */

// Register plugin
Plugin::register( __FILE__,
                __('Slider', 'slider'),
                __('Slider manager', 'slider'),
                '1.0.0',
                'kodespace',
                'http://kodespace.com/');

if (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin'))) {

    // Include Admin
    Plugin::admin('slider');

}

// Add Plugin Javascript
Javascript::add('plugins/slider/js/slider.js', 'backend');

// Add shortcode {snippet}
Shortcode::add('slider', 'Slider::_get');
/**
 * Slider Class
 */
class Slider
{
    /**
     * Get slider
     *
     * @param string $category Category name
     */
    public static function get($category = '')
    {
        if ($category=='default') $category='';
        // Get slider table
        $slider = new Table('slider');

        // Display view
        View::factory('slider/views/frontend/index')                
                ->assign('items', $slider->select('[category="'.$category.'"]', 'all', null, null, 'order', 'ASC'))//->assign('items', $slider->select('[category="'.$category.'"]', 'all', null, array('id', 'title', 'summary', 'link', 'target', 'order', 'has_button', 'button_class', 'image', 'category'), 'order', 'ASC'))
                ->assign('uri', Uri::segments())
                ->assign('defpage', Option::get('defaultpage'))
                ->display();

    }

    public static function _get($attributes = '')
    {
        // Extract
        extract($attributes);

        if (!isset($name))
            $name = '';
        return Slider::get($name);
    }
 
}
