<?php
/**
 * Created by PhpStorm.
 * User: masaki
 * Date: 2018/08/13
 * Time: 17:21
 */

namespace src\Controller;

use src\Model\AccountModel;

class AccountController extends BaseController
{
    private $view;
    private $accountModel;
    private $router;
    private $csrf;
    private $flash;

    function __construct(\Slim\Views\Twig $view, AccountModel $accountModel, $router, $csrf, $flash)
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
     *
     * @param $request
     * @param $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function signIn($request, $response, $args)
    {
        return $this->view->render($response, 'signIn.html.twig', []);
    }

    /**
     * 新規登録
     *
     * @param $request
     * @param $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function signUp($request, $response, $args)
    {
        // CSRF用Key-Value生成.
        $csrfNameKey = $this->csrf->getTokenNameKey();//'csrf_name';
        $csrfValueKey = $this->csrf->getTokenValueKey();//'csrf_value';
        $csrfName = $request->getAttribute($csrfNameKey);
        $csrfValue = $request->getAttribute($csrfValueKey);

        $flash = $this->flash->getMessages();
        //var_dump($flash['errors'][0]['email'][0]);

        return $this->view->render(
            $response,
            'signUp.html.twig',
            [
                'csrf'   => [
                    'keys' => [
                        'name'  => $csrfNameKey,
                        'value' => $csrfValueKey
                    ],
                    'name'  => $csrfName,
                    'value' => $csrfValue
                ],
                'flash' => $flash
            ]

        );
    }

    /**
     * ログアウト
     * @param $request
     * @param $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function logout($request, $response, $args)
    {
        // セッション登録.
        $_SESSION['isAuth'] = false;
        $_SESSION['account'] = '';

        // TODO:リダイレクトする.
        return $this->view->render(
            $response,
            'sampleApp.html.twig',
            [
                'session' => $_SESSION
            ]
        );
    }

    /**
     * ログインの認証
     * @param $request
     * @param $response
     * @param $args
     */
    public function auth($request, $response, $args)
    {
        var_dump($response);
    }

    /**
     * 新規アカウント登録
     * @param $request
     * @param $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function registerAccount($request, $response, $args)
    {
        // CSRFチェック.
        if (false === $request->getAttribute('csrf_status')) {
            // 失敗したらホーム画面へ戻る
            return $this->view->render(
                $response, 'sampleApp.html.twig', []
            );
        }
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
            $this->accountModel->insertAccountData(['email'=>$email, 'account'=>$account, 'passqord'=>$password]);

            // セッション登録.
            $_SESSION['isAuth'] = true;
            $_SESSION['account'] = $account;
            // TODO: リダイレクトする
            return $this->view->render(
                $response,
                'signUpComplete.html.twig',
                [
                    'session' => $_SESSION
                ]
            );
        }
    }

     /**
     * テスト
     *
     * @param $request
     * @param $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function test($request, $response, $args)
    {
        return $this->view->render($response, 'signUpComplete.html.twig', []);
    }
}