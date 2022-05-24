<?php 

    class Home extends Controller{

        public function index()
        {
            $data = array(
                'name' => 'Emre',
                'surname' => 'ünlü'
            );

            $this -> view('homepage', $data);
        }
    }

?>