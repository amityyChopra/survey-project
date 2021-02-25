<?php
namespace App\View\Helper;
 
use Cake\View\Helper;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
 
class OnlineHelper extends Helper {
 
 
     
    public function getResponses($assessmentId,$clientId){
		$table = TableRegistry::get('ClientResponses');
        $clientResponses = $table->find()->where(array("assessment_id"=>$assessmentId,"client_id"=>$clientId))->count();
		return $clientResponses;
    }
   
}
?>