<?php

    class Controller extends Router{

        public function view($name, $data = [])
        {
            $view_file = dirname(__DIR__) . '\\' . $this -> dirr['Views'] . '\\' . strtolower($name) . '.php';

            if (file_exists($view_file)) {
                extract($data);
                
                require $view_file;
            } else {
                $this -> set_error('Is not found view file!');
            }
        }

        public function model($name)
        {
            $view_file = dirname(__DIR__) . '\\' . $this -> dirr['Models'] . '\\' . strtolower($name) . '.php';

            if (file_exists($view_file)) {
                require $view_file;

                return new $name();
            } else {
                $this -> set_error('Is not found model file!');
            }
        }

    }

?>