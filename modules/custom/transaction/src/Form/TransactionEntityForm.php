<?php

namespace Drupal\transaction\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;


class TransactionEntityForm extends ContentEntityForm {


  public function save(array $form, FormStateInterface $form_state) {

    $entity = &$this->entity;
    $status = parent::save($form, $form_state);
    $content_entity_id = $entity->getEntityType()->id();
    $form_state->setRedirect("entity.{$content_entity_id}.canonical", [$content_entity_id => $entity->id()]);

  }
}
