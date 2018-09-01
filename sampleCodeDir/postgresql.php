<?php

$db= [
    'host' => 'localhost',
    'user' => 'postgres',
    'pass' => 'postgres',
    'dbname'=> 'slim_app'
];
$tableName = 'account';

$pdo = new PDO('pgsql:host=' . $db['host'] . ' dbname=' . $db['dbname'] . ' port=5432', $db['user'], $db['pass']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$sql = 'select * from ' . $tableName ;
$stmt = $pdo->prepare($sql);
$stmt->execute(array());
$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

var_dump($result);

