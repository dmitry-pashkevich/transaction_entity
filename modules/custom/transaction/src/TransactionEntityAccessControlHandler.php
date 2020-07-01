<?php

namespace Drupal\transaction;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

class TransactionEntityAccessControlHandler extends EntityAccessControlHandler {

  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {


    $is_owner = $entity->getOwnerId() === $account->id();

    switch ($operation) {
      case 'view':

        if ($is_owner) {
          return AccessResult::allowed();
        }

        if($account->hasPermission('edit transaction')) {
          return AccessResult::allowed();
        }

        return AccessResult::allowedIfHasPermission($account, 'view transaction');

      case 'update':
        if ($is_owner) {
          return AccessResult::allowed();
        }
        return AccessResult::allowedIfHasPermission($account, "edit transaction");

      case 'delete':
        if ($is_owner) {
          return AccessResult::allowed();
        }
        return AccessResult::forbidden();
    }

    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, "create new transaction");
  }
}
