<?php

    abstract class Model
    {
        public $connection;
        
        public function __construct()
        {
            // $host = $config['db_host'];
            // $dbname = $config['db_name'];
            // $user = $config['db_user'];
            // $password = $config['password'];
            
            $this->connection = new PDO("mysql:host=localhost;dbname=test1", 'root', '');
        }

        
        public function create_token()
        {
            $statement = $this->connection->prepare('INSERT INTO token (value, user_id, expiration_date) VALUES (:value, :user_id, :expiration_date)');

            $str = md5($_SESSION['user_login']);
            $token = sha1($str);

            $now = date('Y-m-d h:i:s');
            $expiry = date('Y-m-d h:i:s', strtotime('+3 minutes',strtotime($now)));

            $statement->bindParam(':value', $token);
            $statement->bindParam(':user_id', $_SESSION['user_id']);
            $statement->bindParam(':expiration_date', $expiry );

            if ( $statement->execute() )
            {
                return $token;
            }

            print_r($statement->errorInfo());
            return false;
        }


        public function verify_token( $user_id, $token )
        {
            $statement = $this->connection->prepare('SELECT * FROM token WHERE user_id = :user_id');
            $statement->bindParam(':user_id', $user_id);

            if ( $statement->execute() )
            {
                if ( $statement->rowCount() > 0 )
                {
                    $row = $statement->fetch(PDO::FETCH_ASSOC);

                    if ( $row['expiration_date'] > date('Y-m-d h:i:s') && $row['value'] == $token )
                    {
                        $this->connection->query('DELETE FROM token WHERE user_id = $user_id');
                        return true;
                    }
                }
            }

            print_r($statement->errorInfo());
            return false;
        }
    }

?>