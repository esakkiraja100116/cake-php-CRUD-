<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Auth\DefaultPasswordHasher;

   class UsersController extends AppController{
      
      public function index(){
         $users = TableRegistry::get('users');
         $query = $users->find();
         $this->set('results',$query);
      }

      public function add(){
         if($this->request->is('post')){
            $username = $this->request->getData('username');
            $hashPswdObj = new DefaultPasswordHasher;
            $password = $hashPswdObj->hash($this->request->getData('password'));
            
            $connection = ConnectionManager::get('default');
            $result = $connection->insert('users_temp', [
               'email' => $username,
               'password' => $password,
           ], ['created' => 'datetime']);
          
           
           $this->set('result',$result);
          
         }
      }
      public function edit($id){
         $connection = ConnectionManager::get('default');

         if($this->request->is('post')){
            $username = $this->request->getData('username');
            $hashPswdObj = new DefaultPasswordHasher;
            $password = $hashPswdObj->hash($this->request->getData('password'));

            
            $result = $connection->update('users_temp', ['email' => $username,"password" => $password], ['id' => $id]);
            $this->set('result',$result);
         }

         $updated_value = $connection->execute('SELECT * FROM users_temp WHERE id = :id', ['id' => $id])->fetchAll('assoc');
         $this->set("id",$updated_value[0]['id']);
         $this->set("username",$updated_value[0]['email']);
         $this->set("password",$updated_value[0]['password']);
      }

      
      public function delete($id){
         $connection = ConnectionManager::get('default');
         $result = $connection->delete('users_temp', ['id' => $id]);
         $fetch_all = $connection->execute('SELECT * FROM users_temp')->fetchAll('assoc');
         $this->set("results",$fetch_all);
         session_start();
         $_SESSION['deleted'] = TRUE;
      }

      // checking for admin login
      public function signIn(){
         if($this->request->is('post')){
            $username = $this->request->getData('username');
            $password = $this->request->getData('password');
            $connection = ConnectionManager::get('default');
            $results = $connection->execute('SELECT * FROM `admin`')->fetchAll('assoc');
            $db_username = $results[0]['username'];
            $db_password = $results[0]['password'];

            if($username == $db_username && $password === $db_password){
               return $this->redirect(
               ['controller' => 'Pages', 'action' => 'display', 'read']
            );
            }else{
                  var_dump($db_password);
               $this->set('login',-1);
            }

         }
      }

      public function logout(){
         return $this->redirect(
            ['controller' => 'Users', 'action' => 'sign_in']
         );
         }
   }
?>