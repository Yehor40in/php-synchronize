<?php

    final class Router {

        static $home = '/main/index';


        static function route()
        {
            $uri = explode('/', $_SERVER['REQUEST_URI']);

            if ( !empty($uri[1]) && !empty($uri[2]) )
            {
                $controller_name = ucwords(strtolower($uri[1]));
                $action_name = ucwords(strtolower($uri[2]));

                $model_path = "models/Model_$controller_name.php";
                $controller_path = "controllers/Controller_$controller_name.php";

                if ( file_exists($model_path) )
                {
                    require_once $model_path;
                }

                if ( file_exists($controller_path) )
                {
                    require_once $controller_path;
                }

                $controller_class = "Controller_$controller_name";

                if ( class_exists($controller_class) )
                {
                    $controller = new $controller_class();

                    if ( method_exists($controller_class, $action_name) )
                    {
                        $controller->$action_name();
                    }
                    else
                    {
                        self::not_found_response();
                    }
                }
                else
                {
                    self::readirect_home();
                }
            }
            else
            {
                self::redirect_home();
            }
        }


        static function not_found_response()
        {
            echo "NOT FOUND :(";
        }


        static function redirect_home()
        {
            $h = "Location:" . self::$home;
            header($h);
        }
    }

?>