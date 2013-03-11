<?php

use JMS\Serializer\Exception\ValidationFailedException;

require_once(__DIR__ . '/../app/Bootstrap.php');

$bootstrap = new Bootstrap();
$container = $bootstrap->run();

$app = new Tonic\Application(array(
	'load' => array(__DIR__ . '/../src/C95/Domain/Service/Web/*.php')
));

$request = new Tonic\Request();

try {
    /** @var $resource \C95\Infrastructure\Resource */
	$resource = $app->getResource($request);

	$resource->setContainer($container);
    $resource->init();

	$response = $resource->exec();

    $resource->handleResponse($response);
} catch (Tonic\NotFoundException $e) {
	$response = new Tonic\Response(404, $e->getMessage());
} catch (Tonic\UnauthorizedException $e) {
	$response = new Tonic\Response(401, $e->getMessage());
	$response->wwwAuthenticate = 'Basic realm="My Realm"';
} catch (Tonic\Exception $e) {
	$response = new Tonic\Response($e->getCode(), $e->getMessage());
} catch(ValidationFailedException $e) {
    $violations = array();
    foreach($e->getConstraintViolationList() as $violation) {
        $violations[$violation->getPropertyPath()] = $violation->getMessage();
    }

    $response = new Tonic\Response(412, $resource->getContainer('serializer')->serialize($violations, 'json'));
} catch (\Exception $e) {
    $response = new Tonic\Response($e->getCode(), get_class($e) . ': '. $e->getMessage() . PHP_EOL . PHP_EOL. $e->getTraceAsString());
}

if(isset($_GET['debug'])) {
    $responseObject = json_decode($response->body);
    echo '<pre>' . json_encode($responseObject, JSON_PRETTY_PRINT) . '</pre>';
} else {
    $response->output();
}