<?php
namespace backend\routes\users\midd;

use Arlequin\Database_PDO;

class Users_Delete {
  use \Arlequin\Singleton;

  public function middleware($req, $res) {
    $user = $req -> chest['user'];
    
    try {
      $db = Database_PDO::init() -> conn();
      
      $stmt = $db -> prepare('DELETE FROM users WHERE id=:id');

      $stmt -> bindValue(':id', $user->get_id());

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
