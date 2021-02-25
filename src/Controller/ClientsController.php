<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use ImageResize;


/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3/en/controllers/pages-controller.html
 */
class ClientsController extends AppController
{
    /**
     * Displays a view
     *
     * @param array ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Http\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\Http\Exception\NotFoundException When the view file could not
     *   be found
     * @throws \Cake\View\Exception\MissingTemplateException In debug mode.
     */

    function beforeFilter(\Cake\Event\Event $event) {
		parent::beforeFilter($event);
        $this->Auth->allow(array("login","logout","myAuth"));
        
		
		if(!empty($this->Auth->user())){
			$userLoggedIn = $this->Auth->user();
            $this->set(compact("userLoggedIn"));

            $userType = $this->Auth->user("role_id");

            $notAllowedUsers = array(3);

            if(in_array($userType,$notAllowedUsers)){
                $this->Flash->error(__("You are not authorized to view this."));
                $this->redirect(array("controller"=>"Assessments","action"=>"index"));
            }

		}
	}


    /* Client Listing page */
    public function index(){

        $clientActive = "Active";
        $this->set(compact("clientActive"));

        $this->loadModel("Clients");
        $allClients = $this->Clients->find()->contain(array("Industries"))->order(array("client_name"=>"asc"));
        $this->set(compact("allClients"));
        
    }
    /* Add Client Page*/
	
	public function addClient(){
        $clientActive = "Active";
        $this->set(compact("clientActive"));

        $this->loadModel("Industries");
        $allIndustries = $this->Industries->find();
        $this->set(compact("allIndustries"));

        $this->loadModel("Assessments");
        $allActiveAssessments = $this->Assessments->find()->where(array('disabled'=>1));
        $this->set(compact("allActiveAssessments"));

        $this->loadModel("ClientAssessments");

		if($this->request->is("post")){
            $data = $this->request->getData();
            $destination = realpath("../webroot/img/client_logos/")."/";

            require_once(ROOT . DS . 'vendor' . DS . 'resize' . DS . 'Resize.php');
            $image = new ImageResize();

            if(!empty($data["photo"]["name"])){
                $fileName = time()."-".$_FILES["photo"]["name"];
                move_uploaded_file($_FILES["photo"]["tmp_name"],$destination.$fileName);
                
                $image->resize('../webroot/img/client_logos/'. $fileName, '../webroot/img/client_logos/medium/' . $fileName, 'aspect_fit', 128, 128, 0, 0, 0, 0);

				$data["photo_logo"] =  $fileName;
            }
            $data["valid_from"] = date("Y-m-d",strtotime($data["valid_from"]));
            $data["valid_to"] = date("Y-m-d",strtotime($data["valid_to"]));

            $clientEntity = $this->Clients->newEntity();
            $clientEntity = $this->Clients->patchEntity($clientEntity,$data);
            if($result = $this->Clients->save($clientEntity)){

                $clientId = $result->id;

                if(!empty($data["assessment_id"])){
                    foreach($data["assessment_id"] as $assessmentId){
                        $assignAssessmentEntity = $this->ClientAssessments->newEntity();
                        $assginAssessmentData["client_id"] = $clientId;
                        $assginAssessmentData["assessment_id"] = $assessmentId;
                        $assignAssessmentEntity = $this->ClientAssessments->patchEntity($assignAssessmentEntity,$assginAssessmentData);
                        $this->ClientAssessments->save($assignAssessmentEntity);
                    }
                }
            }

            $this->Flash->success(__("Client is saved successfully !"));
            $this->redirect(array("action"=>"index"));
        }
    }
    public function editClient($clientId){

        $clientActive = "Active";
        $this->set(compact("clientActive"));
        
        $clientId = convert_uudecode(base64_decode($clientId));

        $this->loadModel("Industries");
        $allIndustries = $this->Industries->find();
        

        $this->loadModel("ClientAssessments");
        $getClientAssessments = $this->ClientAssessments->find()->where(array("client_id"=>$clientId));
        $countAssignedAssessments = $getClientAssessments->count();
        $assignedAssessments = array();
        if($countAssignedAssessments>0){
            foreach($getClientAssessments as $assignAssessment){
                $assignedAssessments[] = $assignAssessment["assessment_id"];
            }
        }
        $this->set(compact("allIndustries","assignedAssessments"));

        $this->loadModel("Assessments");
        $allActiveAssessments = $this->Assessments->find()->where(array('disabled'=>1));
        $this->set(compact("allActiveAssessments"));

        $clientEntity = $this->Clients->get($clientId);
        $this->set(compact("clientEntity"));

		if($this->request->is("post")){
            $data = $this->request->getData();

            $destination = realpath("../webroot/img/client_logos/")."/";

            require_once(ROOT . DS . 'vendor' . DS . 'resize' . DS . 'Resize.php');
            $image = new ImageResize();

            if(!empty($data["photo"]["name"])){
                $fileName = time()."-".$_FILES["photo"]["name"];
                move_uploaded_file($_FILES["photo"]["tmp_name"],$destination.$fileName);
                
                $image->resize('../webroot/img/client_logos/'. $fileName, '../webroot/img/client_logos/medium/' . $fileName, 'aspect_fit', 128, 128, 0, 0, 0, 0);

				$data["photo_logo"] =  $fileName;
            }
            $data["valid_from"] = date("Y-m-d",strtotime($data["valid_from"]));
            $data["valid_to"] = date("Y-m-d",strtotime($data["valid_to"]));

            if(!empty($data["disabled"])){
                $data["disabled"] = 1;
            }else{
                $data["disabled"] = 0;
            }


            $clientEntity = $this->Clients->patchEntity($clientEntity,$data);
            if($this->Clients->save($clientEntity)){

                $deleteAssignedAssessments = $this->ClientAssessments->deleteAll(["client_id"=>$clientId]);
                if(!empty($data["assessment_id"])){
                    foreach($data["assessment_id"] as $assessmentId){
                        $assignAssessmentEntity = $this->ClientAssessments->newEntity();
                        $assginAssessmentData["client_id"] = $clientId;
                        $assginAssessmentData["assessment_id"] = $assessmentId;
                        $assignAssessmentEntity = $this->ClientAssessments->patchEntity($assignAssessmentEntity,$assginAssessmentData);
                        $this->ClientAssessments->save($assignAssessmentEntity);
                    }
                }
            }




            $this->Flash->success(__("Client is saved successfully !"));
            $this->redirect(array("action"=>"index"));
        }
    }


    public function industries(){

        $industryActive = "Active";
        $this->set(compact("industryActive"));

        $this->loadModel("Industries");
        $allIndustries = $this->Industries->find()->order(array("industry_title"=>"asc"));
        $this->set(compact("allIndustries"));
        
    }
    /* Add Client Page*/
	
	public function addIndustry(){

        $this->loadModel("Industries");
       

		if($this->request->is("post")){
            $data = $this->request->getData();

            $industryEntity = $this->Industries->newEntity();
            $industryEntity = $this->Industries->patchEntity($industryEntity,$data);
            $this->Industries->save($industryEntity);

            $this->Flash->success(__("Industry is saved successfully !"));
            $this->redirect(array("action"=>"industries"));
        }
    }
    public function editIndustry($industryId){
        $industryId = convert_uudecode(base64_decode($industryId));

        $this->loadModel("Industries");
       
        $industryEntity = $this->Industries->get($industryId);
        $this->set(compact("industryEntity"));

		if($this->request->is("post")){
            $data = $this->request->getData();

            $industryEntity = $this->Industries->patchEntity($industryEntity,$data);
            $this->Industries->save($industryEntity);

            $this->Flash->success(__("Industry is saved successfully !"));
            $this->redirect(array("action"=>"industries"));
        }
    }
	public function deleteClient($clientId){
        $clientId = convert_uudecode(base64_decode($clientId));

        $clientEntity = $this->Clients->get($clientId);

        $this->loadModel("ClientResponses");
        if($this->ClientResponses->exists(["client_id"=>$clientId])){
            $this->Flash->error(__("Client can't be deleted !"));
        }else{
            $this->Clients->delete($clientEntity);

            $this->Flash->success(__("Client is deleted successfully !"));
        }


        
        $this->redirect(array("action"=>"index"));
    }
    public function deleteIndustry($industryId){
        $industryId = convert_uudecode(base64_decode($industryId));

        $this->loadModel("Industries");


        if($this->Clients->exists(["client_industry"=>$industryId])){
            $this->Flash->error(__("Industry is tagged with client(s), so can't be deleted !"));
        }else{
            $industryEntity = $this->Industries->get($industryId);

            $this->Industries->delete($industryEntity);
    
            $this->Flash->success(__("Industry is deleted successfully !"));
            
        }

        
        $this->redirect(array("action"=>"industries"));
    }
	
}
