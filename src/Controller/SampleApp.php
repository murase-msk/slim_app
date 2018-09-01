<?php

namespace src\Controller;

use src\Model\SampleModel;

class SampleApp
{

    private $view;
    private $sampleModel;

    public function __construct(\Slim\Views\Twig $view, SampleModel $sampleModel)
    {
        $this->view = $view;
        $this->sampleModel = $sampleModel;
    }

    public function index($request, $response, $args)
    {
        $result = $this->sampleModel->getData();
        return $this->view->render($response, 'sampleApp.html.twig', [
            'name' => 'aaba',
            'activeHeader' => 'index',
            'session' => $_SESSION,
        ]);
    }




}