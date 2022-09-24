<?php
use Arlequin\Route\Route;

use backend\routes\users\midd\{Users_Treat};

Route::post(
  '/users/create',
  Users_Treat::init()
);
