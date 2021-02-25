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
use Office365_Client;
use App\Auth\LegacyPasswordHasher;


/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3/en/controllers/pages-controller.html
 */
class UsersController extends AppController
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
        
        $usersActive = "Active";
        $this->set(compact("usersActive"));
		
		if(!empty($this->Auth->user())){
			$userLoggedIn = $this->Auth->user();
            $this->set(compact("userLoggedIn"));
            
            $userType = $this->Auth->user("role_id");

            if($userType!=1){
                $this->Flash->error(__("You are not authorized to view this."));
                $this->redirect(array("controller"=>"Assessments","action"=>"index"));
            }
		}
	}

    /* Login Screen Function */
    public function login(){
        
        $this->viewBuilder()->setLayout("login");
		if(!empty($this->Auth->user())){
			return $this->redirect($this->Auth->redirectUrl());
	    }else{
		    if ($this->request->is('post')) {
                $user = $this->Auth->identify();
                $today = date("Y-m-d");
                
                if ($user) {
                    if($user["valid_upto"]>=$today){
                        $this->Auth->setUser($user);
                        $userLoggedIn = $this->Auth->user();
                        $this->set(compact("userLoggedIn"));
                        $this->redirect(array("controller"=>"Assessments","action"=>"index"));
                    }else{
                        $this->Flash->error(__('Your login is disabled. Please contact admin.'));
                        return $this->redirect(['action' => 'login']);
                    }
                }else{
                    $this->Flash->error(__('Invalid username or password, try again'));
                }
		    }else{
				
			}
        }
    }
	
	public function surveyCheck(){
		
    }
    
    public function index(){

        $conditions = array();
        if(!empty($_GET["keyword"])){
            $conditions[] = array("OR"=>array(array("first_name LIKE"=>"%".$_GET["keyword"]."%"),array("last_name LIKE"=>"%".$_GET["keyword"]."%"),array("email LIKE"=>"%".$_GET["keyword"]."%")));
        }
        if(!empty($_GET["role_id"])){
            $conditions[] = array("role_id"=>$_GET["role_id"]);
        }
        if(!empty($conditions)){
            $allUsers = $this->Users->find()->where($conditions)->contain(array("UserProfile"));
        }else{
            $allUsers = $this->Users->find()->contain(array("UserProfile"));
        }

        
        $this->set(compact("allUsers"));
    }
    public function addUser(){
        if($this->request->is("post")){
            $data = $this->request->getData();
            $destination = realpath("../webroot/img/user_image/")."/";

            require_once(ROOT . DS . 'vendor' . DS . 'resize' . DS . 'Resize.php');
            $image = new ImageResize();

            if(!empty($data["photo"]["name"])){
                $fileName = time()."-".$_FILES["photo"]["name"];
                move_uploaded_file($_FILES["photo"]["tmp_name"],$destination.$fileName);
                
                $image->resize('../webroot/img/user_image/'. $fileName, '../webroot/img/user_image/medium/' . $fileName, 'aspect_fit', 128, 128, 0, 0, 0, 0);

				$data["profile_picture"] =  $fileName;
            }
            $data["valid_upto"] = date("Y-m-d",strtotime($data["valid_upto"]));

            $userEntity = $this->Users->newEntity();
            $userEntity = $this->Users->patchEntity($userEntity,$data);
            if($result = $this->Users->save($userEntity)){

                $userId = $result->id;
                $this->loadModel("UserProfile");
                $userProfileEntity = $this->UserProfile->newEntity();
                $data["user_id"] = $userId;
                $userProfileEntity = $this->UserProfile->patchEntity($userProfileEntity,$data);
                $this->UserProfile->save($userProfileEntity);
                
            }
            $this->Flash->success(__("User is saved successfully !"));
            $this->redirect(array("action"=>"index"));
        }
        
    }

    public function editUser($userId){

        $userId = convert_uudecode(base64_decode($userId));
        $userEntity = $this->Users->get($userId);

        $this->loadModel("UserProfile");
        if($this->UserProfile->exists(array("user_id"=>$userId))){
            $userProfile = $this->UserProfile->find()->where(array("user_id"=>$userId))->first();
            $userProfileEntity = $this->UserProfile->get($userProfile["id"]);
        }
        

        $this->set(compact("userEntity","userProfileEntity"));

        if($this->request->is("post")){
            $data = $this->request->getData();
            
            $destination = realpath("../webroot/img/user_image/")."/";

            require_once(ROOT . DS . 'vendor' . DS . 'resize' . DS . 'Resize.php');
            $image = new ImageResize();

            if(!empty($_FILES["photo"]["name"])){
                $fileName = time()."-".$_FILES["photo"]["name"];
                move_uploaded_file($_FILES["photo"]["tmp_name"],$destination.$fileName);
                
                $image->resize('../webroot/img/user_image/'. $fileName, '../webroot/img/user_image/medium/' . $fileName, 'aspect_fit', 128, 128, 0, 0, 0, 0);

				$data["profile_picture"] =  $fileName;
            }
            $data["valid_upto"] = date("Y-m-d",strtotime($data["valid_upto"]));

            if($data["disabled"]){
                $data["disabled"] = 1;
            }else{
                $data["disabled"] = 0;
            }
            
            $userEntity = $this->Users->patchEntity($userEntity,$data);
            if($result = $this->Users->save($userEntity)){

                
                //$userProfileEntity = $this->UserProfile->patchEntity($userProfileEntity,$data);
                //$this->UserProfile->save($userProfileEntity);
                
            }
            $this->Flash->success(__("User is saved successfully !"));
            $this->redirect(array("action"=>"index"));
        }
        
    }
    
    public function previewImage(){
        $destination = realpath("../webroot/img/temp_images/")."/";

        require_once(ROOT . DS . 'vendor' . DS . 'resize' . DS . 'Resize.php');
        $image = new ImageResize();
        $fileName = time()."-".$_FILES["file"]["name"];
        move_uploaded_file($_FILES["file"]["tmp_name"],$destination.$fileName);
        
        $image->resize('../webroot/img/temp_images/'. $fileName, '../webroot/img/temp_images/medium/' . $fileName, 'aspect_fit', 128, 128, 0, 0, 0, 0);

        $path[] = array(
            "path"=>HTTP_ROOT."img/temp_images/medium/".$fileName
        );

        echo json_encode($path); die;

    }
    public function logout(){
        return $this->redirect($this->Auth->logout());
    }

    public function removeImage($tableName,$recordId){
        $this->loadModel($tableName);

        $removeImageQuery = $this->$tableName->query();

        if($tableName=="Assessments"){
            $fieldName = "assessment_image";
            $tableId = "id";
        }
        if($tableName=="UserProfile"){
            $fieldName = "profile_picture";
            $tableId = "id";
        }
        if($tableName=="Clients"){
            $fieldName = "photo_logo";
            $tableId = "id";
        }
        

        $removeImageQuery->update()->set(array($fieldName=>""))->where(array($tableId=>$recordId))->execute();

        die;

    }

    public function myAuth(){

        $this->viewBuilder()->setLayout('');

        require_once(ROOT . DS . 'vendor' . DS . 'office365client' . DS . 'Office365_Client.php');
        $client = new Office365_Client();
        $forward_url = $client->createAuthUrl();
        if(isset($_GET['code'])) {
            //TODO: verfiy unquie key state to check CSRF attack

            $code = $_GET['code'];
            $client->setCode($code);
            //get tokens
            $client->fetchTokens();
            //echo '<br/><br/>';
            //print access tokens
            //print($client->toString());
            //echo '<br/><br/>';
           // die;


            //you can set the tokens into your own session
            $_SESSION['accesstoken'] = $client->getAccessToken();
            $_SESSION['refreshtoken'] = $client->getRefreshToken();

            $tenantId = "67e3ce4b-565c-4283-bfd9-57bd73f6f901";


            $guzzle = new \GuzzleHttp\Client();
            $url = 'https://login.microsoftonline.com/' . $tenantId . '/oauth2/v2.0/token';
            $token = json_decode($guzzle->post($url, [
                'form_params' => [
                    'client_id' => "09a0e7cf-83d1-4101-b8e3-f3aa3d0e6424",
                    'client_secret' => "Rw-py~R6tU8206Owd7E_MjA.v_gjNqKE79",
                    'scope' => 'https://graph.microsoft.com/.default',
                    'grant_type' => 'client_credentials',
                ],
            ])->getBody()->getContents());

            //pry($token);
            $accessToken = $token->access_token;

            $client->fetchJWT();

        

            //pry($client->getJwt()->toString()); 
            $userEmail = $client->getJwt()->getUniqueName();
            //$oId = $client->getJwt()->getAud();


            $curl = curl_init();    
            curl_setopt_array($curl, array( 

            CURLOPT_URL => "https://graph.microsoft.com/v1.0/me",     
            CURLOPT_RETURNTRANSFER => true, 
            CURLOPT_ENCODING => "", 
            CURLOPT_MAXREDIRS => 10, 
            CURLOPT_TIMEOUT => 30, 
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, 
            CURLOPT_CUSTOMREQUEST => "GET", 
            //CURLOPT_POSTFIELDS => "$data", 
            CURLOPT_HTTPHEADER => array( 
            "authorization: Bearer ".$accessToken
            ), 
            ));

            $response = curl_exec($curl); 
            //pry($response);


            //let's get user info
           
            //print the usr info
            //print($client->getJwt()->toString());

            $userEmail = $client->getJwt()->getUniqueName();

            $getUser = $this->Users->find()->where(array("email"=>$userEmail))->first();

            if(!empty($getUser)){

                $userId = $getUser["id"];
                
                

                $findUser = $this->Users->get($userId);
                
                $today = date("Y-m-d");
                $userValid = date("Y-m-d",strtotime($findUser["valid_upto"]));

                //echo $userValid; die;

                if($userValid>=$today){
                    $this->Auth->setUser($findUser);
                
                    return $this->redirect(array("controller"=>"Assessments",'action' => 'index'));
                }else{
                    $this->Flash->error(__('Your login is disabled. Please contact admin.'));
                    return $this->redirect(['action' => 'login']);
                }
                
            }else{

                $firstName = $client->getJwt()->getGivenName();
                $lastName = $client->getJwt()->getFamilyName();

                $explodeEmail = explode("@",$userEmail);
                $domainName = $explodeEmail[1];
                if($domainName=="adexpartners.com"){
                    $registerUser = $this->Users->newEntity();
                    $registerUserData["first_name"] = $firstName;
                    $registerUserData["last_name"] = $lastName;
                    $registerUserData["email"] = $userEmail;
                    $registerUserData["valid_upto"] = date("Y-m-d",strtotime("2040-01-01"));
                    $registerUserData["role_id"] = 2;
                    //pry($registerUserData);

                    $registerUser = $this->Users->patchEntity($registerUser,$registerUserData);
                    if($registerResult = $this->Users->save($registerUser)){
                        $this->Auth->setUser($registerResult);
                        return $this->redirect(array("controller"=>"Assessments",'action' => 'index'));
                    }else{
                        $this->redirect(array("action"=>"login"));
                    }
                    
                }else{
                    $this->Flash->error(__("You are not authorized register."));
                    $this->redirect(array("action"=>"login"));
                }
            }




            //put the user token info into sessions
            // $_SESSION['name'] = $client->getJwt()->getName();//full name of the user
            // $_SESSION['unique_name'] = $client->getJwt()->getUniqueName();//could be email or id from office365
            // $_SESSION['tid'] = $client->getJwt()->getTid();//tenant id





        }else{


            //click Continue button instead of redirecting to itself
            //print "<a class='login' href='$forward_url'>Connect Me!</a>";

            //you can also redirect automatically
           $this->redirect($forward_url );
        }

    }
    public function getUsers($roleId=NULL){

        if(!empty($roleId)){
            
            $allUsers = $this->Users->find()->where(array("role_id"=>$roleId));
            $countUsers = $allUsers->count();

            if($countUsers>0){
                if(!empty($_GET["keyword"])){
                    $conditions = array("role_id"=>$roleId,"OR"=>array(array("first_name Like"=>"%".$_GET["keyword"]."%"),array("last_name Like"=>"%".$_GET["keyword"]."%"),array("email Like"=>"%".$_GET["keyword"]."%")));
                }else{
                    $conditions = array("role_id"=>$roleId);
                }
                $allUsers = $this->Users->find()->where($conditions);

            }else{
                $allUsers = array();
            }

            $this->set(compact("clientId"));
        
        }else if(!empty($_GET["keyword"])){
            $keyword = $_GET["keyword"];
            $allUsers = $this->Users->find()->where(array("OR"=>array(array("first_name Like"=>"%".$_GET["keyword"]."%"),array("last_name Like"=>"%".$_GET["keyword"]."%"),array("email Like"=>"%".$_GET["keyword"]."%"))));
        }else if(empty($_GET["keyword"])){
            $allUsers = $this->Users->find();
        }else{
            $allUsers = array();
        }

        
        $this->set(compact("allUsers"));
        $this->render("users_result");
    }
}
