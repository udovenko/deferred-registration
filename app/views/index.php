<div class="spacer20"></div>
<div class="center jumbotron">
  <h1><small>Welcome to the</small> Test page</h1>
  <br/>
  <?php if(!isset($user) || $user->isNew()) { ?>
    <a href="users/create" class="btn btn-large btn-primary">Registration</a>
  <?php } ?>
</div>

