<?php

/**
 * @file
 * Definition of Drupal\dolebas_publisher\Plugin\views\field\ToggleDivViewsField
 */

namespace Drupal\dolebas_publisher\Plugin\views\field;

use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;


/**
 * Field handler.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("dolebas_publisher_toggle_div")
 */
class ToggleDivViewsField extends FieldPluginBase {

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

    // Return html template with library attached
    return array(
      '#theme' => 'toggle_div',

      '#div_uuid' => $div_uuid,
      '#attached' => array(
        'library' => array(
          'dolebas_publisher/toggle-div'
        ),
        'drupalSettings' => array(
          'div_uuid' => $div_uuid
        )
      )
    );
  }
}
