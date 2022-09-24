<?php
namespace backend\routes\ranks\midd;

use Arlequin\Database_PDO;

class Ranks_Delete {
  use \Arlequin\Singleton;

  public function middleware($req, $res) {
    $rank = $req -> chest['rank'];
    
    try {
      $db = Database_PDO::init() -> conn();
      
      $stmt = $db -> prepare('DELETE FROM ranks WHERE id=:id');

      $stmt -> bindValue(':id', $rank->get_id());

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
