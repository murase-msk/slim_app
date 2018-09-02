<?php



// Routes

// setName()で名前を割当ることで、PathFor(name,[index, value])でURLを生成できる

// トップページ.
$app->get('/', 'SampleApp' . ':index')->setName('index');

// ログイン・ログアウト.
$app->get('/signIn','AccountController' . ':signIn')->setName('signIn');
$app->get('/signUp','AccountController' . ':signUp')->setName('signUp');
$app->get('/logout','AccountController' . ':logout')->setName('logout');
//$app->get('/signUpTest','AccountController' . ':test')->setName('accountTest');

// コンテンツ1に新規登録.
$app->get('/content1/new', 'Content1' . ':new')->setName('content1New');
// コンテンツ1にコンテンツ登録.
$app->get('/content1/register', 'Content1' . ':register')->setName('content1Register');
// コンテンツ.
$app->get('/content1', 'Content1' . ':index')->setName('content1');


// 認証.
$app->post('/auth', 'AccountController' . ':auth')->setName('auth');
// 登録.
$app->post('/registerAccount', 'AccountController' . ':registerAccount')
    ->setName('registerAccount')
    ->add(new \DavidePastore\Slim\Validation\Validation($validators));



$app->get('/noCsrfPage', function (Psr\Http\Message\ServerRequestInterface $request, Psr\Http\Message\ResponseInterface $response, array $args) {
    return $this->view->render($response, 'noCsrfPage.html.twig', []);
});
$app->post('/noCsrf', function (Psr\Http\Message\ServerRequestInterface $request, Psr\Http\Message\ResponseInterface $response, array $args) {
    return $this->view->fetchFromString('<p>Pushed button</p>', []);
});

$app->get('/csrfPage', function (Psr\Http\Message\ServerRequestInterface $request, Psr\Http\Message\ResponseInterface $response, array $args) {
    // CSRF用Key-Value生成.
    $csrfNameKey = $this->csrf->getTokenNameKey();
    $csrfValueKey = $this->csrf->getTokenValueKey();
    $csrfName = $request->getAttribute($csrfNameKey);
    $csrfValue = $request->getAttribute($csrfValueKey);

    return $this->view->render($response, 'csrfPage.html.twig', [
        'csrf' => [
            'keys' => [
                'name' => $csrfNameKey,
                'value' => $csrfValueKey
            ],
            'name' => $csrfName,
            'value' => $csrfValue
        ]
    ]);
});
$app->post('/csrf', function (Psr\Http\Message\ServerRequestInterface $request, Psr\Http\Message\ResponseInterface $response, array $args) {
    $str = $this->view->fetchFromString('<p>Pushed button</p>', []);
    return $response->getBody()->write($str);
});

//$app->get('/[{name}]', function (Psr\Http\Message\ServerRequestInterface $request, Psr\Http\Message\ResponseInterface $response, array $args) {
//    // Sample log message
//    $this->logger->info("Slim-Skeleton '/' route");
//
//    // Render index view
//    return $this->view->render($response, 'index.html', [
//        'name' => $args['name']
//    ]);
//});



//$app->get('/','src\BaseController\SampleApp:aaa')->setName('aaa');


