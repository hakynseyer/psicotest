<?php
namespace backend\routes\users\midd;

use Arlequin\Database_PDO;

class Users_Create {
  use \Arlequin\Singleton;

  public function middleware($req, $res) {
    $user = $req -> chest['user'];

    try {
      $db = Database_PDO::init() -> conn();
      
      $stmt = $db -> prepare('INSERT INTO users(name, surname_first, surname_second, password, notes, rank, create_at, update_at) VALUES(:name, :surname_first, :surname_second, :password, :notes, :rank, NOW(), NOW())');

      $stmt -> bindValue(':name', $user->get_name());
      $stmt -> bindValue(':surname_first', $user->get_surname_first());
      $stmt -> bindValue(':surname_second', $user->get_surname_second());
      $stmt -> bindValue(':password', $user->get_password());
      $stmt -> bindValue(':notes', $user->get_notes());
      $stmt -> bindValue(':rank', $user->get_rank()->get_id());

      if ($stmt->execute()) {
        Database_PDO::init()->close();

        $res -> code (201, [
          'name' => $user->get_name(),
          'surname_first' => $user->get_surname_first(),
          'surname_second' => $user->get_surname_second(),
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
