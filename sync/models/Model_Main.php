<?php

    final class Model_Main extends Model
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


        public function get_data( $param = null )
        {
            $sql = 'SELECT * FROM post ORDER BY id DESC';
            $result = $this->connection->query($sql);

            if ( $result->rowCount() > 0 )
            {
                $data = [];
                while ( $row = $result->fetch(PDO::FETCH_ASSOC) )
                {
                    $data[] = $row;
                }
                return $data;
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

?>