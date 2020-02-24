<?php

namespace User\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class UserTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getUser($id)
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

    public function getUserByName($username)
    {
        $rowset = $this->tableGateway->select(['username' => $username]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %s',
                $username
            ));
        }

        return $row;
    }


    public function userExists($username) : bool {
        $rowset = $this->tableGateway->select(['username' => $username]);
        $row = $rowset->current();
        if (! $row) {
            return false;
        }
        return true;
    }



    public function createUser(User $user)
    {
        $data = [
            'username' => $user->username,
            'hashedPassword'  => $user->hashedPassword,
        ];

        $id = (int) $username->id;

        if ($id === 0) {
            $existingUser = $this->userExists($user->username);
            if ($existingUser)
            {
                throw new RuntimeException(sprintf(
                    'Username is already taken: %s', $user->username
                ));            
            }
            $this->tableGateway->insert($data);
            return;
        }
    }

    public function saveUser(User $user)
    {
        $data = [
            'username' => $user->username,
            'hashedPassword'  => $user->hashedPassword,
        ];

        $id = (int) $username->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        try {
            $this->getUser($id);
        } catch (RuntimeException $e) {
            throw new RuntimeException(sprintf(
                'Cannot update user with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteUser($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}