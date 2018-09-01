<?php



use Respect\Validation\Validator as v;

// TODO 正規表現を使う

//v::countryCode()->validate('JP');

// xxx@xxx.xxx(xxxは先頭アルファベットかつ50字以内)
$emailValidator = v::notBlank()->email()->setTemplate('メールアドレスの形式が正しくありません');
//$emailValidator = v::regex('/^[a-z]$/')->setTemplate('カスタムメッセージ');
// 先頭アルファベットかつ3~30字以内.
$accountValidator = v::alnum('_')->noWhitespace()->length(3,30)->setTemplate('3字以上30字以内にしてください');
// 先頭アルファベットかつ英数字3~16字以内.
$passwordValidator = v::alnum('_')->noWhitespace()->length(3,16)->setTemplate('3字以上16字以内にしてください');

//$password2Validator = v::equals('')->setTemplate('上記で入力したパスワードと一致しません');

$validators = array(
    'email' => $emailValidator,
    'account' => $accountValidator,
    'password' => $passwordValidator
);

