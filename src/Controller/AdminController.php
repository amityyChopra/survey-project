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
use App\Auth\LegacyPasswordHasher;


/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3/en/controllers/pages-controller.html
 */
class AdminController extends AppController{

    function beforeFilter(\Cake\Event\Event $event) {
		parent::beforeFilter($event);
		$this->Auth->allow(array("login"));
		
		if(!empty($this->Auth->user())){
			$userLoggedIn = $this->Auth->user();
			$this->set(compact("userLoggedIn","sendOTP"));
		}
	}


    public function login(){
        
        $this->viewBuilder()->setLayout("");
		if(!empty($this->Auth->user())){
			return $this->redirect($this->Auth->redirectUrl());
	    }else{
		    if ($this->request->is('post')) {
                $user = $this->Auth->identify();
                $today = date("Y-m-d");
                $userValid = date("Y-m-d",strtotime($user["valid_upto"]));
                if ($user) {
                    if($userValid>=$today){
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
}
?>