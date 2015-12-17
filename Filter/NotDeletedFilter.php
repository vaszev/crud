<?php

namespace Vaszev\CrudBundle\Filter;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class NotDeletedFilter extends SQLFilter {
  /**
   * Gets the SQL query part to add to a query.
   * @return string The constraint SQL if there is available, empty string otherwise.
   */
  public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias) {
    $filter = $targetEntity->reflClass->implementsInterface('AppBundle\Entity\SoftDeleteInterface') ? $targetTableAlias . '.deleted IS NULL' : '';
    return $filter;
  }
}
