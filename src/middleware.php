<?php
// Application middleware

// CSRF対策.
$app->add($container->get('csrf'));

// 認証.
$app->add($container->get('accountAuth'));