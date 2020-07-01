<?php

namespace Drupal\transaction\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\user\UserInterface;

/**
 * Defines the transaction entity.
 *
 * @ContentEntityType(
 *   id = "transaction",
 *   label = @Translation("Transaction"),
 *   base_table = "transaction",
 *   entity_keys = {
 *     "id" = "id",
 *     "bundle" = "bundle",
 *     "uid" = "uid",
 *     "label" = "name",
 *     "created" = "created",
 *     "changed" = "changed",
 *   },
 *   fieldable = TRUE,
 *   admin_permission = "administer transaction types",
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\transaction\TransactionListBuilder",
 *     "access" = "Drupal\transaction\TransactionEntityAccessControlHandler",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "default" = "Drupal\transaction\Form\TransactionEntityForm",
 *       "add" = "Drupal\transaction\Form\TransactionEntityForm",
 *       "edit" = "Drupal\transaction\Form\TransactionEntityForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   links = {
 *     "canonical" = "/transaction/{transaction}",
 *     "add-page" = "/transaction/add",
 *     "add-form" = "/transaction/add/{transaction_type}",
 *     "edit-form" = "/transaction/{transaction}/edit",
 *     "delete-form" = "/transaction/{transaction}/delete",
 *     "collection" = "/admin/content/transactions",
 *   },
 *   bundle_entity_type = "transaction_type",
 *   field_ui_base_route = "entity.transaction_type.edit_form",
 * )
 */
class TransactionEntity extends ContentEntityBase implements TransactionEntityInterface {

  use EntityChangedTrait;


  public function getName() {
    return $this->get('name')->value;
  }

  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  public function getOwner() {
    return $this->get('uid')->entity;
  }

  public function getOwnerId() {
    return $this->get('uid')->target_id;
  }

  public function setOwner(UserInterface $account) {
    $this->set('uid', $account->id());
    return $this;
  }

  public function setOwnerId($uid) {
    $this->set('uid', $uid);
    return $this;
  }


  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the transaction entity.'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
       ->setLabel(t('Name'))
       ->setDescription(t('The name of the transaction entity.'))
       ->setSettings([
         'max_length' => 50,
         'text_processing' => 0,
       ])
       ->setDefaultValue('')
       ->setDisplayOptions('view', [
         'label' => 'hidden',
         'type' => 'string',
         'weight' => -4,
       ])
       ->setDisplayOptions('form', [
         'type' => 'string_textfield',
         'weight' => -4,
       ])
       ->setDisplayConfigurable('form', TRUE)
       ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    $fields['sender'] = BaseFieldDefinition::create('string')
      ->setLabel(t("Sender"))
      ->setDisplayOptions('form', ["type" => "string_textfield"])
      ->setRequired(TRUE);

    $fields['recipient'] = BaseFieldDefinition::create('string')
      ->setLabel('Recipient')
      ->setDisplayOptions('form', ["type" => "string_textfield"])
      ->setRequired(TRUE);

    $fields['amount'] = BaseFieldDefinition::create('decimal')
      ->setLabel('Amount')
      ->setDisplayOptions('form', ["type" => "number"])
      ->setRequired(TRUE);

    return $fields;
  }


  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'uid' => \Drupal::currentUser()->id(),
    ];
  }

}
