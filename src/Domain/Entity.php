<?php
namespace Npc\DDD\Domain;

use Npc\Entity\Base;

/**
 * Class Entity
 * @package Npc\DDD\Domain
 * @property string $conditions 条件
 * @property $columns
 * @property array $bind
 * @property array $bindTypes
 * @property string order
 * @property string $limit
 * @property string $offset
 * @property string $group
 * @property bool $for_updated
 * @property bool $shared_lock
 * @property array $cache
 * @property $hydration
 */
class Entity extends Base
{

}