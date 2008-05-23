<?php
//$Id$
function calendar_views_default_views() {
 
$view = new view;
$view->name = 'calendar';
$view->description = 'A multi-dimensional calendar view with back/next navigation.';
$view->tag = '';
$view->view_php = '';
$view->base_table = 'node';
$view->is_cacheable = '0';
$view->api_version = 2;
$view->disabled = FALSE; // Edit this to true to make a default view disabled initially
$view->display = array();
  $display = new views_display;
  $display->id = 'default';
  $display->display_title = 'Defaults';
  $display->display_plugin = 'default';
  $display->position = '1';
  $display->display_options = array(
  'style_plugin' => 'calendar_view',
  'style_options' => array(
    'default_display' => 'month',
    'calendar_day_header' => '1',
  ),
  'row_plugin' => 'node',
  'row_options' => array(
    'teaser' => 1,
    'links' => 1,
  ),
  'relationships' => array(),
  'fields' => array(
    'title' => array(
      'id' => 'title',
      'table' => 'node',
      'field' => 'title',
      'label' => 'Title',
      'relationship' => 'none',
      'link_to_node' => 1,
    ),
  ),
  'sorts' => array(),
  'arguments' => array(
    'calendar_date' => array(
      'id' => 'calendar_date',
      'table' => 'node',
      'field' => 'calendar_date',
      'default_action' => 'default',
      'style_plugin' => 'default_summary',
      'style_options' => array(
        'count' => TRUE,
        'override' => FALSE,
        'items_per_page' => 25,
      ),
      'wildcard' => 'all',
      'wildcard_substitution' => 'All',
      'title' => '',
      'default_argument_type' => 'calendar',
      'default_argument' => '',
      'validate_type' => 'none',
      'validate_fail' => 'not found',
      'date_fields' => array(
        'node.changed' => 'node.changed',
      ),
      'date_method' => 'OR',
      'relationship' => 'none',
      'default_argument_user' => 0,
      'default_argument_calendar' => 'Y-m',
      'default_argument_fixed' => '',
      'default_argument_php' => '',
      'validate_argument_node_type' => array(
        'page' => 0,
        'story' => 0,
        'test' => 0,
      ),
      'validate_argument_node_access' => 0,
      'validate_argument_nid_type' => 'nid',
      'validate_argument_vocabulary' => array(),
      'validate_argument_type' => 'tid',
      'validate_argument_php' => '',
    ),
  ),
  'filters' => array(),
  'items_per_page' => 0,
  'offset' => 0,
  'use_pager' => '0',
  'pager_element' => 0,
);
$view->display['default'] = $display;
  $display = new views_display;
  $display->id = 'calendar';
  $display->display_title = 'Calendar';
  $display->display_plugin = 'calendar';
  $display->position = '2';
  $display->display_options = array(
  'defaults' => array(
    'access' => TRUE,
    'title' => TRUE,
    'header' => TRUE,
    'header_format' => TRUE,
    'header_empty' => TRUE,
    'footer' => TRUE,
    'footer_format' => TRUE,
    'footer_empty' => TRUE,
    'empty' => TRUE,
    'empty_format' => TRUE,
    'use_ajax' => TRUE,
    'items_per_page' => TRUE,
    'offset' => TRUE,
    'use_pager' => TRUE,
    'pager_element' => TRUE,
    'use_more' => TRUE,
    'distinct' => TRUE,
    'link_display' => TRUE,
    'style_plugin' => FALSE,
    'style_options' => TRUE,
    'row_plugin' => FALSE,
    'row_options' => FALSE,
    'relationships' => TRUE,
    'fields' => TRUE,
    'sorts' => TRUE,
    'arguments' => TRUE,
    'filters' => TRUE,
  ),
  'relationships' => array(),
  'fields' => array(),
  'sorts' => array(),
  'arguments' => array(),
  'filters' => array(),
  'displays' => array(),
  'style_plugin' => 'calendar',
  'items_per_page' => 0,
  'row_plugin' => '',
  'path' => 'calendar',
  'default_display' => 'month',
);
$view->display['calendar'] = $display;
  $display = new views_display;
  $display->id = 'calendar_view';
  $display->display_title = 'Year';
  $display->display_plugin = 'calendar_view';
  $display->position = '3';
  $display->display_options = array(
  'defaults' => array(
    'access' => TRUE,
    'title' => TRUE,
    'header' => TRUE,
    'header_format' => TRUE,
    'header_empty' => TRUE,
    'footer' => TRUE,
    'footer_format' => TRUE,
    'footer_empty' => TRUE,
    'empty' => TRUE,
    'empty_format' => TRUE,
    'use_ajax' => TRUE,
    'items_per_page' => TRUE,
    'offset' => TRUE,
    'use_pager' => TRUE,
    'pager_element' => TRUE,
    'use_more' => TRUE,
    'distinct' => TRUE,
    'link_display' => TRUE,
    'style_plugin' => FALSE,
    'style_options' => FALSE,
    'row_plugin' => FALSE,
    'row_options' => FALSE,
    'relationships' => TRUE,
    'fields' => TRUE,
    'sorts' => TRUE,
    'arguments' => TRUE,
    'filters' => TRUE,
  ),
  'relationships' => array(),
  'fields' => array(),
  'sorts' => array(),
  'arguments' => array(),
  'filters' => array(),
  'attachment_position' => 'after',
  'inherit_arguments' => TRUE,
  'displays' => array(
    'calendar' => 'calendar',
    'default' => 0,
  ),
  'inherit_argments' => TRUE,
  'calendar_type' => 'year',
  'style_plugin' => 'calendar_view',
  'style_options' => array(
    'default_display' => 'month',
    'calendar_day_header' => '1',
  ),
  'row_plugin' => 'node',
  'row_options' => array(
    'teaser' => 1,
    'links' => 1,
  ),
);
$view->display['calendar_view'] = $display;
  $display = new views_display;
  $display->id = 'calendar_view_1';
  $display->display_title = 'Month';
  $display->display_plugin = 'calendar_view';
  $display->position = '4';
  $display->display_options = array(
  'defaults' => array(
    'access' => TRUE,
    'title' => TRUE,
    'header' => TRUE,
    'header_format' => TRUE,
    'header_empty' => TRUE,
    'footer' => TRUE,
    'footer_format' => TRUE,
    'footer_empty' => TRUE,
    'empty' => TRUE,
    'empty_format' => TRUE,
    'use_ajax' => TRUE,
    'items_per_page' => TRUE,
    'offset' => TRUE,
    'use_pager' => TRUE,
    'pager_element' => TRUE,
    'use_more' => TRUE,
    'distinct' => TRUE,
    'link_display' => TRUE,
    'style_plugin' => FALSE,
    'style_options' => FALSE,
    'row_plugin' => FALSE,
    'row_options' => FALSE,
    'relationships' => TRUE,
    'fields' => TRUE,
    'sorts' => TRUE,
    'arguments' => TRUE,
    'filters' => TRUE,
  ),
  'relationships' => array(),
  'fields' => array(),
  'sorts' => array(),
  'arguments' => array(),
  'filters' => array(),
  'attachment_position' => 'after',
  'inherit_arguments' => TRUE,
  'displays' => array(
    'calendar' => 'calendar',
    'calendar_block' => 'calendar_block',
    'default' => 0,
  ),
  'inherit_argments' => TRUE,
  'calendar_type' => 'month',
  'style_plugin' => 'calendar_view',
  'style_options' => array(
    'default_display' => 'month',
    'calendar_day_header' => '1',
  ),
  'row_plugin' => 'node',
  'row_options' => array(
    'teaser' => 1,
    'links' => 1,
  ),
);
$view->display['calendar_view_1'] = $display;
  $display = new views_display;
  $display->id = 'calendar_view_2';
  $display->display_title = 'Day';
  $display->display_plugin = 'calendar_view';
  $display->position = '5';
  $display->display_options = array(
  'defaults' => array(
    'access' => TRUE,
    'title' => TRUE,
    'header' => TRUE,
    'header_format' => TRUE,
    'header_empty' => TRUE,
    'footer' => TRUE,
    'footer_format' => TRUE,
    'footer_empty' => TRUE,
    'empty' => TRUE,
    'empty_format' => TRUE,
    'use_ajax' => TRUE,
    'items_per_page' => FALSE,
    'offset' => FALSE,
    'use_pager' => FALSE,
    'pager_element' => FALSE,
    'use_more' => TRUE,
    'distinct' => TRUE,
    'link_display' => TRUE,
    'style_plugin' => FALSE,
    'style_options' => FALSE,
    'row_plugin' => FALSE,
    'row_options' => FALSE,
    'relationships' => TRUE,
    'fields' => TRUE,
    'sorts' => TRUE,
    'arguments' => TRUE,
    'filters' => TRUE,
  ),
  'relationships' => array(),
  'fields' => array(),
  'sorts' => array(),
  'arguments' => array(),
  'filters' => array(),
  'attachment_position' => 'after',
  'inherit_arguments' => TRUE,
  'displays' => array(
    'calendar' => 'calendar',
    'default' => 0,
  ),
  'inherit_argments' => TRUE,
  'calendar_type' => 'day',
  'style_plugin' => 'default',
  'style_options' => array(),
  'row_plugin' => 'node',
  'row_options' => array(
    'teaser' => 1,
    'links' => 1,
  ),
  'items_per_page' => 5,
  'offset' => 0,
  'use_pager' => '1',
  'pager_element' => 0,
);
$view->display['calendar_view_2'] = $display;
  $display = new views_display;
  $display->id = 'calendar_view_3';
  $display->display_title = 'Week';
  $display->display_plugin = 'calendar_view';
  $display->position = '6';
  $display->display_options = array(
  'defaults' => array(
    'access' => TRUE,
    'title' => TRUE,
    'header' => TRUE,
    'header_format' => TRUE,
    'header_empty' => TRUE,
    'footer' => TRUE,
    'footer_format' => TRUE,
    'footer_empty' => TRUE,
    'empty' => TRUE,
    'empty_format' => TRUE,
    'use_ajax' => TRUE,
    'items_per_page' => TRUE,
    'offset' => TRUE,
    'use_pager' => TRUE,
    'pager_element' => TRUE,
    'use_more' => TRUE,
    'distinct' => TRUE,
    'link_display' => TRUE,
    'style_plugin' => FALSE,
    'style_options' => FALSE,
    'row_plugin' => FALSE,
    'row_options' => FALSE,
    'relationships' => TRUE,
    'fields' => TRUE,
    'sorts' => TRUE,
    'arguments' => TRUE,
    'filters' => TRUE,
  ),
  'relationships' => array(),
  'fields' => array(),
  'sorts' => array(),
  'arguments' => array(),
  'filters' => array(),
  'attachment_position' => 'after',
  'inherit_arguments' => TRUE,
  'displays' => array(
    'calendar' => 'calendar',
    'default' => 0,
    'calendar_block' => 0,
  ),
  'inherit_argments' => TRUE,
  'calendar_type' => 'week',
  'style_plugin' => 'calendar_view',
  'style_options' => array(
    'default_display' => 'month',
    'calendar_day_header' => '1',
  ),
  'row_plugin' => 'node',
  'row_options' => array(
    'teaser' => 1,
    'links' => 1,
  ),
);
$view->display['calendar_view_3'] = $display;
  $display = new views_display;
  $display->id = 'calendar_block';
  $display->display_title = 'Block';
  $display->display_plugin = 'calendar_block';
  $display->position = '7';
  $display->display_options = array(
  'defaults' => array(
    'access' => TRUE,
    'title' => TRUE,
    'header' => TRUE,
    'header_format' => TRUE,
    'header_empty' => TRUE,
    'footer' => TRUE,
    'footer_format' => TRUE,
    'footer_empty' => TRUE,
    'empty' => TRUE,
    'empty_format' => TRUE,
    'use_ajax' => TRUE,
    'items_per_page' => TRUE,
    'offset' => TRUE,
    'use_pager' => TRUE,
    'pager_element' => TRUE,
    'use_more' => TRUE,
    'distinct' => TRUE,
    'link_display' => TRUE,
    'style_plugin' => FALSE,
    'style_options' => FALSE,
    'row_plugin' => FALSE,
    'row_options' => FALSE,
    'relationships' => TRUE,
    'fields' => TRUE,
    'sorts' => TRUE,
    'arguments' => TRUE,
    'filters' => TRUE,
  ),
  'relationships' => array(),
  'fields' => array(),
  'sorts' => array(),
  'arguments' => array(),
  'filters' => array(),
  'style_plugin' => 'calendar',
  'style_options' => array(
    'calendar_day_header' => '1',
  ),
  'row_plugin' => 'node',
  'row_options' => array(
    'teaser' => 1,
    'links' => 1,
  ),
);
$view->display['calendar_block'] = $display;


  $views[$view->name] = $view;
  return $views;
}