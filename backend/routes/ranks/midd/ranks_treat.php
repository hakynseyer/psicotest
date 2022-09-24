<?php
namespace backend\routes\ranks\midd;

use backend\models\Ranks;

class Ranks_Treat {
  use \Arlequin\Singleton;

  public function middleware($req, $res, $next) {
    $rank = new Ranks();
    $rank -> set_rank($req->chest['data']['rank']);
    $rank -> set_description($req->chest['data']['description']);
    
    $req -> save_chest('rank', $rank);

    $next->mw;
  }
}
