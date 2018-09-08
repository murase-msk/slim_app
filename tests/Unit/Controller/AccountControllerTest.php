<?php
/**
 * Created by PhpStorm.
 * User: masaki
 * Date: 2018/09/08
 * Time: 21:42
 */

namespace Tests\Unit\Controller;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;
use Slim\Http\Uri;
use Slim\Http\Headers;
use PHPUnit\Framework\TestCase;

class AccountControllerTest extends TestCase
{
    public function testFirstTest(){
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' => 'GET',
                'REQUEST_URI' => '/',
//                'SERVER_NAME' => 'slim_app.test',
//                'HTTP_HOST' =>'slim_app.test',
//                'SERVER_PORT' => 80
            ]
        );

        $request = Request::createFromEnvironment($environment);
        $response = new Response();
        // Use the application settings
        $settings = require __DIR__ . '/../../../src/settings.php';
        // Instantiate the application
        $app = new App($settings);
        require __DIR__ . '/../../../src/dependencies.php';
//        require __DIR__ . '/../../../src/middleware.php';
        require __DIR__.'/../../../src/validation.php';
        require __DIR__ . '/../../../src/routes.php';
        // Process the application
        $response = $app->process($request, $response);

        $this->assertEquals(200, $response->getStatusCode());
//        $this->assertEquals('test', $response->getBody());
    }
}