<?php
/**
 * Created by PhpStorm.
 * User: masaki
 * Date: 2018/09/01
 * Time: 22:43
 */

namespace src\Controller;

/**
 * Class BaseController
 * @package src\Controller
 * すべてのコントローラーの親クラス
 */
class BaseController
{
    public function __construct()
    {
    }

    /**
     * CSRF用のKey-Value生成
     * @param $request
     * @param $csrf
     * @return array
     */
    public static function generateCsrfKeyValue($request, $csrf)
    {
        // CSRF用Key-Value生成.
        $csrfNameKey = $csrf->getTokenNameKey();//'csrf_name';
        $csrfValueKey = $csrf->getTokenValueKey();//'csrf_value';
        $csrfName = $request->getAttribute($csrfNameKey);
        $csrfValue = $request->getAttribute($csrfValueKey);
        return [
            'csrf' => [
                'keys' => [
                    'name' => $csrfNameKey,
                    'value' => $csrfValueKey
                ],
                'name' => $csrfName,
                'value' => $csrfValue
            ]
        ];
    }
}