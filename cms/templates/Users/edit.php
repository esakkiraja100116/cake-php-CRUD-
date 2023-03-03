<?php
//     session_start();
//    print_r($_SESSION);
   if(isset($_POST['username'])){
    if($result){
        ?>
        <div class="alert alert-primary" role="alert">
        User updated successfully
        </div>
        <?php
    }else{
        
        ?>
 <div class="alert alert-danger" role="alert">
        Error in database
        </div>

    <?php
    }
    ?>
    
<?php
   }
   echo $this->Form->create(NULL,array('url'=>'/users/edit/'.$id));
   echo $this->Form->control('username',['id' => 'username','value' => $username],'required');
   echo $this->Form->control('password',['placeholder' => 'Enter the new password','value' => '','required']);
   echo $this->Form->button('Update');
   echo $this->Form->button('Reset the Form', ['type' => 'reset','class' => 'reset_form']);
   echo $this->Form->end();
?>