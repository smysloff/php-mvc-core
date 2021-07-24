<?php

declare(strict_types=1);

namespace smysloff\phpmvc;

/**
 * Class View
 *
 * @author Alexander Smyslov <smyslov@selby.su>
 * @package smysloff\phpmvc
 */
class View
{
    /**
     * @var string
     */
    public string $title = '';

    /**
     * @param string $view
     * @param array $params
     * @return string
     */
    public function renderView(string $view, array $params = []): string
    {
        $viewContent = $this->renderOnlyView($view, $params);
        $layoutContent = $this->layoutContent();
        return str_replace('{{ content }}', $viewContent, $layoutContent);
    }

    /**
     * @param string $viewContent
     * @return string
     */
    public function renderContent(string $viewContent): string
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{ content }}', $viewContent, $layoutContent);
    }

    /**
     * @return string|false
     */
    protected function layoutContent(): string|false
    {
        $layout = Application::$app->layout;
        if (Application::$app->controller) {
            $layout = Application::$app->controller->layout;
        }
        ob_start();
        include_once Application::$ROOT_DIR . '/views/layouts/' . $layout . '.php';
        return ob_get_clean();
    }

    /**
     * @param string $view
     * @param array $params
     * @return string|false
     */
    protected function renderOnlyView(string $view, array $params): string|false
    {
        extract($params);
        ob_start();
        include_once Application::$ROOT_DIR . '/views/' . $view . '.php';
        return ob_get_clean();
    }
}
