<?php

declare(strict_types=1);

namespace smysloff\phpmvc;

use smysloff\phpmvc\db\Database;

/**
 * Class Application
 *
 * @author Alexander Smyslov <smyslov@selby.su>
 * @package smysloff\phpmvc
 */
class Application
{
    /**
     * @var string
     */
    public static string $ROOT_DIR;

    /**
     * @var string
     */
    public string $layout = 'main';

    /**
     * @var string
     */
    public string $userClass;

    /**
     * @var Router
     */
    public Router $router;

    /**
     * @var Request
     */
    public Request $request;

    /**
     * @var Response
     */
    public Response $response;

    /**
     * @var Session
     */
    public Session $session;

    /**
     * @var Database
     */
    public Database $db;

    /**
     * @var UserModel|null
     */
    public ?UserModel $user = null;

    /**
     * @var View
     */
    public View $view;

    /**
     * @var Application
     */
    public static Application $app;

    /**
     * @var Controller|null
     */
    public ?Controller $controller = null;

    /**
     * Application constructor
     *
     * @param string $rootDir
     * @param array $config
     */
    public function __construct(string $rootDir, array $config)
    {
        $this->userClass = $config['userClass'];
        self::$ROOT_DIR = $rootDir;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config['db']);
        $this->view = new View();

        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        }
    }

    public function run(): void
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView('error', [
                'exception' => $e
            ]);
        }
    }

    /**
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * @param Controller $controller
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    /**
     * @param UserModel $user
     */
    public function login(UserModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
    }

    public function logout(): void
    {
        $this->user = null;
        $this->session->remove('user');
    }

    /**
     * @return bool
     */
    public static function isGuest(): bool
    {
        return !self::$app->user;
    }
}
