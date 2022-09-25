<?php
namespace backend\routes\extras\midd;

use backend\models\{Extras, Users};

class Extras_Treat {
  use \Arlequin\Singleton;

  public function middleware($req, $res, $next) {
    $extra = new Extras();

    if (isset($req->chest['data']['id']))
      $extra -> set_id($req->chest['data']['id']);

    if (isset($req->chest['data']['gender']))
      $extra -> set_gender($req->chest['data']['gender']);

    if (isset($req->chest['data']['country']))
      $extra -> set_country($req->chest['data']['country']);

    if (isset($req->chest['data']['city']))
      $extra -> set_city($req->chest['data']['city']);

    if (isset($req->chest['data']['address']))
      $extra -> set_address($req->chest['data']['address']);

    if (isset($req->chest['data']['phone']))
      $extra -> set_phone(json_encode($req->chest['data']['phone']));

    if (isset($req->chest['data']['map_longitude']))
      $extra -> set_map_longitude($req->chest['data']['map_longitude']);

    if (isset($req->chest['data']['map_latitude']))
      $extra -> set_map_latitude($req->chest['data']['map_latitude']);

    if (isset($req->chest['data']['user'])) {
      $user = new Users();
      $user -> set_id($req->chest['data']['user']);

      $extra -> set_user($user);
    }
    
    $req -> save_chest('extra', $extra);

    $next->mw;
  }
}
