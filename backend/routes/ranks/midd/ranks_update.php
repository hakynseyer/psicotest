<?php
namespace backend\routes\ranks\midd;

use Arlequin\Database_PDO;

class Ranks_Update {
  use \Arlequin\Singleton;

  public function middleware($req, $res) {
    $rank = $req -> chest['rank'];
    
    try {
      $db = Database_PDO::init() -> conn();
      
      $stmt = $db -> prepare('UPDATE ranks SET rank=:rank, description=:description, update_at=NOW() WHERE id=:id');

      $stmt -> bindValue(':rank', $rank->get_rank());
      $stmt -> bindValue(':description', $rank->get_description());
      $stmt -> bindValue(':id', $rank->get_id());

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
