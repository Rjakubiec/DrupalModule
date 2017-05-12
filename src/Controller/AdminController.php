<?php
/**
@file
Contains \Drupal\contact_form\Controller\AdminController.
 */

namespace Drupal\contact_form\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\contact_form\ContactStorage;

class AdminController extends ControllerBase {

function contentOriginal() {
  $url = Url::fromRoute('contact_form_add');

  $add_link = '<p>' . \Drupal::l(t('New message'), $url) . '</p>';


  $header = array( 'id' => t('Id'), 'name' => t('Submitter name'), 'message' => t('Message'), 'operations' => t('Delete'), );

  $rows = array();
  foreach(ContactStorage::getAll() as $id=>$content) {

    $rows[] = array( 'data' => array($id, $content->name, $content->message, l('Delete', "admin/content/contact_form/delete/$id")) );
   }

   $table = array( '#type' => 'table', '#header' => $header, '#rows' => $rows, '#attributes' => array( 'id' => 'bd-contact-table', ), );
   return $add_link . drupal_render($table);
 }

  public function content1() {
    return array(
      '#type' => 'markup',
      '#markup' => t('Hello World'),
    );
  }

  function content() {
    $url = Url::fromRoute('contact_form_add');

    $add_link = '<p>' . \Drupal::l(t('New message'), $url) . '</p>';

    $text = array(
      '#type' => 'markup',
      '#markup' => $add_link,
    );

    $header = array(
      'id' => t('Id'),
      'name' => t('Submitter name'),
      'message' => t('Message'),
      'operations' => t('Delete'),
    );
    $rows = array();
    foreach (ContactStorage::getAll() as $id => $content) {

      $editUrl = Url::fromRoute('contact_form_edit', array('id' => $id));
      $deleteUrl = Url::fromRoute('contact_form_delete', array('id' => $id));

      $rows[] = array(
        'data' => array(
          \Drupal::l($id, $editUrl),
          $content->name, $content->message,
          \Drupal::l('Delete', $deleteUrl)
        ),
      );
    }
    $table = array(
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#attributes' => array(
        'id' => 'bd-contact-table',
      ),
    );

    return array(
      $text,
      $table,
    );
  }
}
