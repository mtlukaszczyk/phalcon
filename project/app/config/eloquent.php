<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection(
        CONFIG['DATABASE']
);

$capsule->bootEloquent();