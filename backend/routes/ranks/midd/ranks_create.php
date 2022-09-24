<?php
namespace backend\routes\ranks\midd;

use Arlequin\Database_PDO;

class Ranks_Create {
  use \Arlequin\Singleton;

  public function middleware($req, $res) {
    $rank = $req -> chest['rank'];

    try {
      $db = Database_PDO::init() -> conn();
      
      $stmt = $db -> prepare('INSERT INTO ranks(rank, description, create_at, update_at) VALUES(:rank, :description, NOW(), NOW())');

      $stmt -> bindValue(':rank', $rank->get_rank());
      $stmt -> bindValue(':description', $rank->get_description());

      if ($stmt->execute()) {
        Database_PDO::init()->close();

        $res -> code (201, [
          'rank' => $rank->get_rank(),
          'description' => $rank->get_description()
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
