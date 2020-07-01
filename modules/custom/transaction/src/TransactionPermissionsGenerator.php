<?php

namespace Drupal\transaction;

use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Class TransactionPermissionsGenerator
 */
class TransactionPermissionsGenerator {

  use StringTranslationTrait;

  public function transactionTypePermissions() {

    return [

      "view transaction" => [
        'title' => $this->t('View all Transaction')
      ],

      "edit transaction" => [
        'title' => $this->t('Edit Transaction')
      ],

      "create new transaction" => [
        'title' => $this->t("Create new Transaction"),
      ]

    ];

  }

}
