<div class="spacer20"></div>
<h1 class="text-center text-primary">Dear <?php echo $user->getName(); ?>! <small>welcome to your profile</small></h1>
<div class="spacer30"></div>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <p>Your account was created <strong><?php echo date("d.m.Y H:i", $user->getCreatedAt()); ?></strong>. You'relogged in here with your E-mail <strong><?php echo $user->getEmail(); ?></strong> 
        and secret password. Please enjoy your stay!</p>
    </div>
</div>