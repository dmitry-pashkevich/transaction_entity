<?php

namespace Drupal\transaction\Form;

use Drupal\Core\Entity\BundleEntityFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\field_ui\FieldUI;
use Drupal\transaction\Entity\TransactionTypeEntity;


class TransactionTypeEntityForm extends BundleEntityFormBase {


  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);
    $entity_type = $this->entity;

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $entity_type->label(),
      '#description' => $this->t("Label"),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $entity_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\transaction\Entity\TransactionTypeEntity::load',
      ],
      '#disabled' => !$entity_type->isNew(),
    ];

    $form['description'] = [
      '#title' => $this->t('Description'),
      '#type' => 'textarea',
      '#default_value' => $entity_type->getDescription(),
      '#description' => $this->t('This text will be displayed on the "Add %content_entity_id" page.', ['%content_entity_id' => $content_entity_id]),
    ];



    return $this->protectBundleIdElement($form);
  }



  protected function actions(array $form, FormStateInterface $form_state) {
    $actions = parent::actions($form, $form_state);

    if (\Drupal::moduleHandler()->moduleExists('field_ui') && $this->getEntity()->isNew()) {
      $actions['save_continue'] = $actions['submit'];
      $actions['save_continue']['#value'] = $this->t('Save and manage fields');
      $actions['save_continue']['#submit'][] = [$this, 'redirectToFieldUi'];
    }

    return $actions;
  }


  public function save(array $form, FormStateInterface $form_state) {
    $entity_type = $this->entity;
    $status = $entity_type->save();

    $form_state->setRedirectUrl($entity_type->toUrl('collection'));
  }


  public function redirectToFieldUi(array $form, FormStateInterface $form_state) {
    $route_info = FieldUI::getOverviewRouteInfo($this->entity->getEntityType()->getBundleOf(), $this->entity->id());
        if ($form_state->getTriggeringElement()['#parents'][0] === 'save_continue' && $route_info) {
      $form_state->setRedirectUrl($route_info);
    }
  }
}


