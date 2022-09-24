<?php
use Arlequin\Route\Route;

use backend\routes\ranks\midd\{Ranks_Treat, Ranks_Val, Ranks_Create};

Route::post(
  '/ranks/create',
  Ranks_Treat::init(),
  Ranks_Val::init(),
  Ranks_Create::init()
);
