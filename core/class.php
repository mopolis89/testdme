<?
class handbook
{
    // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
    // Коннект с базой
    // = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
    protected static function connect()
    {
        $autoDB = 'mopoliec_dme';
        $usernameAutoDB = 'mopoliec_dme';
        $passwordAutoDB = 'w*mi1aSF';

        try {
            $connect = new PDO('mysql:host=localhost;dbname=' . $autoDB, $usernameAutoDB, $passwordAutoDB);
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connect->setAttribute(PDO::ATTR_EMULATE_PREPARES,TRUE);
            $connect->exec('SET NAMES UTF8');
            return $connect;
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }

// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
// Получение пользователей для вывода на главной
// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =

    public static function getUserMain()
    {
        $usersGet=self::connect()->prepare('SELECT `id`,`fio`,`photo`,DATE_FORMAT(birthday,\'%d.%m.%Y\') AS birth FROM users ORDER BY fio ASC LIMIT 10');
        $usersGet->execute();
        $users = $usersGet->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }
// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
// Получение дополнительных пользователей для вывода на главной
// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
    public static function  seeMoreUser($start,$finish)
    {
        $usersGetMore=self::connect()->prepare('SELECT `id`,`fio`,`photo`,DATE_FORMAT(birthday,\'%d.%m.%Y\') AS birth FROM users ORDER BY fio ASC LIMIT :start,:finish');
        $usersGetMore->bindValue(':start', $start, PDO::PARAM_INT);
        $usersGetMore->bindValue(':finish', $finish, PDO::PARAM_INT);
        $usersGetMore->execute();
        $arUsersMore = $usersGetMore->fetchAll(PDO::FETCH_ASSOC);
        return $arUsersMore;
    }

// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
// Получение уникальные года рождения
// = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = = =
    public static function getYear()
    {
        $yearGet=self::connect()->prepare('SELECT DISTINCT YEAR(birthday) AS birth FROM users ORDER BY birthday ASC');
        $yearGet->execute();
        $arYear = $yearGet->fetchAll(PDO::FETCH_ASSOC);
        return $arYear;
    }

    public static function getYearUsers($year)
    {
        $usersGet=self::connect()->prepare('SELECT `id`,`fio`,`photo`,DATE_FORMAT(birthday,\'%d.%m.%Y\') AS birthday FROM users WHERE YEAR(birthday)=:yearFilter ORDER BY fio ASC');
        $usersGet->bindValue('yearFilter', $year, PDO::PARAM_INT);
        $usersGet->execute();
        $users = $usersGet->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }


    public static function searchUsers($search)
    {
        $search="%".$search."%";
        $usersGet=self::connect()->prepare('SELECT `id`,`fio`,`photo`,DATE_FORMAT(birthday,\'%d.%m.%Y\') AS birthday FROM users WHERE  fio LIKE :search ORDER BY fio ASC');
        $usersGet->bindValue(':search', $search, PDO::PARAM_STR);
        $usersGet->execute();
        $users = $usersGet->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }
    public static function userData($id)
    {
        $usersGet=self::connect()->prepare('SELECT `id`,`fio`,`photo_medium`,`photo_large`,`phone`,`email` FROM users WHERE id=:id');
        $usersGet->bindValue(':id', $id, PDO::PARAM_INT);
        $usersGet->execute();
        $users = $usersGet->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }

    public static function getAccess($login,$pass)
    {
        $userGet=self::connect()->prepare('SELECT `id`,`user_id` FROM auth WHERE login=:login AND password=:pass');
        $userGet->bindValue(':login', $login, PDO::PARAM_STR);
        $userGet->bindValue(':pass', $pass, PDO::PARAM_STR);
        $userGet->execute();
        $user = $userGet->fetchAll(PDO::FETCH_ASSOC);
        return $user;
    }

    public static function hashSet($hash,$id)
    {
        $hashSet=self::connect()->prepare('UPDATE auth SET hash_user=:hash_user WHERE user_id=:id');
        $hashSet->bindValue(':hash_user', $hash, PDO::PARAM_STR);
        $hashSet->bindValue(':id',$id,PDO::PARAM_INT);
        $hashSet->execute();
    }
    public static function hashGet($user_id)
    {
        $hashGet=self::connect()->prepare('SELECT `hash_user` FROM auth WHERE user_id=:user_id');
        $hashGet->bindValue(':user_id',$user_id,PDO::PARAM_INT);
        $hashGet->execute();
        $hash = $hashGet->fetchAll(PDO::FETCH_ASSOC);
        return $hash;
    }

    public static function getUserMainDesc()
    {
        $usersGet=self::connect()->prepare('SELECT `id`,`fio`,`photo`,DATE_FORMAT(birthday,\'%d.%m.%Y\') AS birth FROM users ORDER BY fio DESC LIMIT 10');
        $usersGet->execute();
        $users = $usersGet->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }

    public static function getUserMainAscDate()
    {
        $usersGet=self::connect()->prepare('SELECT `id`,`fio`,`photo`,DATE_FORMAT(birthday,\'%d.%m.%Y\') AS birth FROM users ORDER BY birthday ASC LIMIT 10');
        $usersGet->execute();
        $users = $usersGet->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }

    public static function getUserMainDescDate()
    {
        $usersGet=self::connect()->prepare('SELECT `id`,`fio`,`photo`,DATE_FORMAT(birthday,\'%d.%m.%Y\') AS birth FROM users ORDER BY birthday DESC LIMIT 10');
        $usersGet->execute();
        $users = $usersGet->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }

    public static function  seeMoreUserDesc($start,$finish)
    {
        $usersGetMore=self::connect()->prepare('SELECT `id`,`fio`,`photo`,DATE_FORMAT(birthday,\'%d.%m.%Y\') AS birth FROM users ORDER BY fio DESC LIMIT :start,:finish');
        $usersGetMore->bindValue(':start', $start, PDO::PARAM_INT);
        $usersGetMore->bindValue(':finish', $finish, PDO::PARAM_INT);
        $usersGetMore->execute();
        $arUsersMore = $usersGetMore->fetchAll(PDO::FETCH_ASSOC);
        return $arUsersMore;
    }
    public static function  seeMoreUserAscDate($start,$finish)
    {
        $usersGetMore=self::connect()->prepare('SELECT `id`,`fio`,`photo`,DATE_FORMAT(birthday,\'%d.%m.%Y\') AS birth FROM users ORDER BY birthday ASC LIMIT :start,:finish');
        $usersGetMore->bindValue(':start', $start, PDO::PARAM_INT);
        $usersGetMore->bindValue(':finish', $finish, PDO::PARAM_INT);
        $usersGetMore->execute();
        $arUsersMore = $usersGetMore->fetchAll(PDO::FETCH_ASSOC);
        return $arUsersMore;
    }

    public static function  seeMoreUserDescDate($start,$finish)
    {
        $usersGetMore=self::connect()->prepare('SELECT `id`,`fio`,`photo`,DATE_FORMAT(birthday,\'%d.%m.%Y\') AS birth FROM users ORDER BY birthday DESC LIMIT :start,:finish');
        $usersGetMore->bindValue(':start', $start, PDO::PARAM_INT);
        $usersGetMore->bindValue(':finish', $finish, PDO::PARAM_INT);
        $usersGetMore->execute();
        $arUsersMore = $usersGetMore->fetchAll(PDO::FETCH_ASSOC);
        return $arUsersMore;
    }

}


class Router
{
    protected $routes = [];

    protected $requestUri;

    protected $requestMethod;

    protected $requestHandler;

    protected $params = [];

    protected $placeholders = [
        ':seg' => '([^\/]+)',
        ':num'  => '([0-9]+)',
        ':any'  => '(.+)'
    ];


    public function __construct($uri, $method = 'GET')
    {
        $this->requestUri = $uri;
        $this->requestMethod = $method;
    }

    /**
     * Factory method construct Router from global vars.
     * @return Router
     */
    public static function fromGlobals()
    {
        $uri = $_SERVER['REQUEST_URI'];
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);
        return new static($uri, $_SERVER['REQUEST_METHOD']);
    }
    /**
     * Current processed URI.
     * @return string
     */
    public function getRequestUri()
    {
        return $this->requestUri; // ?: '/';
    }

    /**
     * Request method.
     * @return string
     */
    public function getRequestMethod()
    {
        return $this->requestMethod;
    }

    /**
     * Get Request handler.
     * @return string|callable
     */
    public function getRequestHandler()
    {
        return $this->requestHandler;
    }

    /**
     * Set Request handler.
     * @param $handler string|callable
     */
    public function setRequestHandler($handler)
    {
        $this->requestHandler = $handler;
    }

    /**
     * Request wildcard params.
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Add route rule.
     *
     * @param string|array $route A URI route string or array
     * @param mixed $handler Any callable or string with controller classname and action method like "ControllerClass@actionMethod"
     */
    public function add($route, $handler = null)
    {
        if ($handler !== null && !is_array($route)) {
            $route = array($route => $handler);
        }
        $this->routes = array_merge($this->routes, $route);
        return $this;
    }
    /**
     * Process requested URI.
     * @return bool
     */
    public function isFound()
    {
        $uri = $this->getRequestUri();

        // if URI equals to route
        if (isset($this->routes[$uri])) {
            $this->requestHandler = $this->routes[$uri];
            return true;
        }

        $find    = array_keys($this->placeholders);
        $replace = array_values($this->placeholders);
        foreach ($this->routes as $route => $handler) {
            // Replace wildcards by regex
            if (strpos($route, ':') !== false) {
                $route = str_replace($find, $replace, $route);
            }
            // Route rule matched
            if (preg_match('#^' . $route . '$#', $uri, $matches)) {
                $this->requestHandler = $handler;
                $this->params = array_slice($matches, 1);
                return true;
            }
        }

        return false;
    }
    /**
     * Execute Request Handler.
     *
     * @param string|callable $handler
     * @param array $params
     * @return mixed
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function executeHandler($handler = null, $params = array())
    {
        if ($handler === null) {
            throw new \InvalidArgumentException(
                'Request handler not setted out. Please check '.__CLASS__.'::isFound() first'
            );
        }

        // execute action in callable
        if (is_callable($handler)) {
            return call_user_func_array($handler, $params);
        }
        // execute action in controllers
        if (strpos($handler, '@')) {
            $ca = explode('@', $handler);
            $controllerName = $ca[0];
            $action = $ca[1];
            if (class_exists($controllerName)) {
                $controller = new $controllerName();
            } else {
                throw new \RuntimeException("Controller class '{$controllerName}' not found");
            }
            if (!method_exists($controller, $action)) {
                throw new \RuntimeException("Method '{$controllerName}::{$action}' not found");
            }

            return call_user_func_array(array($controller, $action), $params);
        }
    }
}




