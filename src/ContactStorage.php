<?php

namespace Drupal\contact_form;

class ContactStorage {

  static function getAll() {
    $result = db_query('SELECT * FROM {contact_form}')->fetchAllAssoc('id');
    return $result;
  }

  static function exists($id) {
    return (bool) $this->get($id);
  }

  static function get($id) {
    $result = db_query('SELECT * FROM {contact_form} WHERE id = :id', array(':id' => $id))->fetchAllAssoc('id');
    if ($result) {
      return $result[$id];
    }
    else {
      return FALSE;
    }
  }

  static function add($name, $message) {
    db_insert('contact_form')->fields(array(
      'name' => $name,
      'message' => $message,
    ))->execute();
  }

  static function edit($id, $name, $message) {
    db_update('contact_form')->fields(array(
      'name' => $name,
      'message' => $message,
    ))
    ->condition('id', $id)
    ->execute();
  }
  
  static function delete($id) {
    db_delete('contact_form')->condition('id', $id)->execute();
  }
}
