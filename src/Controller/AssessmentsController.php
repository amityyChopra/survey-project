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
class AssessmentsController extends AppController
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
        $assessmentActive = "Active";
        $this->set(compact("assessmentActive"));
		
		if(!empty($this->Auth->user())){
			$userLoggedIn = $this->Auth->user();
			$this->set(compact("userLoggedIn"));
		}
	}

    /* Assessment lisitng function*/
    public function index(){

        if(!empty($_GET["client_id"])){
            $this->loadModel("ClientAssessments");

            $allClientAssessments = $this->ClientAssessments->find()->where(array("client_id"=>$_GET["client_id"]));
            $countClientAssessments = $allClientAssessments->count();

            if($countClientAssessments>0){

                $clientAssessmentIds = array();
                
                foreach($allClientAssessments as $clientAssessments){
                    $clientAssessmentIds[] = $clientAssessments["assessment_id"];
                }
                $allAssessments = $this->Assessments->find()->where(array("id IN"=>$clientAssessmentIds));
                
            }else{
                $allAssessments = array();
                
            }
        }else{
            $allAssessments = $this->Assessments->find()->contain(array("ClientResponses"=>function($q){
                $q->select([
                    'ClientResponses.assessment_id',
                    'total' => $q->func()->count('ClientResponses.assessment_id')
               ])
               ->group(['ClientResponses.assessment_id']);
           
               return $q;
            }));

        }

        


        $this->set(compact("allAssessments"));

        $this->loadModel("Clients");
        $allClients = $this->Clients->find()->select(array("id","client_name"))->order(array("client_name"=>"asc"));
        $this->set(compact("allClients"));
       
           
    }
	/* Assessment Add function*/
	public function addAssessment(){

        $userType = $this->Auth->user("role_id");

        if($userType==1 || $userType==3){
            $this->loadModel("Assessments");
            if($this->request->is("post")){
                $data = $this->request->getData();

                $destination = realpath("../webroot/img/assessments_images/")."/";

                require_once(ROOT . DS . 'vendor' . DS . 'resize' . DS . 'Resize.php');
                $image = new ImageResize();

                if(!empty($data["photo"]["name"])){
                    $fileName = time()."-".$_FILES["photo"]["name"];
                    move_uploaded_file($_FILES["photo"]["tmp_name"],$destination.$fileName);
                    $image->resize('../webroot/img/assessments_images/'. $fileName, '../webroot/img/assessments_images/medium/' . $fileName, 'aspect_fit', 128, 128, 0, 0, 0, 0);

                    $data["assessment_image"] =  $fileName;
                }
                $data["valid_from"] = date("Y-m-d",strtotime($data["valid_from"]));
                $data["valid_to"] = date("Y-m-d",strtotime($data["valid_to"]));

                if(!empty($data["disabled"])){
                    $data["disabled"] = 1;
                }else{
                    $data["disabled"] = 0;
                }

                $assessmentEntity = $this->Assessments->newEntity();
                $assessmentEntity = $this->Assessments->patchEntity($assessmentEntity,$data);
                $this->Assessments->save($assessmentEntity);

                $this->Flash->success(__("Assessment is saved successfully !"));
                $this->redirect(array("action"=>"index"));

            }
        }else{
            $this->Flash->error(__("You are not authorized to view this."));
            $this->redirect(array("action"=>"index"));
        }


        
    }

    /*Edit Assessment Function*/
    public function editAssessment($assessmentId){

        $userType = $this->Auth->user("role_id");

        if($userType==1 || $userType==3){
            $this->loadModel("Assessments");
            $assessmentId = convert_uudecode(base64_decode($assessmentId));

            $assessmentEntity = $this->Assessments->get($assessmentId);
            $this->set(compact("assessmentEntity"));

            if($this->request->is("post")){
                $data = $this->request->getData();

                $destination = realpath("../webroot/img/assessments_images/")."/";
                require_once(ROOT . DS . 'vendor' . DS . 'resize' . DS . 'Resize.php');
                $image = new ImageResize();

                if(!empty($data["photo"]["name"])){
                    $fileName = time()."-".$_FILES["photo"]["name"];
                    move_uploaded_file($_FILES["photo"]["tmp_name"],$destination.$fileName);
                    $image->resize('../webroot/img/assessments_images/'. $fileName, '../webroot/img/assessments_images/medium/' . $fileName, 'aspect_fit', 128, 128, 0, 0, 0, 0);


                    $data["assessment_image"] =  $fileName;
                }
                $data["valid_from"] = date("Y-m-d",strtotime($data["valid_from"]));
                $data["valid_to"] = date("Y-m-d",strtotime($data["valid_to"]));

                if(!empty($data["disabled"])){
                    $data["disabled"] = 1;
                }else{
                    $data["disabled"] = 0;
                }

                
                $assessmentEntity = $this->Assessments->patchEntity($assessmentEntity,$data);
                $this->Assessments->save($assessmentEntity);

                $this->Flash->success(__("Assessment is saved successfully !"));
                $this->redirect(array("action"=>"index"));
            }        

        }else{
            $this->Flash->error(__("You are not authorized to view this."));
            $this->redirect(array("action"=>"index"));
        }
    }


    /* Assessment Details function*/

    public function assessmentDetails($assessmentId,$clientId){

        $userType = $this->Auth->user("role_id");

        if($userType==1 || $userType==2){
            $this->loadModel("Assessments");
            $assessmentId = convert_uudecode(base64_decode($assessmentId));
        
            $assessmentEntity = $this->Assessments->get($assessmentId);

            $clientId = convert_uudecode(base64_decode($clientId));

            $this->loadModel("ClientResponses");
            $allResponses = $this->ClientResponses->find()->where(array("assessment_id"=>$assessmentId,"client_id"=>$clientId))->contain(array("Clients"));

            $this->set(compact("assessmentEntity","allResponses"));
        }else{
            $this->Flash->error(__("You are not authorized to view this."));
            $this->redirect(array("action"=>"index"));
        }

    }

    /* Assessment Start function*/
    public function startAssessment($assessmentId,$clientId){
        $userType = $this->Auth->user("role_id");

        if($userType==1 || $userType==2){
            $this->loadModel("Assessments");
            $assessmentId = convert_uudecode(base64_decode($assessmentId));
    
            $clientId = convert_uudecode(base64_decode($clientId));
    
            $this->loadModel("Clients");
            $clientDetails = $this->Clients->get($clientId);
    
            $assessmentEntity = $this->Assessments->get($assessmentId);

            $this->loadModel("ClientAssessments");
            $getClientAssessmentDetails = $this->ClientAssessments->find()->where(array("client_id"=>$clientId,"assessment_id"=>$assessmentId))->first();
            $isFinished = $getClientAssessmentDetails["assessment_finished"];
            

            $this->set(compact("assessmentEntity","clientDetails"));
        }else{
            $this->Flash->error(__("You are not authorized to view this."));
            $this->redirect(array("action"=>"index"));
        }

        
    }

    public function uploadImage(){

    }
	public function getAssessments($clientId=NULL){
        $this->loadModel("ClientAssessments");

        if(!empty($clientId)){
            
            $allClientAssessments = $this->ClientAssessments->find()->where(array("client_id"=>$clientId));
            $countClientAssessments = $allClientAssessments->count();

            if($countClientAssessments>0){

                $clientAssessmentIds = array();
                
                foreach($allClientAssessments as $clientAssessments){
                    $clientAssessmentIds[] = $clientAssessments["assessment_id"];
                }

                if(!empty($_GET["keyword"])){
                    $conditions = array("id IN"=>$clientAssessmentIds,"assessment_title Like"=>"%".$_GET["keyword"]."%");
                }else{
                    $conditions = array("id IN"=>$clientAssessmentIds);
                }
                $allAssessments = $this->Assessments->find()->where($conditions);
                
            }else{
                $allAssessments = array();
            }

            $this->set(compact("clientId"));
        

        }else if(!empty($_GET["keyword"])){
            $keyword = $_GET["keyword"];
            $allAssessments = $this->Assessments->find()->where(array("assessment_title Like"=>"%".$keyword."%"));
        }else if(empty($_GET["keyword"])){
            
            $allAssessments = $this->Assessments->find();
        }else{
            $allAssessments = array();
        }

        
        $this->set(compact("allAssessments"));
        $this->render("assessment_result");
    }

    public function submitReview(){
        if($this->request->is("post")){
            $data = $this->request->getData();


            $url = $data["location"];
            $explodeUrl = explode("startAssessment/",$url);
            
            $parameters = $explodeUrl[1];
            $explodeParameters = explode("/",$parameters);
            $assessmentId = convert_uudecode(base64_decode($explodeParameters[0]));
            $clientId = convert_uudecode(base64_decode($explodeParameters[1]));


            if(!empty($data["responseId"])){
                $responseId = $data["responseId"];
            }

            $this->loadModel("ClientResponses");
            
            if(!empty($responseId)){
                $updateClientResponse = $this->ClientResponses->query();
                $updateClientResponse->update()->set(array("response_json"=>$data["surveyData"],"respondent_name"=>$data["respondName"]))->where(array("id"=>$responseId))->execute();
            }else{
                $clientReponseEntity = $this->ClientResponses->newEntity();
                $responseData["assessment_id"] = $assessmentId;
                $responseData["client_id"] = $clientId;
                $responseData["response_json"] = $data["surveyData"];
                $responseData["current_page"] = $data["currentPage"];
                $responseData["respondent_name"] = $data["respondName"];
                $responseData["added_by"] = $this->Auth->user("id");
                
                $clientReponseEntity = $this->ClientResponses->patchEntity($clientReponseEntity,$responseData);

                if($result = $this->ClientResponses->save($clientReponseEntity)){
                    $responseId = $result->id;
                }             
            }
        
            if($data["finished_status"]==1){
                $this->loadModel("ClientAssessments");

                $updateClientAssessment = $this->ClientAssessments->query();
                $updateClientAssessment->update()->set(array("assessment_finished"=>1))->where(array("client_id"=>$clientId,"assessment_id"=>$assessmentId))->execute();
            }


            echo $responseId; die;
        }
    }
    public function editResponse($responseId){
        $responseId = convert_uudecode(base64_decode($responseId));

        $this->loadModel("ClientResponses");
        $clientReponseEntity = $this->ClientResponses->get($responseId);
        $savedState = $clientReponseEntity["response_json"];

        $this->loadModel("Clients");
        $getClient = $this->Clients->get($clientReponseEntity["client_id"]);

        $this->loadModel("Assessments");
        $assessmentEntity  = $this->Assessments->get($clientReponseEntity["assessment_id"]);


        $this->set(compact("clientReponseEntity","savedState","assessmentEntity","responseId","getClient"));

    }
    public function assessmentResponses($assessmentId){
        $assessmentId = convert_uudecode(base64_decode($assessmentId));

        $assessmentEntity = $this->Assessments->get($assessmentId);

        $this->loadModel("ClientResponses");
        $allResponses = $this->ClientResponses->find()->where(array("assessment_id"=>$assessmentId))->contain(array("Clients"));

        $this->set(compact("assessmentEntity","allResponses"));
    }

    public function getAnalysis($responseId){

        //$this->viewBuilder()->setLayout('');

        $responseId = convert_uudecode(base64_decode($responseId));


        $this->loadModel("ClientResponses");
        $responseDetails = $this->ClientResponses->get($responseId);

        $this->loadModel("Clients");
        $clientDetails = $this->Clients->get($responseDetails["client_id"]);

        $this->set(compact("responseDetails","clientDetails"));

        $responseJson = json_decode($responseDetails["response_json"]);


        $this->loadModel("Assessments");
        $assessmentEntity = $this->Assessments->get($responseDetails["assessment_id"]);
        
        $filtred = array();

        for($i=1;$i<=19;$i++){

            $averageofFirstAS_IS = '';
            $averageofFirstTO_BE = '';

            foreach($responseJson as $key => $value){
                
                if(preg_match('/rating'.$i.'.\d/',$key)){
                    
                    $filteredAS_IS[$i][] = $value->AS_IS;

                    $filteredTO_BE[$i][] = $value->TO_BE;
                }
            }
            
            
            
            if(!empty($filteredAS_IS[$i]) && array_key_exists($i,$filteredAS_IS)){
                $filteredAS_IS[$i] = array_filter($filteredAS_IS[$i]);
                $averageofFirstAS_IS = array_sum($filteredAS_IS[$i])/count($filteredAS_IS[$i]);
                $averageAS_ISArray[] = $averageofFirstAS_IS;
            }else{
                $averageAS_ISArray[$i] = "null";
            }
            
            if(!empty($filteredTO_BE[$i]) && array_key_exists($i,$filteredTO_BE)){
                $filteredTO_BE[$i] = array_filter($filteredTO_BE[$i]);
                $averageofFirstTO_BE = array_sum($filteredTO_BE[$i])/count($filteredTO_BE[$i]);
                $averageTO_BEArray[] = $averageofFirstTO_BE;
            }else{
                $averageTO_BEArray[$i] = "null";
            }
            

        }
        //prs($averageAS_ISArray);
        //pry($averageTO_BEArray);
        

        $asisString = '[';
        $tobeString = '[';

        foreach($averageAS_ISArray as $asIs){
            if(!is_nan($asIs)){
                $asisString .=$asIs.",";
            }else{
                $asisString .= "null,";
            }
        }
        

        foreach($averageTO_BEArray as $toBe){
            if(!is_nan($toBe)){
                $tobeString .=$toBe.",";
            }else{
                $tobeString .= "null,";
            }
        }
       

        $asisString = rtrim($asisString,",");
        
        $tobeString = rtrim($tobeString,",");

        $asisString .= ']';

        $tobeString .= ']';

        $this->set(compact("assessmentEntity","asisString","tobeString"));

    }
    public function checkAssessment($assessmentId){
        

        $assessmentEntity = $this->Assessments->get($assessmentId);

        $this->loadModel("ClientResponses");
        $allResponses = $this->ClientResponses->find()->where(array("assessment_id"=>$assessmentId))->contain(array("Clients"))->count();
        echo $allResponses; die;
    }
    public function deleteAssessment($assessmentId){
        
        //$this->loadModel("ClientResponses");
        //$allResponses = $this->ClientResponses->deleteAll(["assessment_id"=>$assessmentId]);

        $assessmentEntity = $this->Assessments->get($assessmentId);
        $this->Assessments->delete($assessmentEntity);

       
        echo "success"; die;
    }
    public function deleteResponse($responseId){
        $responseId = convert_uudecode(base64_decode($responseId));

        $this->loadModel("ClientResponses");
        $clientReponseEntity = $this->ClientResponses->get($responseId);
        $this->ClientResponses->delete($clientReponseEntity);

        $this->Flash->success(__("Response is deleted successfully !"));
        $this->redirect(array("action"=>"index"));
    }

    public function downloadJson($responseId){

        $this->viewBuilder()->setLayout('');

        $responseId = convert_uudecode(base64_decode($responseId));

        $this->loadModel("ClientResponses");
        $clientReponseEntity = $this->ClientResponses->find()->where(array("ClientResponses.id"=>$responseId))->contain(array("Clients"))->first();

        $fileName = "Response-".$clientReponseEntity["client"]["client_name"]."-".date("Ymd",strtotime($clientReponseEntity["date_added"]));

        $json = $clientReponseEntity["response_json"];

        header('Content-disposition: attachment; filename='.$fileName.'.json');
        header('Content-type: application/json');

        echo( $json);

    }

}