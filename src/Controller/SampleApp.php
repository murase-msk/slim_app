<?php

namespace src\Controller;

use src\Model\SampleModel;
use Slim\Http\Response;
use Slim\Http\Request;

class SampleApp
{

    private $view;
    private $session;

    public function __construct(\Slim\Views\Twig $view, \src\SessionHelper $session)
    {
        $this->view = $view;
        $this->session = $session;
    }

    public function index(
        /** @noinspection PhpUnusedParameterInspection */
        Request $request,
        /** @noinspection PhpUnusedParameterInspection */
        Response $response,
        /** @noinspection PhpUnusedParameterInspection */
        array $args)
    {

        //$result = $this->sampleModel->getData();
        return $this->view->render($response, 'sampleApp.html.twig', [
            'activeHeader' => 'index',
            'isAuth' => $this->session->get('isAuth'),
            'account' => $this->session->get('account'),
        ]);
    }




}