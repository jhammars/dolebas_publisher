<?php

/**
 * @file
 * Definition of Drupal\dolebas_publisher\Plugin\views\field\DolebasPublisherViewsField
 */

namespace Drupal\dolebas_publisher\Plugin\views\field;

use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Drupal\Core\Url;



/**
 * Field handler.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("dolebas_publisher")
 */
class DolebasPublisherViewsField extends FieldPluginBase {

  /**
   * @{inheritdoc}
   */
  public function query() {
    // Leave empty to avoid a query on this field.
  }

  /**
   * @{inheritdoc}
   */
  public function render(ResultRow $values) {

    // Get nid from parent node included in the view
    $parent_nid = strip_tags($this->view->field['nid']->original_value);
    $div_uuid = strip_tags($this->view->field['uuid']->original_value);

    // Set path to publish parent node
    $path = '/dolebas_publisher/publish/nid/' . $parent_nid;

    // Return html template with library attached
    return array(
      '#theme' => 'publish_button',
      '#myLink' => $path,
      '#div_uuid' => $div_uuid,
      '#attached' => array(
        'library' => array(
          'dolebas_publisher/publisher-views-field'
        ),
      )
    );
  }
}
