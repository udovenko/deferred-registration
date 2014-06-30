<!DOCTYPE html>
<html>
  <head>
    <meta content='text/html; charset=UTF-8' http-equiv='Content-Type' />
  </head>
  <body>
    <h1>Dear <?php echo $user->getName(); ?>!</h1>
    <p>
      Thank you for registreng on our service.<br/><br/> 
      For further authentication please use</br>
      E-mail: <?php echo $user->getEmail(); ?></br>
      password: <?php echo $password; ?>
    </p>
    <p>
       To complete registration, please <a href="<?php echo $link; ?>">folow the link</a>.<br/>
       Please note that you should use same browser, as you used to begin registration. 
    </p>
    <p>Thanks for using our service!</p>
  </body>
</html>
