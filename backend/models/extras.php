<?php
namespace backend\models;

use backend\models\Users;

trait Extras_Getters {
  public function get_id(): int {
    return $this -> id;
  }

  public function get_gender(): string {
    return $this -> gender;
  }

  public function get_country(): string {
    return $this -> country;
  }

  public function get_city(): string {
    return $this -> city;
  }

  public function get_address(): string {
    return $this -> address;
  }

  public function get_phone(): string {
    return $this -> phone;
  }

  public function get_map_longitude(): string {
    return $this -> map_longitude;
  }

  public function get_map_latitude(): string {
    return $this -> map_latitude;
  }

  public function get_user(): Users {
    return $this -> user;
  }

  public function get_create_at(): \DateTime {
    return $this -> create_at;
  }

  public function get_update_at(): \DateTime {
    return $this -> update_at;
  }
}

trait Extras_Setters {
  public function set_id(int $id): void {
    $this -> id = $id;
  }

  public function set_gender(string $gender): void {
    $this -> gender = $gender;
  }

  public function set_country(string $country): void {
    $this -> country = $country;
  }

  public function set_city(string $city): void {
    $this -> city = $city;
  }

  public function set_address(string $address): void {
    $this -> address = $address;
  }

  public function set_phone(string $phone): void {
    $this -> phone = $phone;
  }

  public function set_map_longitude(string $map_longitude): void {
    $this -> map_longitude = $map_longitude;
  }

  public function set_map_latitude(string $map_latitude): void {
    $this -> map_latitude = $map_latitude;
  }

  public function set_user(Users $user): void {
    $this -> user = $user;
  }

}

class Extras {
  use Extras_Getters;
  use Extras_Setters;

  private int $id;
  private string $gender;
  private string $country;
  private string $city;
  private string $address;
  private string $phone;
  private string $map_longitude;
  private string $map_latitude;
  private \DateTime $create_at;
  private \DateTime $update_at;

  private Users $user;
}
