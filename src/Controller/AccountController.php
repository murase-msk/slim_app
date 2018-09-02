<?php
/**
 * Created by PhpStorm.
 * User: masaki
 * Date: 2018/08/13
 * Time: 17:21
 */

namespace src\Controller;

use src\Model\AccountModel;
//use Psr\Http\Message\ServerRequestInterface;
//use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\Request;

class AccountController extends BaseController
{
    private $view;
    private $accountModel;
    private $router;
    private $csrf;
    private $flash;

    function __construct(\Slim\Views\Twig $view, AccountModel $accountModel, \Slim\Router $router, \Slim\Csrf\Guard $csrf, \Slim\Flash\Messages $flash)
    {
        parent::__construct();
        $this->view = $view;
        $this->accountModel = $accountModel;
        $this->router = $router;
        $this->csrf = $csrf;
        $this->flash = $flash;
    }

    /**
     * ログインページ
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function signIn(
        /** @noinspection PhpUnusedParameterInspection */
        Request $request,
        /** @noinspection PhpUnusedParameterInspection */
        Response $response,
        /** @noinspection PhpUnusedParameterInspection */
        array $args)
    {
        // フラッシュメッセージ取得.
        $flash = $this->flash->getMessages();
        return $this->view->render($response, 'signIn.html.twig',
            [
                'csrf' => parent::generateCsrfKeyValue($request, $this->csrf)['csrf'],
                'flash' => $flash
            ]);
    }

    /**
     * 新規登録ページ
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function signUp(
        /** @noinspection PhpUnusedParameterInspection */
        Request $request,
        /** @noinspection PhpUnusedParameterInspection */
        Response $response,
        /** @noinspection PhpUnusedParameterInspection */
        array $args)

    {
        // フラッシュメッセージ取得.
        $flash = $this->flash->getMessages();
        return $this->view->render(
            $response,
            'signUp.html.twig',
            [
                'csrf' => parent::generateCsrfKeyValue($request, $this->csrf)['csrf'],
                'flash' => $flash
            ]
        );
    }

    /**
     * ログアウト
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function logout(
        /** @noinspection PhpUnusedParameterInspection */
        Request $request,
        /** @noinspection PhpUnusedParameterInspection */
        Response $response,
        /** @noinspection PhpUnusedParameterInspection */
        array $args)

    {
        // セッション削除して非ログイン状態を登録.
        $_SESSION = array();
        $_SESSION['isAuth'] = false;
        $_SESSION['account'] = '';
        // トップページへリダイレクト.
        $uri = $request->getUri()->withPath($this->router->pathFor('index'));
        return $response->withRedirect((string)$uri, 301);
    }


    /**
     * ログインの認証
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function auth(
        /** @noinspection PhpUnusedParameterInspection */
        Request $request,
        /** @noinspection PhpUnusedParameterInspection */
        Response $response,
        /** @noinspection PhpUnusedParameterInspection */
        array $args)

    {
        // リクエストパラメータ受け取り.
        $account = $request->getParsedBody()['account'];
        $password = $request->getParsedBody()['password'];
        $result = $this->accountModel->isAuthAccount($account, $password);
        if ($result) {    // ログインできた.
            // セッション登録.
            $_SESSION['isAuth'] = true;
            $_SESSION['account'] = $account;
            // TODO:ログインボタンを押したときのページへ飛ぶ
            $uri = $request->getUri()->withPath($this->router->pathFor('index'));
            return $response->withRedirect((string)$uri, 301);
        } else {  // ログインできない.
            $this->flash->addMessage('error', 'アカウント名またはパスワードが違います');
            $uri = $request->getUri()->withPath($this->router->pathFor('signIn'));
            return $response->withRedirect((string)$uri, 301);
        }
    }

    /**
     * 新規アカウント登録
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return \Psr\Http\Message\ResponseInterface|Response
     */
    public function registerAccount(
        /** @noinspection PhpUnusedParameterInspection */
        Request $request,
        /** @noinspection PhpUnusedParameterInspection */
        Response $response,
        /** @noinspection PhpUnusedParameterInspection */
        array $args)

    {
        // CSRFチェック.
//        if (false === $request->getAttribute('csrf_status')) {
//            // 失敗したらホーム画面へ戻る
//            return $this->view->render(
//                $response, 'sampleApp.html.twig', []
//            );
//        }
        // リクエストパラメータ受け取り.
        $email = $request->getParsedBody()['email'];
        $account = $request->getParsedBody()['account'];
        $password = $request->getParsedBody()['password'];
        $password2 = $request->getParsedBody()['password2'];
        // 2つ入力したパスワードが一致しているか.
        if (strcmp($password, $password2) !== 0) {
            $request = $request->withAttribute('has_errors', true);
            $errors = $request->getAttribute('errors');
            $errors = array_merge($errors, array('password2'=>['上記で入力したパスワードと一致しません']));
            $request = $request->withAttribute('errors', $errors);
        }
        // 過去に登録したデータがないか.
        if ($this->accountModel->isSameEmail($email)) {
            // 登録済みのE-mailです.
            $request = $request->withAttribute('has_errors', true);
            $errors = $request->getAttribute('errors');
            $errors = array_merge($errors, array('email'=>['登録済みのメールアドレスです']));
            $request = $request->withAttribute('errors', $errors);
        }
        if ($this->accountModel->isSameAccount($account)) {
            // 登録済みのアカウント名です.
            $request = $request->withAttribute('has_errors', true);
            $errors = $request->getAttribute('errors');
            $errors = array_merge($errors, array('account'=>['登録済みのアカウント名です']));
            $request = $request->withAttribute('errors', $errors);
        }
        // バリデーションエラーがあれば入力画面へ返す(リダイレクト).
        if ($request->getAttribute('has_errors')) { // 登録不可.
            $errors = $request->getAttribute('errors');
            // バリデーションエラー形式 errors['エラーの種別']=['エラーメッセージ']
            // フラッシュメッセージ.
            $this->flash->addMessage('email', $email);
            $this->flash->addMessage('account', $account);
            $this->flash->addMessage('errors', $errors);
            $uri = $request->getUri()->withPath($this->router->pathFor('signUp'));
            return $response->withRedirect((string)$uri, 301);
        } else {    // 登録可能.
            $this->accountModel->insertAccountData($email, $account, $password);

            // セッション登録.
            $_SESSION['isAuth'] = true;
            $_SESSION['account'] = $account;
            // TODO: リダイレクトする
//            $uri = $request->getUri()->withPath($this->router->pathFor('signIn'));
//            return $response->withRedirect('signUpComplete.html.twig', 301);
            return $this->view->render(
                $response,
                'signUpComplete.html.twig',
                [
                    'session' => $_SESSION
                ]
            );
        }
    }

//     /**
//     * テスト
//     *
//     * @param $request
//     * @param $response
//     * @param $args
//     * @return \Psr\Http\Message\ResponseInterface
//     */
//    public function test(
//        /** @noinspection PhpUnusedParameterInspection */
//        Request $request,
//        /** @noinspection PhpUnusedParameterInspection */
//        Response $response,
//        /** @noinspection PhpUnusedParameterInspection */
//        array $args)
//
//    {
//        return $this->view->render($response, 'signUpComplete.html.twig', []);
//    }
}