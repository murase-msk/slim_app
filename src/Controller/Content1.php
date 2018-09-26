<?php
/**
 * Created by PhpStorm.
 * User: masaki
 * Date: 2018/08/13
 * Time: 13:25
 */

namespace src\Controller;
use Slim\Http\Response;
use Slim\Http\Request;

/**
 * Class Content1
 * @package src\Controller
 * コンテンツ画面
 */
class Content1
{

    private $view;
    private $session;

    function __construct(\Slim\Views\Twig $view, \SlimSession\Helper $session)
    {
        $this->view = $view;
        $this->session = $session;
    }

    function index(
        /** @noinspection PhpUnusedParameterInspection */
        Request $request,
        /** @noinspection PhpUnusedParameterInspection */
        Response $response,
        /** @noinspection PhpUnusedParameterInspection */
        array $args)
    {
        return $this->view->render($response, 'content1.html.twig', [
            'activeHeader' => 'content1',
            'isAuth' => $this->session->get('isAuth'),
            'account' => $this->session->get('account'),
        ]);
    }

    /**
     * 新規作成画面
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    function new(
        /** @noinspection PhpUnusedParameterInspection */
        Request $request,
        /** @noinspection PhpUnusedParameterInspection */
        Response $response,
        /** @noinspection PhpUnusedParameterInspection */
        array $args)
    {
        return $this->view->render($response, 'content1New.html.twig', [
            'activeHeader' => 'content1',
            'isAuth' => $_SESSION['isAuth']
        ]);
    }

    /**
     * コンテンツ登録
     * @param Request $request
     * @param Response $response
     * @param array $args
     */
    function registerContent(
        /** @noinspection PhpUnusedParameterInspection */
        Request $request,
        /** @noinspection PhpUnusedParameterInspection */
        Response $response,
        /** @noinspection PhpUnusedParameterInspection */
        array $args)
    {
        // TODO:データベース追加.
        // TODO:登録完了画面へ移動.
    }
}