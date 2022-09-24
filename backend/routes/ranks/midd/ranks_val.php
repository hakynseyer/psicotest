<?php
namespace backend\routes\ranks\midd;

use Arlequin\Http\Validate;

class Ranks_Val {
  use \Arlequin\Singleton;

  private function val_rank(string $rank): ?string {
    return Validate::val_Empty_Type_Min_Max(
      $rank,
      'string',
      4,
      30
    );
  }

  private function val_description(string $description): ?string {
    return Validate::val_Empty_Type_Min_Max(
      $description,
      'string',
      4,
      255
    );
  }

  private function val_id(int $id): ?string {
    return Validate::bigger(
      $id,
      0
    );
  }

  public function middleware($req, $res, $next) {
    $rank = $req -> chest['rank'];

    switch ($req->chest['method']) {
      case 'post':
        $val_rank = $this -> val_rank($rank->get_rank());
        $val_description = $this -> val_description($rank->get_description());

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
        break;
      case 'put':
        $val_rank = $this -> val_rank($rank->get_rank());
        $val_description = $this -> val_description($rank->get_description());
        $val_id = $this -> val_id($rank->get_id());

        if (empty($val_rank) && empty($val_description) && empty($val_id)) {
          // TODO: Aqui iría una validación unica para el campo rank
          $next -> mw;
        } else {
          $res -> code (406, [
            'error' => [
              'rank' => $val_rank,
              'description' => $val_description,
              'id' => $val_id
            ]
          ]);
        }
        break;
      case 'delete':
        $val_id = $this -> val_id($rank->get_id());

        if (empty($val_id)) $next -> mw;
        else {
          $res -> code (406, [
            'error' => [
              'id' => $val_id
            ]
          ]);
        }
        break;
    }
  }
}
