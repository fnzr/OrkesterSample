<?php
declare(strict_types=1);


use Orkester\Manager;
use OrkesterSample\Modules\Controllers\MainController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;


return function (App $app) {
    $app->options('/{routes:.+}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/',MainController::class . ':route');

    $app->get('/{controller}[/{action}[/{id}]]', function($req, $res, $args){
        //have to manually set controller name if uppercase in more than first letter
        $name = ucfirst($args['controller']);
        Manager::getData()->id = $args['id'] ?? null;
        $controller = "\App\Modules\Controllers\\{$name}Controller";
        if (class_exists($controller)) {
            $instance = new $controller();
            return $instance->route($req, $res, $args);
        }
        else {
            $instance = new \Orkester\MVC\MController();
            $instance->setRequestResponse($req, $res);
            return $instance->renderException(new Exception('', 404));
        }
    });


    $app->any('/{params:.*}', function($req, $res) {
        $instance = new \Orkester\MVC\MController();
        $instance->setRequestResponse($req, $res);
        return $instance->renderException(new Exception('', 404));
    });

    // Cors
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res, $args) {
        $handler = $this->notFoundHandler; // handle using the default Slim page not found handler
        return $handler($req, $res, $args);
    });

};
