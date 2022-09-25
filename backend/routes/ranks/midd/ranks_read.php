<?php
namespace backend\routes\ranks\midd;

use Arlequin\Database_PDO;

class Ranks_Read {
  use \Arlequin\Singleton;

  public function middleware($req, $res) {
    try {
      $db = Database_PDO::init() -> conn();
      
      $stmt = $db -> prepare('SELECT * FROM ranks');

      if ($stmt->execute()) {
        Database_PDO::init()->close();
        
        $data = $stmt -> fetchAll(\PDO::FETCH_OBJ);

        $res -> code (201, [
          'ranks' => $data,
        ]);
      }
    } catch (\Exception $e) {
      Database_PDO::init()->close();

      $res -> code (500, [
        'error' => $e -> getMessage()
      ]);
    }
  }
}
