<?php
namespace App\Auth;

use Cake\Auth\AbstractPasswordHasher;


class LegacyPasswordHasher extends AbstractPasswordHasher
{
   
   public function hash($password)
    {   
        require_once('PasswordHash.php');
        $passwordObj =  new \PasswordHash(8,true);

        return $passwordObj->HashPassword($password);
    }

    public function check($password, $hashedPassword){
        require_once('PasswordHash.php');
        $passwordObj =  new \PasswordHash(8,true);   
        return $passwordObj->CheckPassword($password,$hashedPassword) ;
    }
}
?>
