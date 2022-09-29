<?php
namespace backend\routes\extras\midd;

use Arlequin\Database_PDO;

class Extras_Modify_Map {
  use \Arlequin\Singleton;

  public function middleware($req, $res) {
    $extra = $req -> chest['extra'];
    
    try {
      $db = Database_PDO::init() -> conn();
      
      $stmt = $db -> prepare('UPDATE extras SET map_longitude=:map_longitude, map_latitude=:map_latitude, update_at=NOW() WHERE id=:id');

      $stmt -> bindValue(':map_longitude', $extra->get_map_longitude());
      $stmt -> bindValue(':map_latitude', $extra->get_map_latitude());
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
