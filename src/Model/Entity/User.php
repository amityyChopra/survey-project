<?php
namespace App\Model\Entity;

use App\Auth\LegacyPasswordHasher;
use Cake\ORM\Entity;


class User extends Entity
{

    // Make all fields mass assignable except for primary key field "id".
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    // ...
    protected $_hidden = [
        'password'
    ];
    protected function _setPassword($password)
    {
        return (new LegacyPasswordHasher)->hash($password);
    }

    
    public function getEncPassword($password)
    {
        return $this->_setPassword($password);
    }
}


?>