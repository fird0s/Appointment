<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Simple Appointment App">
    <meta name="author" content="Iclick Media">
    
    <style>
    body{padding-top:40px;padding-bottom:40px;background-color:#eee}.form-signin{max-width:330px;padding:15px;margin:0 auto}.form-signin .checkbox,.form-signin .form-signin-heading{margin-bottom:10px}.form-signin .checkbox{font-weight:400}.form-signin .form-control{position:relative;height:auto;-webkit-box-sizing:border-box;box-sizing:border-box;padding:10px;font-size:16px}.form-signin .form-control:focus{z-index:2}.form-signin input[type=email]{margin-bottom:-1px;border-bottom-right-radius:0;border-bottom-left-radius:0}.form-signin input[type=password]{margin-bottom:10px;border-top-left-radius:0;border-top-right-radius:0}
    </style>
    <title>Login</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?php echo base_url()?>static/css/bootstrap.min.css"  type="text/css">
  </head>

  <body>
    <div class="container">
      <?php echo form_open('', array('class' => 'form-signin')); ?>
       <?php if($this->session->flashdata('err_msg')):?>
         <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Error! </strong> <?php echo $this->session->flashdata('err_msg');?>
          </div>
       <?php endif?>
        <h2 class="form-signin-heading">Please sign in</h2>
          <input type="text" name="email" class="form-control" placeholder="Email address" required autofocus>
          <input type="password"  name="password" class="form-control" placeholder="Password" required>
          <div class="checkbox">
            <a href="#">forgot password?</>
          </div>
          <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Sign in</button>
      </form>
    </div> 

   </body>
</html>
