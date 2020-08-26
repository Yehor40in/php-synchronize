<?php

    final class Model_Auth extends Model
    {

        public function get_user( $login )
        {
            $statement = $this->connection->prepare('SELECT * FROM user WHERE login = :login');
            $statement->bindParam(':login', $login);

            if ( $statement->execute() )
            {
                return $statement->fetch(PDO::FETCH_ASSOC);
            }
            return [];
        }
        

        public function get_data( $login = null )
        {
            if ( isset($login) )
            {
                $statement = $this->connection->prepare('SELECT * FROM user WHERE login = :login');
                $statement->bindParam(':login', $login);

                if ( $statement->execute() )
                {
                    if ( $statement->rowCount() != 0 )
                    {
                        return $statement->fetch(PDO::FETCH_ASSOC);
                    }
                }
            }
            return [];
        }


        public function put_data( $data )
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

        
    }