<?php

    final class Controller_Sync extends Controller
    {

        public function __construct()
        {
            $this->model = new Model_Sync();
            parent::__construct();
        }


        public function sync()
        {
            $data = json_decode( file_get_contents('php://input'), true );

            switch ( $data['type'] )
            {
                case 'new_post':
                    $token = getallheaders()['Token'];
                    $user = $this->model->get_user_by_login( $data['user_login'] );

                    $json = [ 
                        'user_id' => $data['data']['user_id'],
                        'token'   => $token
                    ];
                    if ( ConcreteJSONSyncManager::verify_token( $json ) && !empty($user))
                    {
                        $data['data']['user_id'] = $user['id'];
                        $this->model->put_data( $data['data'] );
                    }
                break;
                case 'new_user':
                    $token = getallheaders()['Token'];

                    $json = [ 
                        'user_id' => $data['user_id'],
                        'token'   => $token
                    ];
                    if ( ConcreteJSONSyncManager::verify_token( $json ) )
                    {
                        $this->model->create_user( $data['data'] );
                    }
                break;
            }
        }


        public function verify()
        {
            $data = json_decode( file_get_contents('php://input'), true );

            if ( $this->model->verify_token( $data['user_id'], $data['token']) )
            {
                header('Content-type:application/json');
                echo json_encode([
                    'success' => '1'
                ]);
            }
            else
            {
                header('Content-type:application/json');
                echo json_encode([
                    'fail' => '1'
                ]);
            }
        }

    }