<?php
namespace backend\routes\users\midd;

use Arlequin\Database_PDO;

class Users_Read {
  use \Arlequin\Singleton;

  public function middleware($req, $res) {
    try {
      $db = Database_PDO::init() -> conn();
      
      $stmt = $db -> prepare('SELECT U.id, U.name, U.surname_first, U.surname_second, U.password, U.notes, U.rank, R.rank as rankName FROM users U INNER JOIN ranks R ON U.rank = R.id');

      if ($stmt->execute()) {
        Database_PDO::init()->close();
        
        $data = $stmt -> fetchAll(\PDO::FETCH_OBJ);

        $res -> code (201, [
          'users' => $data,
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
