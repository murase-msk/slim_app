<?php

namespace src\Controller;

use src\Model\SampleModel;
use Slim\Http\Response;
use Slim\Http\Request;

class SampleApp
{

    private $view;
    private $sampleModel;

    public function __construct(\Slim\Views\Twig $view, SampleModel $sampleModel)
    {
        $this->view = $view;
        $this->sampleModel = $sampleModel;
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
            'session' => $_SESSION,
        ]);
    }




}