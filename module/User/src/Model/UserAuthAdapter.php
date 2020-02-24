<?php

namespace User\Model;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Zend\Crypt\Password\Bcrypt;
use RuntimeException;

class UserAuthAdapter implements AdapterInterface
{
    private $password;
    private $username;
    private $table;
    
    public function __construct(UserTable $table) {
        $this->table = $table;
    }

    public function setPassword(string $password) : void
    {
        $this->password = $password;
    }

    public function setUsername(string $username) : void
    {
        $this->username = $username;
    }

    public function authenticate() : Result
    {
        try {
            $user = $this->table->getUserByName($this->username);
        }
        catch (RuntimeException $e){
            // Remember to import dammit!
            return new Result(Result::FAILURE_IDENTITY_NOT_FOUND, $this->username);
        }
        if ($user){
            $bcrypt = new Bcrypt();
            if ($bcrypt->verify($this->password, $user->hashedPassword)){
                // Not sure if i should use username for identity, but Id seems more usefull, when showing users own cats.
                return new Result(Result::SUCCESS, $user->id);
            }
        }
        return new Result(Result::FAILURE_CREDENTIAL_INVALID, $this->username);
    }
}