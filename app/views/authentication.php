<h1 class="text-center">Authentication</h1>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <form role="form" method="post">
            <?php if(!empty($errors)) { ?>
                <div id="error_explanation">
                    <div class="alert alert-danger">
                      Authentication error.
                    </div>
                    <ul>
                    <?php foreach ($errors as $error) { ?>
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
                <label for="inputPassword">Password</label>
                <input type="password" name="password" class="form-control"id="inputPassword" placeholder="Enter your password">
            </div>
            <input type="submit" class="btn btn-primary pull-right" value="Login"></input>
        </form>
    </div>
</div> 