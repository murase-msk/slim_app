<?php
/**
 * Created by PhpStorm.
 * User: masaki
 * Date: 2018/09/01
 * Time: 22:07
 */

namespace src\Middleware\Auth;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class AccountAuth
 * @package src\Middleware\Auth
 */
class AccountAuth
{
    public function __construct()
    {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        // TODO: Implement __invoke() method.

        return $next($request, $response);
    }

}