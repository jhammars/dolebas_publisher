<?php

/**
 * Implements hook_views_data_alter().
 */
function dolebas_publisher_views_data_alter(array &$data) {

  $data['node']['dolebas_publisher'] = array(
    'title' => t('Dolebas Publish Button'),
    'field' => array(
      'title' => t('Dolebas Publish Button'),
      'help' => t('Publishes a node'),
      'id' => 'dolebas_publisher',
    ),
  );
  
  $data['node']['dolebas_publisher_toggle_div'] = array(
    'title' => t('Dolebas Toggle Div'),
    'field' => array(
      'title' => t('Dolebas Toggle Div'),
      'help' => t('Toggle between video/thumbnail/options div'),
      'id' => 'dolebas_publisher_toggle_div',
    ),
  );  
  
}