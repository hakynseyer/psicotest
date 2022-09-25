<?php
namespace backend\routes\extras\midd;

use Arlequin\Http\Validate;
use Arlequin\Database_PDO;

class Extras_Val {
  use \Arlequin\Singleton;

  private function val_id(int $id): ?string {
    return Validate::bigger(
      $id,
      0
    );
  }

  private function val_gender(string $gender): ?string {
    if ($gender === 'male' || $gender === 'female') return null;
    else return "No se pudo validar el genero del usuario";
  }

  private function val_places(string $places): ?string {
    return Validate::val_Empty_Type_Min_Max(
      $places,
      'string',
      4,
      30
    );
  }

  private function val_address(string $address): ?string {
    return Validate::val_Empty_Type_Min_Max(
      $address,
      'string',
      4,
      255
    );
  }

  private function val_map(string $map): ?string {
    return Validate::val_EmptyOptional_Type_Min_max(
      $map,
      'string',
      4,
      100
    );
  }

  private function val_user(int $user_id): ?string {
    $val_number = Validate::bigger(
      $user_id,
      0
    );

    if (empty($val_number)) {
      try {
        // Comprobando si el id del rango existe en la base de datos
        $db = Database_PDO::init() -> conn();
        
        $stmt = $db -> prepare('SELECT id FROM users WHERE id = :id');
        
        $stmt -> bindValue(':id', $user_id);

        if ($stmt->execute()) {
          $data = $stmt -> fetchAll(\PDO::FETCH_OBJ);

          if (count($data) === 1) return null;
          else return 'No se pudo validar el registro del usuario (B)'; 
        } else return 'No se pudo validar el registro del usuario (A)';

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
    $extra = $req -> chest['extra'];

    switch ($req->chest['method']) {
      case 'post':
        $val_gender = $this -> val_gender($extra->get_gender());
        $val_country = $this -> val_places($extra->get_country());
        $val_city = $this -> val_places($extra->get_city());
        $val_address = $this -> val_address($extra->get_address());
        $val_map_longitude = $this -> val_map($extra->get_map_longitude());
        $val_map_latitude = $this -> val_map($extra->get_map_latitude());
        $val_user = $this -> val_user($extra->get_user()->get_id());

        if (
          empty($val_gender) && 
          empty($val_country) &&
          empty($val_city) &&
          empty($val_address) &&
          empty($val_map_longitude) &&
          empty($val_map_latitude) &&
          empty($val_user)
        ) {
          $next -> mw;
        } else {
          $res -> code (406, [
            'error' => [
              'gender' => $val_gender,
              'country' => $val_country,
              'city' => $val_city,
              'address' => $val_address,
              'map_longitude' => $val_map_longitude,
              'map_latitude' => $val_map_latitude,
              'user' => $val_user,
            ]
          ]);
        }
        break;
      case 'put':
        $val_gender = $this -> val_gender($extra->get_gender());
        $val_country = $this -> val_places($extra->get_country());
        $val_city = $this -> val_places($extra->get_city());
        $val_address = $this -> val_address($extra->get_address());
        $val_map_longitude = $this -> val_map($extra->get_map_longitude());
        $val_map_latitude = $this -> val_map($extra->get_map_latitude());
        $val_user = $this -> val_user($extra->get_user()->get_id());
        $val_id = $this -> val_id($extra->get_id());

        if (
          empty($val_gender) && 
          empty($val_country) &&
          empty($val_city) &&
          empty($val_address) &&
          empty($val_map_longitude) &&
          empty($val_map_latitude) &&
          empty($val_user) &&
          empty($val_id)
        ) {
          $next -> mw;
        } else {
          $res -> code (406, [
            'error' => [
              'gender' => $val_gender,
              'country' => $val_country,
              'city' => $val_city,
              'address' => $val_address,
              'map_longitude' => $val_map_longitude,
              'map_latitude' => $val_map_latitude,
              'user' => $val_user,
              'id' => $val_id
            ]
          ]);
        }
        break;
      case 'delete':
        $val_id = $this -> val_id($extra->get_id());

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
