<?php

require ('./Application.php');
require ('./A.php');

$app = Application::getInstance();

// $app->bind('a', function($app, $b) {
//     return new A($app->make($b));
// });

// $app->bind('b', function($app) {
//     return new B();
// });

echo $app->make('a')->get();
