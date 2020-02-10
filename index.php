<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require 'vendor/autoload.php';

$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$app->addRoutingMiddleware();
// Add Error Handling Middleware
$app->addErrorMiddleware(true, false, false);

$app->get('/slim/hello/{Franck}', function (Request $request, Response $response , array $args) {
    $name = $args['Franck'];
    $response->getBody()->write('Hello'.' '.$name);
    return $response;
});

$app->get('/slim/users', function (Request $request, Response $response , array $args) {

$users = [
    ['name' => 'Franck', 'age' => 31],
    ['name' => 'Vincent', 'age' => 29],
    ['name' => 'Thibaut', 'age' => 22]
];

$payload = json_encode($users);
$newResponse = $response->withHeader('Content-type', 'application/json');
$newResponse->getBody()
            ->write($payload);

return $newResponse;

});       

$app->post('/slim/users', function (Request $request, Response $response , array $args) {
$jsonBody = $request->getParsedBody();
$name = $jsonBody['name'];
$age = $jsonBody['age'];

$data = [ 'msg' => 'ok', 'name' => $name, 'age' => $age];
$payload = json_encode($data);

$newResponse = $response->withHeader('Content-type', 'application/json');
$newResponse->getBody()
            ->write($payload);


return $newResponse;

});

$app->run();