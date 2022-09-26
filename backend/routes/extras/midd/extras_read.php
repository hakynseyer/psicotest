<?php
namespace backend\routes\extras\midd;

use Arlequin\Database_PDO;

class Extras_Read {
  use \Arlequin\Singleton;

  public function middleware($req, $res) {
    try {
      $db = Database_PDO::init() -> conn();
      
      $stmt = $db -> prepare('SELECT E.id, E.gender, E.country, E.city, E.address, E.phone, E.user, U.name, U.surname_first, U.surname_second FROM extras E INNER JOIN users U ON E.user = U.id');

      if ($stmt->execute()) {
        Database_PDO::init()->close();
        
        $data = $stmt -> fetchAll(\PDO::FETCH_OBJ);

        $res -> code (201, [
          'extras' => $data,
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
