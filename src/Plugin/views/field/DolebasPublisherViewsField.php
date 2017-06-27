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

//  /**
//   * Define the available options
//   * @return array
//   */
//  protected function defineOptions() {
//    $options = parent::defineOptions();
//    $options['require_revisions'] = array('default' => 1);
//
//    return $options;
//  }
//
//  /**
//   * Provide the options form.
//   */
//  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
//
//    $form['require_revisions'] = array(
//      '#title' => $this->t('Which revision nr must the node have >= in order to allow for publishing the node?'),
//      '#type' => 'number',
//      '#default_value' => $this->options['require_revisions'],
//      '#options' => $options,
//    );
//
//    parent::buildOptionsForm($form, $form_state);
//
//  }

  /**
   * @{inheritdoc}
   */
  public function render(ResultRow $values) {

    // Get nid from parent node included in the view
    $parent_nid = strip_tags($this->view->field['nid']->original_value);

    // Get nid of transaction node(s) with a reference to the @parent_nid
    $query = \Drupal::entityQuery('node')
      ->condition('type', 'dolebas_transaction')
      ->condition('field_dolebas_trans_parent_ref.target_id', $parent_nid);
    $nid_array = $query->execute();
    $trasaction_nid = reset($nid_array);

    // If there are any existing transactions, get the payment status
    if ($trasaction_nid > 0) {
      $node = \Drupal\node\Entity\Node::load($trasaction_nid);
      $transaction_status = $node->field_dolebas_trans_status->value;
    } else {
      $transaction_status = null;
    }

    /**
     * If payment is not confirmed, a modal window with a message should appear
     * After payment is confirmed, publish link works but redirection doesn't work
     * TODO: Fix action after successfully hitting the publish ajax-link
     */

    // Set path to publish parent node
    $path = '/dolebas_publisher/publish/nid/' . $parent_nid;

    // Build url
    $publish_and_redirect_url = Url::fromUserInput($path, $options = []);
//      array('attributes' =>
//        array(
//          'class' => 'use-ajax',
//          'data-dialog-type' => "modal"
//        )
//      )
//    );
    $modal_message_url = Url::fromUserInput($path, $options =
      array('attributes' =>
        array(
          'class' => 'use-ajax',
          'data-dialog-type' => "modal"
        )
      )
    );

    // Build link
    $publish_and_redirect_link = \Drupal::service('link_generator')->generate('Publish', $publish_and_redirect_url);
    $modal_message_link = \Drupal::service('link_generator')->generate('Publish', $modal_message_url);

    // Checks the payment status at the time of the page load
    // TODO: Check the payment status when clicking the link instead.
    // TODO: Link should always be ajax modal but when payment is true the controller should make
    // TODO: sure that the page is reloaded.

//    $build['publisher_handler']['#theme'] = 'publish_button';
//
//    $build['publisher_handler']['#attached'] = [
//      // Attach the .js library
//      'library' => [
//        'dolebas_publisher/publisher-handler'
//      ],
//      // Attach parameters to the .js library
//      'drupalSettings' => [
//        'parent_nid' => $parent_nid,
//      ]
//    ];
//
//    return $build;

   if ($transaction_status == 'succeeded') {
      return $publish_and_redirect_link;
    } else {
      return $modal_message_link;
    }

  }
}
