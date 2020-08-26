<?php

    class View
    {
        public function render($content, $template, $data = null)
        {
            if ( is_array($data) )
            {
                extract($data);
            }
            require_once "templates/$template.php";       
        }
    }

?>