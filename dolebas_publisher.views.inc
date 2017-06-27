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
}