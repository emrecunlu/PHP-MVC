<?php 

    class Router {

        public $uri;

        private $routes = array();

        public $dirr = array(
            'Controllers' => 'App\Controllers',
            'Models' => 'App\Models',
            'Views' => 'App\Views'
        );

        private $patterns = array(
            ':id' => '([0-9]+)',
            ':name' => '([a-zA-Z]+)',
            ':email' => '[a-zA-Z.-_]+\@\w{2,}.\.\w{2,}',
            ':username' => '([a-zA-Z0-9-_.]+)'
        );

        public function __construct($config = [])
        {
            $basename = basename($_SERVER['SCRIPT_NAME']);
            $dirname = dirname($_SERVER['SCRIPT_NAME']);

            $this -> uri = str_replace([$basename, $dirname], '', $_SERVER['REQUEST_URI']);
        }

        public function add($uri, $controller, $method = ['GET', 'POST'])
        {
            $this -> routes[$uri] = array (
                'uri' => str_replace(array_keys($this -> patterns), array_values($this -> patterns), $uri),
                'controller' => $controller['controller'],
                'method' => $controller['method'],
                'request' => $method
            );

            return $this;
        }

        protected function set_error($error)
        {
            echo '<div style="width: 100%; padding: 50px 30px; background: #ff726f; font-size: 2rem; color: #fff; font-weight: 500; box-sizing: border-box;">' . $error . '</div>';

            exit;
        }

        public function exec($route, $params = array())
        {
            $controller_file = dirname(__DIR__) . '\\' . $this -> dirr['Controllers'] . '\\' . strtolower($route['controller']) . '.php';

            if (file_exists($controller_file)) {
                include $controller_file;

                call_user_func_array(array(
                    new $route['controller'],
                    $route['method']
                ), $params);
            } else {
                $this -> set_error('Is not found controller file!');
            }
        }

        public function run()
        {
            $is_matched = false;

            foreach ($this -> routes as $route) {
                if (preg_match('@^' . $route['uri'] . '$@', $this -> uri, $params)) {
                    if (in_array($_SERVER['REQUEST_METHOD'], $route['request'])) {
                        $is_matched = true;

                        array_shift($params);
                        $this -> exec($route, $params);
                    }
                }
            }

            if (!$is_matched && in_array('404', array_column($this -> routes, 'uri'))) {
                $this -> exec($this -> routes['404']);
            }
        }

    }

?>