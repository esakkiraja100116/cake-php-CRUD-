<main class="form-signin w-100 m-auto">
    <?php
        if (isset($_POST['username'])) {
            $session = $this->request->getSession();
            $check = $session->read('profile_update');
            if ($check == "success") {
                ?>
                    <div class="alert alert-primary" role="alert">
                    Updated successfully
                    </div>
                    <?php
            } else {
                ?>
            <div class="alert alert-danger" role="alert">
                    Error in database
                    </div>
            
                <?php
            }
        }

   echo $this->Form->create(NULL,array('url'=>'/users/profile/'));
   echo $this->Form->control('username',['id' => 'username','value' => $username,'lable' => 'form-control','required']);
   echo $this->Form->control('password',['value' => $password,'lable' => 'form-control','required']);
   echo $this->Form->button('update',['class' => 'w-100 btn mt-3 btn-lg btn-primary']);
   echo $this->Form->end();
?>
</main>