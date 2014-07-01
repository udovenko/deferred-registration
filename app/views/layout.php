<!DOCTYPE html>
<html>
    <head>
        <title>Test application</title>
        <link type="text/css" rel="stylesheet" href="/css/bootstrap.min.css" />
        <link type="text/css" rel="stylesheet" href="/css/common.css" />
    </head>
    <body>
        <header class="navbar navbar-fixed-top navbar-inverse">
            <div class="container">
                <div class="navbar-header">
                    <a href="/" id="logo" class="navbar-brand">Test page</a>
                </div>
                <nav>
                <ul class="nav navbar-nav pull-right">
                  <li><a href="/">Home</a></li>
                  
                  <?php if (isset($user) && !$user->isNew()) { ?>
                    <li><a href="/users/show">Profile</a></li>
                    <li><a href="/sessions/destroy">Logout</a></li>
                  <?php } else { ?>
                    
                    <li><a href="/sessions/create">Login</a></li>
                  <?php } ?>
                </ul>
              </nav>
            </div>
        </header>
        <div class="container">
            <?php echo $content; ?>
        </div>
    </body>
</html>