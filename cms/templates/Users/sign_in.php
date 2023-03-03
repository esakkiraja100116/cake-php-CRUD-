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

    $session = $this->request->getSession();
    $check = $session->read('register');
    if($check == "success"){
        ?>
            <div class="alert alert-primary" role="alert">
            Registration is success. You can Signin now with your account!
            </div>
            <?php
    }

   echo $this->Form->create(NULL,array('url'=>'/users/sign_in'));
   echo $this->Form->control('username',['id' => 'username','value' => '','lable' => 'form-control','required']);
   echo $this->Form->control('password',['value' => '','lable' => 'form-control','required']);
   echo $this->Form->button('Login',['class' => 'w-100 btn mt-3 btn-lg btn-primary']);
   echo $this->Form->end();

   echo "Don't have account ? <a class='mt-3' href='" .$this->Url->build('/register')."' > Register </a>";
?>
</main>