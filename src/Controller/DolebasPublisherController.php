<?php
/** 
 * @file 
 * Contains \Drupal\dolebas_publisher\Controller\DolebasPublisherController. 
 */
namespace Drupal\dolebas_publisher\Controller;

use Drupal\Core\Controller\ControllerBase;

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
        $new_node = \Drupal\node\Entity\Node::create(
          array(  'title'   => 'Dolebas Parent',
                  'status'  => 0,
                  'type'    => 'dolebas_publisher',  )
        );
        $new_node->save();

        // Redirect to redirection page in order to refresh previous url
        //$previous_url = 'http://develop.kbox.site/hi/' . $previous_url;

        //$previous_url = bin2hex($previous_url);
        //$hi_url = 'http://develop.kalabox.site/hi/' . $previous_url;
        // Redirect to previous Url

//        print '<pre>';print_r($hi_url);exit;
//        return new \Symfony\Component\HttpFoundation\RedirectResponse('/node');

//        $commands = array();
//        $commands[] = array('command' => 'reloadPage');
//        return array('#type' => 'ajax', '#commands' => $commands);

//        $my_url = '/node';
//        $redir = \Drupal\Core\AjaxRedirectCommand::$my_url;
//        return $redir;

      // Redirect to previous url
      // TODO: Check for alternative, HTTP_REFERER is not always reliable
      $previous_url= \Drupal::request()->server->get('HTTP_REFERER');
      return new \Symfony\Component\HttpFoundation\RedirectResponse($previous_url);

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