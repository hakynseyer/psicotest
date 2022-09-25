<?php
namespace backend\routes\users\midd;

use Arlequin\Http\Validate;
use Arlequin\Database_PDO;

class Users_Val {
  use \Arlequin\Singleton;

  private function val_id(int $id): ?string {
    return Validate::bigger(
      $id,
      0
    );
  }

  private function val_name(string $name): ?string {
    return Validate::val_Empty_Type_Min_Max(
      $name,
      'string',
      4,
      25
    );
  }

  private function val_surnames(string $surnames): ?string {
    return Validate::val_Empty_Type_Min_Max(
      $surnames,
      'string',
      4,
      15
    );
  }

  private function val_password(string $password): ?string {
    return Validate::val_Empty_Type_Min_Max(
      $password,
      'string',
      4,
      30
    );
  }

  private function val_notes(string $notes): ?string {
    return Validate::val_EmptyOptional_Type_Min_max(
      $notes,
      'string',
      4,
      255
    );
  }

  private function val_rank(int $rank_id): ?string {
    $val_number = Validate::bigger(
      $rank_id,
      0
    );

    if (empty($val_number)) {
      try {
        // Comprobando si el id del rango existe en la base de datos
        $db = Database_PDO::init() -> conn();
        
        $stmt = $db -> prepare('SELECT id FROM ranks WHERE id = :id');
        
        $stmt -> bindValue(':id', $rank_id);

        if ($stmt->execute()) {
          $data = $stmt -> fetchAll(\PDO::FETCH_OBJ);

          if (count($data) === 1) return null;
          else return 'No se pudo validar el registro del rango (B)'; 
        } else return 'No se pudo validar el registro del rango (A)';

      } catch (\Exception $e) {
        Database_PDO::init()->close();

        $res -> code (500, [
          'error' => $e -> getMessage()
        ]);
      }
    }
    
    return $val_number;
  }


  public function middleware($req, $res, $next) {
    $user = $req -> chest['user'];

    switch ($req->chest['method']) {
      case 'post':
        $val_name = $this -> val_name($user->get_name());
        $val_surname_first = $this -> val_surnames($user->get_surname_first());
        $val_surname_second = $this -> val_surnames($user->get_surname_second());
        $val_password = $this -> val_password($user->get_password());
        $val_notes = $this -> val_notes($user->get_notes());
        $val_rank = $this -> val_rank($user->get_rank()->get_id());

        if (
          empty($val_name) && 
          empty($val_surname_first) &&
          empty($val_surname_second) &&
          empty($val_password) &&
          empty($val_notes) &&
          empty($val_rank)
        ) {
          $next -> mw;
        } else {
          $res -> code (406, [
            'error' => [
              'name' => $val_name,
              'surname_first' => $val_surname_first,
              'surname_second' => $val_surname_second,
              'password' => $val_password,
              'notes' => $val_notes,
              'rank' => $val_rank,
            ]
          ]);
        }
        break;
      case 'put':
        $val_name = $this -> val_name($user->get_name());
        $val_surname_first = $this -> val_surnames($user->get_surname_first());
        $val_surname_second = $this -> val_surnames($user->get_surname_second());
        $val_password = $this -> val_password($user->get_password());
        $val_notes = $this -> val_notes($user->get_notes());
        $val_rank = $this -> val_rank($user->get_rank()->get_id());
        $val_id = $this -> val_id($user->get_id());

        if (
          empty($val_name) && 
          empty($val_surname_first) &&
          empty($val_surname_second) &&
          empty($val_password) &&
          empty($val_notes) &&
          empty($val_rank) &&
          empty($val_id)
        ) {
          $next -> mw;
        } else {
          $res -> code (406, [
            'error' => [
              'name' => $val_name,
              'surname_first' => $val_surname_first,
              'surname_second' => $val_surname_second,
              'password' => $val_password,
              'notes' => $val_notes,
              'rank' => $val_rank,
              'id' => $val_id
            ]
          ]);
        }
        break;
      case 'delete':
        $val_id = $this -> val_id($user->get_id());

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
