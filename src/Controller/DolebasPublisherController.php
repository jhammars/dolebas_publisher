<?php
/**
 * @file
 * Contains \Drupal\dolebas_publisher\Controller\DolebasPublisherController. 
 */
namespace Drupal\dolebas_publisher\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\RedirectCommand;

class DolebasPublisherController extends ControllerBase {

  // Publish content with nid = $parent_nid, or return a message
  public function content($parent_nid) {

    // If the node is unpublished
    $parent_node = \Drupal\node\Entity\Node::load($parent_nid);
    if ($parent_node->status->value == 0) {
      // Get nid of payment reference child node
      $query = \Drupal::entityQuery('node')
        ->condition('type', 'dolebas_transaction')
        ->condition('field_dolebas_trans_parent_ref.target_id', $parent_nid);
      $nid_array = $query->execute();
      $trasaction_nid = reset($nid_array);

      // Get payment status from transaction node
      $node = \Drupal\node\Entity\Node::load($trasaction_nid);
      $transaction_status = $node->field_dolebas_trans_status->value;

      // If payment status is "succeeded"
      if ($transaction_status == 'succeeded') {

        // Publish transaction parent node
        $parent_node = \Drupal\node\Entity\Node::load($parent_nid);
        $parent_node->set("status", 1);
        $parent_node->save();

        // Create new unpublished node
        $uuid = \Drupal::service('uuid')->generate();
        $new_node = \Drupal\node\Entity\Node::create(
          array(  'title'   => $uuid,
                  'uuid'    => $uuid,
                  'status'  => 0,
                  'type'    => 'dolebas_publisher',  )
        );
        $new_node->save();
        
        // Get URL of view and redirect user to that URL.
        $previous_url= \Drupal::request()->server->get('HTTP_REFERER');
        $ajax_response = new AjaxResponse();
        $ajax_response->addCommand(new RedirectCommand($previous_url));
        return $ajax_response;


      // If payment status is not "succeeded", return this message
      } else {
        return array(
          '#type' => 'markup',
          '#markup' => $this->t('Payment is required before publishing')
        );
      }

    // If the parent node is already published, return this message instead
    } else {
      return array(
        '#type' => 'markup',
        '#markup' => $this->t('Already published'),
      );
    }
  }
}
