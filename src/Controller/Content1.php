<?php
/**
 * Created by PhpStorm.
 * User: masaki
 * Date: 2018/08/13
 * Time: 13:25
 */

namespace src\Controller;


class Content1
{

    private $view;

    function __construct(\Slim\Views\Twig $view)
    {
        $this->view = $view;
    }

    function index($request, $response, $args)
    {
        return $this->view->render($response, 'content1.html.twig', [
            'name' => 'aaba',
            'activeHeader' => 'content1'
        ]);

    }
}