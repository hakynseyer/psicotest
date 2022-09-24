<?php
use Arlequin\Route\Route;

use backend\routes\ranks\midd\{Ranks_Treat, Ranks_Val, Ranks_Create, Ranks_Update, Ranks_Delete};

Route::post(
  '/ranks/create',
  Ranks_Treat::init(),
  Ranks_Val::init(),
  Ranks_Create::init()
);

Route::put(
  '/ranks/update',
  Ranks_Treat::init(),
  Ranks_Val::init(),
  Ranks_Update::init()
);

Route::delete(
  '/ranks/delete',
  Ranks_Treat::init(),
  Ranks_Val::init(),
  Ranks_Delete::init()
);
