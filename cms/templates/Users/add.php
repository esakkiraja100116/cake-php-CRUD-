<?php
//     session_start();
//    print_r($_SESSION);
   if(isset($_POST['username'])){
    if($result){
        ?>
        <div class="alert alert-primary" role="alert">
        User added successfully
        </div>
        <?php
    }else{
        
        ?>
        <div class="alert alert-danger" role="alert">
            User added successfully
        </div>

    <?php
    }
   }
   echo $this->Form->create(NULL,array('url'=>'/users/add'));
   echo $this->Form->control('username',['id' => 'username','value' => '','required']);
   echo $this->Form->control('password',['value' => '','required']);
   echo $this->Form->button('Submit');
   echo $this->Form->button('Reset the Form', ['type' => 'reset','class' => 'reset_form']);
   echo $this->Form->end();
?>

<!-- <p>testing</p> -->