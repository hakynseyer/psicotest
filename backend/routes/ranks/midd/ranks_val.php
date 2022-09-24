<?php
namespace backend\routes\ranks\midd;

use Arlequin\Http\Validate;

class Ranks_Val {
  use \Arlequin\Singleton;

  public function middleware($req, $res, $next) {
    $rank = $req -> chest['rank'];

    $val_rank = Validate::val_Empty_Type_Min_Max(
      $rank -> get_rank(),
      'string',
      4,
      30
    );
    
    $val_description = Validate::val_Empty_Type_Min_Max(
      $rank -> get_description(),
      'string',
      4,
      255
    );

    if (empty($val_rank) && empty($val_description)) {
      // TODO: Aqui iría una validación unica para el campo rank
      $next -> mw;
    } else {
      $res -> code (406, [
        'error' => [
          'rank' => $val_rank,
          'description' => $val_description
        ]
      ]);
    }
  }
}
