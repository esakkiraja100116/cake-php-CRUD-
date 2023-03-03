

<main class="form-signin w-100 m-auto">
    <?php
    if (isset($_POST['username'])) {
        if ($register == -1) {

            echo "<div class='alert alert-danger' role='alert'>
            password is not matched
            </div>";

        }elseif($register == -2){
            echo "<div class='alert alert-primary' role='alert'>
            User already exits!
            </div>";
        }
    }

   echo $this->Form->create(NULL,array('url'=>'/users/register'));
   echo $this->Form->control('username',['id' => 'username','value' => '','lable' => 'form-control','required']);
   echo $this->Form->control('password',['value' => '','lable' => 'form-control','required']);
   echo $this->Form->control('confirm_password',['type' => 'password' ,'value' => '','lable' => 'form-control','required']);
   echo $this->Form->button('Register',['class' => 'w-100 btn mt-3 btn-lg btn-primary']);
   echo $this->Form->end();

   echo "Have an account ? <a class='mt-3' href='" .$this->Url->build('/')."' > Sign in </a>";
?>
</main>
