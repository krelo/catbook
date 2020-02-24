<?php

namespace Cat\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class CatTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function fetchByUser($id)
    {
        return $this->tableGateway->select(['owner_id' => $id]);
    }

    public function getCat($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveCat(Cat $cat)
    {
        $data = [
            'name' => $cat->name,
            'race'  => $cat->race,
            'owner_id'  => $cat->ownerId,
        ];

        $id = (int) $cat->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getCat($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update cat with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteCat($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }

    // Join in owner name on each row
    public function fetchAllDetailed()
    {
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(array('name', 'race', 'owner_id'));
        $sqlSelect->join('user', 'cat.owner_id = user.id', array('owner_name' => 'username'), 'left');

        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();

        $result = array();
        while ($resultSet->next()){
            $cat = new Cat();
            $cat->exchangeArray($resultSet->current());
            $result[] = $cat;
        }

        return $result;
    }
}