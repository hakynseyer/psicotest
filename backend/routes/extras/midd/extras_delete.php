<?php
namespace backend\routes\extras\midd;

use Arlequin\Database_PDO;

class Extras_Delete {
  use \Arlequin\Singleton;

  public function middleware($req, $res) {
    $extra = $req -> chest['extra'];
    
    try {
      $db = Database_PDO::init() -> conn();
      
      $stmt = $db -> prepare('DELETE FROM extras WHERE id=:id');

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
