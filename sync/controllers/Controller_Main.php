<?php

    final class Controller_Main extends Controller
    {
        private $synchronizer;

        public function __construct()
        {
            $this->model = new Model_Main();
            parent::__construct();
        }


        public function index()
        {
            $data = [ 'posts' => $this->model->get_data() ];
            $this->view->render('main', 'template', $data);
        }


        public function add()
        {
            if ( isset($_POST['submit']) )
            {
                $data = [
                    'title' => htmlspecialchars(addslashes($_POST['title'])),
                    'content' =>  htmlspecialchars(addslashes($_POST['content'])),
                    'user_id' => $_SESSION['user_id']
                ];

                if ( $this->model->put_data($data) )
                {
                    $data = [
                        'type' => 'new_post',
                        'user_login' => $_SESSION['user_login'],
                        'data' => $data
                    ];
                    $this->synchronize_data( $data );
                    Router::redirect_home();
                }
                else
                {
                    $data = ['post_error' => 'Could not create post!'];
                    $this->view->render('main', 'template', $data);
                }
            }
        }

        private function synchronize_data( $data )
        {
            ConcreteJSONSyncManager::synchronize( $data, $this->model->create_token() );
        }

    }

?>