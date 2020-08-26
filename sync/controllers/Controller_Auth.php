<?php

    final class Controller_Auth extends Controller
    {
        private $synchronizer;

        public function __construct()
        {
            $this->model = new Model_Auth();
            $this->synchronizer = new ConcreteJSONSyncManager();
            parent::__construct();
        }

        
        public function login()
        {
            if ( isset($_POST['submit']) )
            {
                $possible_errors = [
                    'credentials' => 'Invalid login or password!'
                ];

                $credentials = [
                    'login'    => !empty($_POST['login']) ? $_POST['login'] : "",
                    'password' => !empty($_POST['password']) ? $_POST['password'] : ""
                ];
                $login = addslashes(trim($credentials['login']));
                $user = $this->model->get_data( $login );

                if ( !empty($user) && password_verify($credentials['password'], $user['password'])) 
                {
                    $_SESSION['user_login'] = $user['login'];
                    $_SESSION['user_id'] = $user['id'];
                    


                    header("Location: /main/index");
                }
                else
                {
                    $data = ['errors' => $possible_errors ];
                    $this->view->render('main', 'template', $data);
                }
            }
            else
            {
                Router::redirect_home();
            }

        }


        public function register()
        {
            if ( isset($_POST['submit']) )
            {
                $errors = array();
                $possible_errors = [
                    'login'    => 'Login field must be at least 8 characters length!',
                    'email'    => 'Email field must be valid email address!',
                    'password' => 'Password field must be at least 8 characters length and contain at least one uppercase letter, one lowercase letter and one number',
                    'name'     => 'Name cannot be empty!',
                    'surname'  => 'Surname cannot be empty!',
                    'user'     => 'This user is already registered!'
                ];

                $credentials = [
                    'login'    => !empty($_POST['login']) ? $_POST['login'] : '',
                    'email'    => !empty($_POST['email']) ? $_POST['email'] : '',
                    'password' => !empty($_POST['password']) ? $_POST['password'] : '',
                    'name'     => !empty($_POST['name']) ? $_POST['name'] : '',
                    'surname'  => !empty($_POST['surname']) ? $_POST['surname'] : ''
                ];

                $regex = [
                    'login'    => '/^[a-z0-9]{8,}$/',
                    'email'    => '/[a-z]+@[a-z]+\.[a-z]+/',
                    'password' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',
                    'name'     => '/[A-Za-z]+/',
                    'surname'  => '/[A-Za-z]+/'
                ];
                
                foreach ( $credentials as $key => $value )
                {
                    if ( !preg_match($regex[$key], $value) )
                    {
                        $errors[$key] = $possible_errors[$key];
                    }
                }

                if ( count( $this->model->get_data( addslashes($credentials['login'])) ) > 0 )
                {
                    $errors['user'] = $possible_errors['user'];
                }

                $credentials['password'] = password_hash($credentials['password'], PASSWORD_DEFAULT);
                if ( empty($errors) && $this->model->put_data( $credentials ) ) 
                {
                    $_SESSION['user_id'] = $this->model->get_data( $credentials['login'] )['id'];
                    $_SESSION['user_login'] = $credentials['login'];

                    $data = [
                        'type' => 'new_user',
                        'data' => $credentials,
                        'user_id' => $_SESSION['user_id']
                    ];
                    $this->synchronize_data( $data );
                    header('Location: /main/index');
                }
                else
                {
                    $errors[] = 'Could not create record!';
                    $data = ['errors' => $errors];
                    $this->view->render('reg_form', 'template', $data);
                }
            }
            else
            {
                $this->view->render('reg_form', 'template');
            }
        }

        public function logout()
        {
            session_destroy();
            Router::redirect_home();
        }


        public function synchronize_data( $data )
        {
            ConcreteJSONSyncManager::synchronize( $data, $this->model->create_token() );
        }
    }