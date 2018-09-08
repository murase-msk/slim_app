<?php

namespace src\Controller;

use src\Model\SampleModel;
use Slim\Http\Response;
use Slim\Http\Request;

class SampleApp
{

    private $view;

    public function __construct(\Slim\Views\Twig $view)
    {
        $this->view = $view;
    }

    public function index(
        /** @noinspection PhpUnusedParameterInspection */
        Request $request,
        /** @noinspection PhpUnusedParameterInspection */
        Response $response,
        /** @noinspection PhpUnusedParameterInspection */
        array $args)
    {
        if(!isset($_SESSION)){
            $_SESSION = [];
        }

        //$result = $this->sampleModel->getData();
        return $this->view->render($response, 'sampleApp.html.twig', [
            'activeHeader' => 'index',
            'session' => $_SESSION,
        ]);
    }




}