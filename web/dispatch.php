<?php

require_once(__DIR__ . '/../app/Bootstrap.php');

$bootstrap = new Bootstrap();
$container = $bootstrap->run();

$app = new Tonic\Application(array(
	'load' => array('ws/*.php')
));

$request = new Tonic\Request();

try {
    /** @var $resource \C95\Infrastructure\Resource */
	$resource = $app->getResource($request);

	$resource->setContainer($container);
    $resource->init();

	$response = $resource->exec();
} catch (Tonic\NotFoundException $e) {
	$response = new Tonic\Response(404, $e->getMessage());
} catch (Tonic\UnauthorizedException $e) {
	$response = new Tonic\Response(401, $e->getMessage());
	$response->wwwAuthenticate = 'Basic realm="My Realm"';
} catch (Tonic\Exception $e) {
	$response = new Tonic\Response($e->getCode(), $e->getMessage());
}

$response->output();

