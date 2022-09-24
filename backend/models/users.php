<?php
namespace backend\models;

use backend\models\Ranks;

trait Users_Getters {
  public function get_id(): int {
    return $this -> id;
  }

  public function get_name(): string {
    return $this -> name;
  }

  public function get_surname_first(): string {
    return $this -> surname_first;
  }

  public function get_surname_second(): string {
    return $this -> surname_second;
  }

  public function get_password(): string {
    return $this -> password;
  }

  public function get_notes(): string {
    return $this -> notes;
  }

  public function get_rank(): Ranks {
    return $this -> rank;
  }

  public function get_create_at(): \DateTime {
    return $this -> create_at;
  }

  public function get_update_at(): \DateTime {
    return $this -> update_at;
  }
}

trait Users_Setters {
  public function set_id(int $id): void {
    $this -> id = $id;
  }

  public function set_name(string $name): void {
    $this -> name = $name;
  }

  public function set_surname_first(string $surname_first): void {
    $this -> surname_first = $surname_first;
  }

  public function set_surname_second(string $surname_second): void {
    $this -> surname_second = $surname_second;
  }

  public function set_password(string $password): void {
    $this -> password = $password;
  }

  public function set_notes(string $notes): void {
    $this -> notes = $notes;
  }

  public function set_rank(Ranks $rank): void {
    $this -> rank = $rank;
  }
}

class Users {
  use Users_Getters;
  use Users_Setters;

  private int $id;
  private string $name;
  private string $surname_first;
  private string $surname_second;
  private string $password;
  private string $notes;
  private \DateTime $create_at;
  private \DateTime $update_at;

  private Ranks $rank;
}
