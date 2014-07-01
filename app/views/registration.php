<h1 class="text-center">Registration</h1>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <form role="form" method="post">
            <?php 
            $errors = $user->getErrors();
            if(!empty($errors)) { ?>
                <div id="error_explanation">
                    <div class="alert alert-danger">
                      The form contains errors.
                    </div>
                    <ul>
                    <?php foreach ($user->getErrors() as $error) { ?>
                      <li>* <?php echo $error; ?></li>
                    <?php } ?>
                    </ul>
                </div>
            <?php } ?>
            <div class="form-group">
                <label for="inputEmail">Email address</label>
                <input value = "<?php echo $user->getEmail(); ?>" type="email" name="email" class="form-control" id="inputEmail" placeholder="Enter your email">
            </div>
            <div class="form-group">
                <label for="inputName">Name</label>
                <input value = "<?php echo $user->getName(); ?>" type="text" name="name" class="form-control" id="inputName" placeholder="Enter your name">
            </div>
            <input type="submit" class="btn btn-primary pull-right" value="Register"></input>
        </form>
    </div>
</div>    

