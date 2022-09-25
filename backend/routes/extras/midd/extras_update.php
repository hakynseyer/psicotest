<?php
namespace backend\routes\extras\midd;

use Arlequin\Database_PDO;

class Extras_Update {
  use \Arlequin\Singleton;

  public function middleware($req, $res) {
    $extra = $req -> chest['extra'];
    
    try {
      $db = Database_PDO::init() -> conn();
      
      $stmt = $db -> prepare('UPDATE extras SET gender=:gender, country=:country, city=:city, address=:address, phone=:phone, map_longitude=:map_longitude, map_latitude=:map_latitude, user=:user, update_at=NOW() WHERE id=:id');

      $stmt -> bindValue(':gender', $extra->get_gender());
      $stmt -> bindValue(':country', $extra->get_country());
      $stmt -> bindValue(':city', $extra->get_city());
      $stmt -> bindValue(':address', $extra->get_address());
      $stmt -> bindValue(':phone', $extra->get_phone());
      $stmt -> bindValue(':map_longitude', $extra->get_map_longitude());
      $stmt -> bindValue(':map_latitude', $extra->get_map_latitude());
      $stmt -> bindValue(':user', $extra->get_user()->get_id());
      $stmt -> bindValue(':id', $extra->get_id());

      if ($stmt->execute()) {
        Database_PDO::init()->close();

        $res -> code (200);
      }
    } catch (\Exception $e) {
      Database_PDO::init()->close();

      $res -> code (500, [
        'error' => $e -> getMessage()
      ]);
    }
  }
}
