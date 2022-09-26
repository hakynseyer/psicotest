<?php
use Arlequin\Route\Route;

use backend\routes\extras\midd\{Extras_Treat, Extras_Val, Extras_Create, Extras_Update, Extras_Delete, Extras_Read};

Route::get(
  '/extras',
  Extras_Read::init()
);

Route::post(
  '/extras/create',
  Extras_Treat::init(),
  Extras_Val::init(),
  Extras_Create::init()
);

Route::put(
  '/extras/update',
  Extras_Treat::init(),
  Extras_Val::init(),
  Extras_Update::init()
);

Route::delete(
  '/extras/delete',
  Extras_Treat::init(),
  Extras_Val::init(),
  Extras_Delete::init()
);
