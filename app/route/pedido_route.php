<?php
use App\Lib\Auth,
    App\Lib\Response,
    App\Validation\pedidoValidation,
    App\Middleware\AuthMiddleware;

$app->group('/pedido/', function () {
    $this->get('listar/{l}/{p}', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
                   ->write(
                     json_encode($this->model->pedido->listar($args['l'], $args['p']))
                   );
    });
    
    $this->get('obtener/{id}', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
                   ->write(
                     json_encode($this->model->pedido->obtener($args['id']))
                   );
    });
})->add(new AuthMiddleware($app));