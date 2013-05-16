<?php
namespace Application\Storage;

use Application\Storage\Base as BaseStorage;
use Application\Entity\Visits as Entity;

class Visits extends BaseStorage
{
    protected $_meta = array(
        'conn'      => 'main',
        'table'     => 'visits',
        'primary'   => 'id',
        'fetchMode' => \PDO::FETCH_ASSOC
    );

    /**
     * @param $id
     *
     * @return mixed
     */
    public function findByID($id)
    {
        return $this->find($id);
    }

    public function deleteByID($id)
    {
        return $this->delete(array($this->getPrimaryKey() => $id));
    }

    /**
     * Create a record
     *
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->insert($data);
    }

    /**
     * Count all the records
     *
     * @return mixed
     */
    public function countAll()
    {
        $row = $this->_conn->createQueryBuilder()
               ->select('count(id) as total')
               ->from($this->getTableName(), 'u')
               ->execute()
               ->fetch($this->getFetchMode());

        return $row['total'];

    }

    /**
     * Get entity objects from all users rows
     *
     * @return array
     */
    public function getAll()
    {
        $entities = array();
        $rows     = $this->fetchAll();
        foreach ($rows as $row) {
            $entities[] = new Entity($row);
        }

        return $entities;

    }

    public function rowsToEntities($rows)
    {
        $ent = array();
        foreach ($rows as $r) {
            $ent[] = new Entity($r);
        }

        return $ent;
    }

}