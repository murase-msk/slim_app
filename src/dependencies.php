<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
// $container['renderer'] = function ($c) {
//     $settings = $c->get('settings')['renderer'];
//     return new Slim\Views\PhpRenderer($settings['template_path']);
// };

// セッション
$container['session'] = function ($c) {
    //return new \SlimSession\Helper;
    return new \src\SessionHelper;
};

// フラッシュメッセージ.
$container['flash'] = function ($c) {
    return new \Slim\Flash\Messages();
};

// アカウント認証.
$container['accountAuth'] = function ($c) {
    // TODO: 未完成
    $accountAuth = new \src\Middleware\Auth\AccountAuth();
    return $accountAuth;
};

// CSRF
$container['csrf'] = function ($c) {
    $guard = new \Slim\Csrf\Guard;
    // CSRFチェック失敗時.
//    $guard->setFailureCallable(function ($request, $response, $next) {
//        $request = $request->withAttribute("csrf_status", false);
//        return $next($request, $response);
//    });
    return $guard;
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// twig
$container['view'] = function ($container) {
    $settings = $container->get('settings');

    $cachePath = $settings['env'] === 'dev' ? false : $settings['cache']['cache_path'];
    $view = new \Slim\Views\Twig($settings['renderer']['template_path'], [
        'cache' => $cachePath
    ]);

    // Instantiate and add Slim specific extension
    $a = $container->get('request')->getUri()->getBasePath();
    $basePath = rtrim(str_ireplace('index.php', '', $a), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container->get('router'), $basePath));

    return $view;
};

//$container['db'] = function ($container) {
//    $db = $container['settings']['db'];
//    $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'], $db['user'], $db['pass']);
//    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
//    return $pdo;
//};
$container['db_psql'] = function ($container) {
    $db = $container['settings']['db_psql'];
    $pdo = new PDO('pgsql:host=' . $db['host'] . ';dbname=' . $db['dbname'], $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};


//$container['sampleModel'] = function ($container) {
//    $sampleModel = new \src\Model\SampleModel($container['db']);
//    return $sampleModel;
//};

$container['SampleApp'] = function ($container) {
    $view = $container->get('view');
    $session = $container->get('session');
    return new \src\Controller\SampleApp($view, $session);
};

$container['Content1'] = function ($container) {
    $view = $container->get('view');
    $session = $container->get('session');
    return new \src\Controller\Content1($view, $session);
};

$container['accountModel'] = function ($container) {
    $accountModel = new \src\Model\AccountModel($container['db_psql']);
    return $accountModel;
};

$container['AccountController'] = function ($container) {
    $view = $container->get('view');
    $accountModel = $container->get('accountModel');
    $router = $container->get('router');
    $csrf = $container->get('csrf');
    $flash = $container->get('flash');
    $session = $container->get('session');
    return new \src\Controller\AccountController($view, $accountModel, $router, $csrf, $flash, $session);
};
