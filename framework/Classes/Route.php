<?php

class Route {
    private static $routes = [];
    private static $fallbackRoute = null; // Para guardar la ruta de fallback

    // Método para registrar una ruta GET
    public static function get($path, $callback) {
        if ($path === '*') {
            self::$fallbackRoute = $callback; // Guardar la ruta de fallback
        } else {
            self::addRoute('GET', $path, $callback);
        }
    }

    // Método para registrar una ruta POST
    public static function post($path, $callback) {
        if ($path === '*') {
            self::$fallbackRoute = $callback; // Guardar la ruta de fallback
        } else {
            self::addRoute('POST', $path, $callback);
        }
    }

    // Método para añadir rutas a la lista
    private static function addRoute($method, $path, $callback) {
        self::$routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback
        ];
    }

    // Método para procesar las rutas registradas
    public static function run() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Verifica si la ruta es para servir archivos de assets
        if (strpos($requestUri, '/assets') === 0) {
            $filePath = ROOT . 'src' . $requestUri; // Ajusta la ruta a tus necesidades
            if (file_exists($filePath)) {
                // Establece el tipo de contenido según la extensión
                $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                switch ($extension) {
                    case 'css':
                        header('Content-Type: text/css');
                        break;
                    case 'js':
                        header('Content-Type: application/javascript');
                        break;
                    case 'jpg':
                    case 'jpeg':
                        header('Content-Type: image/jpeg');
                        break;
                    case 'png':
                        header('Content-Type: image/png');
                        break;
                    case 'gif':
                        header('Content-Type: image/gif');
                        break;
                    case 'svg':
                        header('Content-Type: image/svg+xml');
                        break;
                    // Agrega más tipos de contenido según lo necesites
                }
                readfile($filePath); // Envía el archivo al navegador
                exit; // Termina la ejecución
            } else {
                http_response_code(404);
                echo "Error: Archivo no encontrado.";
                exit; // Termina la ejecución
            }
        }

        // Procesa las rutas registradas
        foreach (self::$routes as $route) {
            if ($route['method'] === $requestMethod && $route['path'] === $requestUri) {
                // Si el método es POST, incluye el controlador correspondiente
                if ($requestMethod === 'POST') {
                    $controllerFile = ROOT_CONTROLLERS . $route['callback'] . '.php';
                    if (file_exists($controllerFile)) {
                        include $controllerFile; // Incluye el controlador
                    } else {
                        http_response_code(404);
                        echo "Error: El controlador no existe.";
                    }
                    return; // Termina la ejecución después de manejar el POST
                } else {
                    ob_start(); // Captura la salida para rutas GET

                    // Maneja las rutas GET normalmente
                    $filePath = ROOT_VIEWS . $route['callback'] . '.php';
                    if (file_exists($filePath)) {
                        include $filePath; // Incluye la vista
                    } else {
                        echo "Error: El archivo de vista no existe.";
                    }

                    $content = ob_get_clean(); // Captura el contenido
                    include ROOT . 'app.php'; // Incluye el layout
                    return;
                }
            }
        }

        // Si no se encuentra la ruta, utiliza la ruta de fallback si existe
        if (self::$fallbackRoute) {
            ob_start();
            $filePath = ROOT_VIEWS . self::$fallbackRoute . '.php';
            if (file_exists($filePath)) {
                include $filePath; // Incluye la vista de fallback
            } else {
                echo "Error: El archivo de fallback no existe.";
            }
            $content = ob_get_clean();
            include ROOT . 'app.php'; // Incluye el layout
            return;
        }

        // Si no se encuentra la ruta y no hay fallback
        http_response_code(404);
        echo "404 Not Found";
    }
}
