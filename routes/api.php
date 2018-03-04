<?php

use App\Controllers\Api\NewsController;

$app->get('/api/news/{service}', NewsController::class . ':show');
