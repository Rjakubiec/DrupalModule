<?php
/**
 * @file
 * Contains \Drupal\contact_form\AddForm.
 */

namespace Drupal\contact_form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\SafeMarkup;

class AddForm extends FormBase {
  protected $id;

  function getFormId() {
    return 'contact_form_add';
  }

  function buildForm(array $form, FormStateInterface $form_state) {
    $this->id = \Drupal::request()->get('id');
    $contact_form = ContactStorage::get($this->id);

    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => t('Name'),
      '#default_value' => ($contact_form) ? $contact_form->name : '',
    );
    $form['message'] = array(
      '#type' => 'textarea',
      '#title' => t('Message'),
      '#default_value' => ($contact_form) ? $contact_form->message : '',
    );
    $form['actions'] = array('#type' => 'actions');
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => ($contact_form) ? t('Edit') : t('Add'),
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

  }


  function submitForm(array &$form, FormStateInterface $form_state) {
    $name = $form_state->getValue('name');
    $message = $form_state->getValue('message');
    if (!empty($this->id)) {
      ContactStorage::edit($this->id, SafeMarkup::checkPlain($name), SafeMarkup::checkPlain($message));
      \Drupal::logger('contact_form')->notice('@type: deleted %title.',
          array(
              '@type' => $this->id,
              '%title' => $this->id,
          ));

      drupal_set_message(t('Your message has been edited'));
    }
    else {
      ContactStorage::add(SafeMarkup::checkPlain($name), SafeMarkup::checkPlain($message));
      \Drupal::logger('contact_form')->notice('@type: deleted %title.',
          array(
              '@type' => $this->id,
              '%title' => $this->id,
          ));

      drupal_set_message(t('Your message has been submitted'));
    }
    $form_state->setRedirect('contact_form_list');
    return;
  }
}
