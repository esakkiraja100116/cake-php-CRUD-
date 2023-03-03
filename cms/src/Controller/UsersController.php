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

      public function auth(){
         // echo "auth happening";
         $session = $this->request->getSession();
         $check = $session->read('login');
         if($check != "success"){
            return $this->redirect(
               ['controller' => 'Users', 'action' => 'sign_in']
            );
         }
      }

      public function add(){
         $this->auth();
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
         $this->auth();
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
         $this->auth();
         $connection = ConnectionManager::get('default');
         $result = $connection->delete('users_temp', ['id' => $id]);
         $fetch_all = $connection->execute('SELECT * FROM users_temp')->fetchAll('assoc');
         $this->set("results",$fetch_all);
         $session = $this->request->getSession();
         $session->write("deleted",TRUE);
      }

      // checking for admin login
      public function signIn(){
         if($this->request->is('post')){
            $username = $this->request->getData('username');
            $password = $this->request->getData('password');
            $connection = ConnectionManager::get('default');
            $results = $connection->execute('SELECT * FROM admin WHERE username= :u AND password = :p', ['u' => $username,'p' => $password])->fetchAll('assoc');
            if(!$results){
               $this->set('login', -1);
            }else{
               $db_username = $results[0]['username'];
               $db_password = $results[0]['password'];
               $session = $this->request->getSession();
               $session->delete("register");
               if ($username == $db_username && $password === $db_password) {
                  $session->write(['login'=>'success','admin_id' => $results[0]['id']]);

                  return $this->redirect(
                        ['controller' => 'Pages', 'action' => 'display', 'read']
                  );
               } else {
                  // var_dump($db_password);
                  $this->set('login', -1);
               }
            }

         }
      }

      public function register(){
         if($this->request->is('post')){
            $username = $this->request->getData('username');
            $password = $this->request->getData('password');
            $c_password = $this->request->getData('confirm_password');

            if($password == $c_password){
               $connection = ConnectionManager::get('default');
               $check_dup = $connection->execute('SELECT * FROM admin WHERE username= :u AND password = :p', ['u' => $username,'p' => $password])->fetchAll('assoc');
               
               if($check_dup){
                  $this->set("register",-2);
               }else{
                  $result = $connection->insert('admin', [
                     
                     'username' => $username,
                     'password' => $password,
                  ], ['created' => 'datetime']);
                  if ($result) {
                     $session = $this->request->getSession();
                     $session->write('register', 'success');
                     return $this->redirect(
                           ['controller' => 'Users','action' => 'sign_in']
                     );
                  }
               }
            }else{
               $this->set("register",-1);
            }
         }
      }

      public function aboutUs(){
         
      }

      public function profile(){
         $session = $this->request->getSession();
         $admin_id = $session->read("admin_id");
         $connection = ConnectionManager::get('default');

         if ($this->request->is('post')) {
            $username = $this->request->getData('username');
            $password = $this->request->getData('password');
            $result = $connection->update('admin', ['username' => $username,"password" => $password], ['id' => $admin_id]);
            if($result){
               $session->write("profile_update","success");
            }
         }
         
         $data = $connection->execute('SELECT * FROM admin WHERE id= :id', ['id' => $admin_id])->fetchAll('assoc');
         $this->set("id",$data[0]['id']);
         $this->set("username",$data[0]['username']);
         $this->set("password",$data[0]['password']);

      }

      public function logout(){
         //create session object
         $session = $this->request->getSession();
         //delete session data
         if ($session->write('login', 'failed')) {
            return $this->redirect(
                  ['controller' => 'Users', 'action' => 'sign_in']
            );
         }else{
            return $this->redirect(
               ['controller' => 'Users', 'action' => 'sign_in']
         );
         }
      }
   }
?>