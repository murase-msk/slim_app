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

// コンテンツ.
$app->get('/content1', 'Content1' . ':index')->setName('content1');

// 認証.
// TODO: 未完成
$app->post('/auth', 'AccountController' . ':auth')->setName('auth');
// 登録.
$app->post('/registerAccount', 'AccountController' . ':registerAccount')
    ->setName('registerAccount')
    ->add(new \DavidePastore\Slim\Validation\Validation($validators));

//$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
//    // Sample log message
//    $this->logger->info("Slim-Skeleton '/' route");
//
//    // Render index view
//    return $this->view->render($response, 'index.html', [
//        'name' => $args['name']
//    ]);
//});

//$app->get('/','src\BaseController\SampleApp:aaa')->setName('aaa');


