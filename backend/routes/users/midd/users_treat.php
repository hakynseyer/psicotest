<?php
namespace backend\routes\users\midd;

use backend\models\{Users, Ranks};

class Users_Treat {
  use \Arlequin\Singleton;

  public function middleware($req, $res, $next) {
    $user = new Users();

    if (isset($req->chest['data']['id']))
      $user -> set_id($req->chest['data']['id']);

    if (isset($req->chest['data']['name']))
      $user -> set_name($req->chest['data']['name']);

    if (isset($req->chest['data']['surname_first']))
      $user -> set_surname_first($req->chest['data']['surname_first']);

    if (isset($req->chest['data']['surname_second']))
      $user -> set_surname_second($req->chest['data']['surname_second']);

    if (isset($req->chest['data']['password']))
      $user -> set_password($req->chest['data']['password']);

    if (isset($req->chest['data']['notes']))
      $user -> set_notes($req->chest['data']['notes']);

    if (isset($req->chest['data']['rank'])) {
      $rank = new Ranks();
      $rank -> set_id($req->chest['data']['rank']);

      $user -> set_rank($rank);
    }
    
    $req -> save_chest('user', $user);

    $next->mw;
  }
}
