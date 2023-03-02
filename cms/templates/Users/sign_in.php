<main class="form-signin w-100 m-auto">
    <?php
    if (isset($_POST['username'])) {
        if ($login == -1) {
            ?>

                <div class="alert alert-danger" role="alert">
                Username or Password is wrong
                </div>

            <?php
        }
    }

   echo $this->Form->create(NULL,array('url'=>'/users/sign_in'));
   echo $this->Form->control('username',['id' => 'username','value' => '','lable' => 'form-control']);
   echo $this->Form->control('password',['value' => '','lable' => 'form-control']);
   echo $this->Form->button('Login',['class' => 'btn btn-primary mt-2']);
   echo $this->Form->end();
?>
</main>