<?php
/**
 * Created by PhpStorm.
 * User: masaki
 * Date: 2018/09/16
 * Time: 15:22
 */

namespace Tests\Functional;


class E2EBaseTest extends \PHPUnit\Framework\TestCase
{
    protected static $app;
    protected static $settings;

    /**
     * @test
     */
    public function dummy()
    {
        $this->markTestSkipped();
    }
//    protected static function initApp()
//    {
//        session_start();
//        // Instantiate the app
//        $settings = require __DIR__ . '/../../src/settings.php';
//        self::$app = new \Slim\App($settings);
//        self::$settings = $settings['settings'];
//
//        // Set up dependencies
//        require __DIR__ . '/../../src/dependencies.php';
//        // Register middleware
//        require __DIR__ . '/../../src/middleware.php';
//        // validation.
//        require __DIR__.'/../../src/validation.php';
//        // Register routes
//        require __DIR__ . '/../../src/routes.php';
//        // Run app
//        self::$app->run();
//    }
}