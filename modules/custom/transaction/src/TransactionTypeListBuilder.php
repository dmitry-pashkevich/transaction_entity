<?php

namespace Drupal\transaction;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;


class TransactionTypeListBuilder extends EntityListBuilder {


  public function buildHeader(){
    $header['label'] = $this->t('Label');
    $header['description'] = $this->t('Description');
    $header['id'] = $this->t('Machine name');

    return $header + parent::buildHeader();
  }

  public function buildRow(EntityInterface $entity) {

    $row['label'] = $entity->label();
    $row['description'] = $entity->getDescription();
    $row['id'] = $entity->id();
    return $row + parent::buildRow($entity);
  }
}
