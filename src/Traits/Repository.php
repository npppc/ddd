<?php
namespace Npc\DDD\Traits;

use Npc\DDD\Domain\Entity;
use Npc\Model\ModelResource;
use \Exception;

trait Repository
{
    /**
     * @var ModelResource $dao
     */
    public $dao;
    /**
     * @var Entity $entity
     */
    public $entity;

    public function info($params) :? Entity
    {
        $dao = ($this->dao)::fetch($params);
        if($dao)
        {
            return $this->toEntity($dao);
        }
        return null;
    }

    /**
     * @param Entity $entity
     * @return Entity
     * @throws Exception
     */
    public function save(Entity $entity)
    {
        $dao = $this->toDao($entity);
        if(!$dao->save())
        {
            throw new Exception($dao->getErrorMessage());
        }
        return $this->toEntity($dao);
    }

    /**
     * @param Entity $entity
     * @return ModelResource
     */
    public function toDao(Entity $entity)
    {
        $dao = clone $this->dao;
        $dao->assign($entity->toArray());
        return $dao;
    }

    /**
     * @param ModelResource $model
     * @return Entity
     */
    public function toEntity(ModelResource $model)
    {
        $entity = clone $this->entity;
        $entity->fill($model->toArray());
        return $entity;
    }
}