<html>
    <head>
        <title>
            TEST | YEHOR SOROKIN
        </title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    </head>
    
    <body>
        <div class="container-fullwidth bg-dark h-100">
            <header class="navbar navbar-expand-md navbar-dark bg-dark">
                <a href="/main/index" class="navbar-brand">Service №1</a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#collapsable_navbar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="collapsable_navbar">
                    <div class="navbar-nav">
                        <a href="http://test2.local/index.php" target="_blank" class="nav-item nav-link">Go to service №2</a>
                        <a href="/auth/register" class="nav-item nav-link">Sign up</a>
                    </div>
                    <?php
                        if ( isset($_SESSION['user_login']) )
                        {
                            echo "<a class='ml-auto text-white' href='/auth/logout'>". $_SESSION['user_login'] ."</a>";
                        }
                        else
                        {
                            $html = <<<EOT
                                <form action="/auth/login" method="POST" class="form-inline ml-auto">
                                    <div class="form-group mr-2">
                                        <input type="text" class="form-control" id="login_field" placeholder="Login" name="login"required>
                                    </div>
                                    <div class="form-group mr-2">
                                        <input type="password" class="form-control" id="password_field" placeholder="Password" name="password" required>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-outline-light">Sign in</button>
                                </form>
                            EOT;
                            echo $html;
                        }
                    ?>
                </div>
            </header>

            <?php 
                if ( !empty($errors) )
                {
                    foreach ( $errors as $error => $message )
                    {
                        $html = <<<EOT
                        <div class="alert alert-danger">
                            <strong>Error!</strong> $message
                        </div>
                        EOT;
                        echo $html;
                    }
                }

                require_once "views/$content.php";
            ?>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" crossorigin="anonymous"></script>
    </body>
</html>