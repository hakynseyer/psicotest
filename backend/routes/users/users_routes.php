<?php
use Arlequin\Route\Route;

use backend\routes\users\midd\{Users_Treat, Users_Val, Users_Create, Users_Update, Users_Delete};

Route::post(
  '/users/create',
  Users_Treat::init(),
  Users_Val::init(),
  Users_Create::init()
);

Route::put(
  '/users/update',
  Users_Treat::init(),
  Users_Val::init(),
  Users_Update::init()
);

Route::delete(
  '/users/delete',
  Users_Treat::init(),
  Users_Val::init(),
  Users_Delete::init()
);
