<?php

namespace Nitra\NitraThemeBundle\QueryFilter;

use Admingenerator\GeneratorBundle\QueryFilter\DoctrineQueryFilter;

class NitraDoctrineQueryFilter extends DoctrineQueryFilter
{

    /**
     * Используем свой метод для исправления ошибки при фильтрации по списку обьектов (в BETA4)
     */
    public function addEntityFilter($field, $value)
    {
        $this->query->andWhere(sprintf('q.%s = :%s',$field, $field));
        $this->query->setParameter($field, $this->query->getEntityManager()->getUnitOfWork()->getEntityIdentifier($value));
    }
 
}
