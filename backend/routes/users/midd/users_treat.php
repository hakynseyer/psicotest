<?php
namespace backend\routes\users\midd;

/* use backend\models\Users; */

class Users_Treat {
  use \Arlequin\Singleton;

  public function middleware($req, $res) {
    /* $rank = new Users(); */
    echo "HOLA DESDE USERS";

    // Agregamos el parametro ID para las peticiones PUT, DELETE
    /* if (isset($req->chest['data']['id']) && !empty($req->chest['data']['id'])) */
    /*   $rank -> set_id($req->chest['data']['id']); */

    /* if (isset($req->chest['data']['rank']) && !empty($req->chest['data']['rank'])) */
    /*   $rank -> set_rank($req->chest['data']['rank']); */

    /* if (isset($req->chest['data']['description']) && !empty($req->chest['data']['description'])) */
    /*   $rank -> set_description($req->chest['data']['description']); */
    
    /* $req -> save_chest('rank', $rank); */

    /* $next->mw; */
  }
}
