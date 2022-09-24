<?php
namespace backend\models;

trait Ranks_Getters {
  public function get_id(): int {
    return $this -> id;
  }

  public function get_rank(): string {
    return $this -> rank;
  }

  public function get_description(): string {
    return $this -> description;
  }

  public function get_create_at(): \DateTime {
    return $this -> create_at;
  }

  public function get_update_at(): \DateTime {
    return $this -> update_at;
  }
}

trait Ranks_Setters {
  public function set_id(int $id): void {
    $this -> id = $id;
  }

  public function set_rank(string $rank): void {
    $this -> rank = $rank;
  }

  public function set_description(string $description): void {
    $this -> description = $description;
  }
}

class Ranks {
  use Ranks_Getters;
  use Ranks_Setters;

  private int $id;
  private string $rank;
  private string $description;
  private \DateTime $create_at;
  private \DateTime $update_at;
}
