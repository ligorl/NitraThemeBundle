<?php

namespace Nitra\NitraThemeBundle\QueryFilter;

use Admingenerator\GeneratorBundle\QueryFilter\DoctrineQueryFilter;

class NitraDoctrineQueryFilter extends DoctrineQueryFilter
{

    public function addEntityFilter($field, $value)
    {
        $this->query->andWhere(sprintf('q.%s = :%s',$field, $field));
        $this->query->setParameter($field, $value->getId());
    }
 
}
