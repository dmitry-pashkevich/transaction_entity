<?php

namespace Drupal\transaction\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**

 * @ConfigEntityType(
 *   id = "transaction_type",
 *   label = @Translation("Transaction Type"),
 *   bundle_of = "transaction",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *   },
 *   config_prefix = "transaction_type",
 *   config_export = {
 *     "id",
 *     "label",
 *     "description",
 *   },
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\transaction\TransactionTypeListBuilder",
 *     "form" = {
 *       "default" = "Drupal\transaction\Form\TransactionTypeEntityForm",
 *       "add" = "Drupal\transaction\Form\TransactionTypeEntityForm",
 *       "edit" = "Drupal\transaction\Form\TransactionTypeEntityForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   admin_permission = "administer transaction types",
 *   links = {
 *     "canonical" = "/admin/structure/transaction_type/{transaction_type}",
 *     "add-form" = "/admin/structure/transaction_type/add",
 *     "edit-form" = "/admin/structure/transaction_type/{transaction_type}/edit",
 *     "delete-form" = "/admin/structure/transaction_type/{transaction_type}/delete",
 *     "collection" = "/admin/structure/transaction_type",
 *   }
 * )
 */


class TransactionTypeEntity extends ConfigEntityBundleBase implements TransactionTypeEntityInterface {

  protected $id;
  protected $label;
  protected $description;


  public function getDescription() {
    return $this->description;
  }

  public function setDescription($description) {
    $this->description = $description;
    return $this;
  }

}
