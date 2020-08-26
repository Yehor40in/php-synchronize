<?php

    final class Model_Sync extends Model
    {        
        
        public function create_user( $data )
        {
            if ( !empty($data) && is_array($data) )
            {
                extract($data);
                $statement = $this->connection->prepare('INSERT INTO user (login, email, password, name, surname) VALUES (:login, :email, :password, :name, :surname)');
                
                $statement->bindParam(':login', $login);
                $statement->bindParam(':email', $email);
                $statement->bindParam(':password', $password);
                $statement->bindParam(':name', $name);
                $statement->bindParam(':surname', $surname);
                
                if ( $statement->execute() )
                {
                    return true;
                }
            }

            print_r($statement->errorInfo());
            return false;
        }


        public function get_user_by_login ( $login )
        {
            $statement = $this->connection->prepare('SELECT * FROM user WHERE login = :login');
            $statement->bindParam(':login', $login);

            if ( $statement->execute() )
            {
                return $statement->fetch(PDO::FETCH_ASSOC);
            }
            return [];
        }

        
        public function put_data( $data )
        {
            if ( !empty($data) && is_array($data) )
            {
                extract($data);
                $statement = $this->connection->prepare('INSERT INTO post (title, content, user_id) VALUES (:title, :content, :user_id)');
                
                $statement->bindParam(':title', $title);
                $statement->bindParam(':content', $content);
                $statement->bindParam(':user_id', $user_id);
                
                if ( $statement->execute() )
                {
                    return true;
                }
            }

            print_r($statement->errorInfo());
            return false;
        }
    }