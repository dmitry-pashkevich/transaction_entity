<?php

namespace Drupal\transaction\Entity;

use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;


interface TransactionEntityInterface extends EntityChangedInterface, EntityOwnerInterface {


  public function getName();

  public function setName($name);


  public function getCreatedTime();


  public function setCreatedTime($timestamp);
}
