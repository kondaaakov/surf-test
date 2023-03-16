<?php

namespace classes;

class Router {

    private ArrayHelper $arrayHelper;
    private User $user;

    public function __construct() {
        $this->arrayHelper = new ArrayHelper();
        $this->user        = new User();
    }

    public function route(string $default) {
        $uriArr = array_values(array_filter(explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]), fn($it) => boolval($it))) ;

        $currentAction = $this->arrayHelper->arrayGet($uriArr, 0, $default);

        $actionPath    = ACT_PATH . $currentAction;

        if(is_dir($actionPath)) {
            $fileName    = $this->arrayHelper->arrayGet($uriArr, 1, $currentAction);
            $actionPath .= '/' . $fileName;
        }

        $filePath = $actionPath . '.php';
        if (!file_exists($filePath) || !$this->checkPermissions($currentAction)) {
            $this->abort(404, 'Страница не найдена');
        }

        require($filePath);
    }

    private function checkPermissions(string $action): bool {
        $accessesRoutes = PERMISSIONS[$this->user->getGroupSession()];
        return in_array($action, $accessesRoutes);
    }

    public function abort($code, $message) {
        http_response_code($code);
        require(LAYOUTS_PATH . 'error.layout.php');
        exit;
    }

    public function view($page, $data) {
        // Включение буферизации вывода
        ob_start();
        // Импортирует переменные из массива в текущую таблицу символов
        extract($data);

        $file = PG_PATH . $page . '.page.php';
        if (is_file($file)) require $file;
        else $this->abort(404, 'Страница не найдена');


        // Возвращает содержимое буфера вывода
        $result = ob_get_contents();
        // Очистить (стереть) буфер вывода и отключить буферизацию вывода
        ob_end_clean();

        return $result;
    }

    public function redirect($route = '') {
        if (isset($route) && !empty($route)) {
            header("Location: /$route", true, 200);
        } else {
            header("Location: /", true, 200);
        }
    }
}