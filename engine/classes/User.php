<?php

namespace classes;

use DateTime;

class User {
    public DB $db;
    private int $id;
    private string $surname;
    private string $name;
    private $patronymic;
    private string $mail;
    private DateTime $createdDate;
    private string $groupCode;

    public function __construct() {
        $this->db = new DB(DB_SETTINGS);
    }

    public function authorization($mail, $password) : bool {
        $user = $this->getUserByMail($mail);

        if (password_verify($password, $user['password'])) {
            $this->setId($user['id']);
            $this->setName($user['name']);
            $this->setSurname($user['surname']);
            $this->setPatronymic($user['patronymic']);
            $this->setCreatedDate($user['created_date']);
            $this->setMail($user['mail']);
            $this->setGroup($user['group_code']);

            $_SESSION['user'] = [
                'name' => $this->getName(),
                'surname' => $this->getSurname(),
                'patronymic' => $this->getPatronymic(),
                'createdDate' => $this->getCreatedDate(),
                'mail' => $this->getMail(),
                'group' => $this->getGroup()
            ];

            return true;
        }

        return false;
    }

    public function isAuth() : bool {
        return isset($_SESSION['user']) && !empty($_SESSION['user']);
    }

    private function getUserByMail(string $mail) {
        if (!empty($mail)) {
            $user = $this->db->get('users', 'users.*, users_groups.code as group_code', [
                'where' => ["users.mail = '$mail'"],
                'join' => 'users_groups on users_groups.id = users.group_id',
            ]);
            return $user[0];
        } else {
            return [];
        }
    }

    private function setId(int $id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id ?? null;
    }

    private function setName(string $name) {
        $this->name = $name;
    }

    private function getName() {
        return $this->name ?? null;
    }

    public function getNameSession() : string {
        return $_SESSION['user']['name'] ?? '';
    }

    private function setSurname(string $surname) {
        $this->surname = $surname;
    }

    public function getSurname() {
        return $this->surname ?? null;
    }

    private function setPatronymic($patronymic) {
        $this->patronymic = $patronymic;
    }

    public function getPatronymic() {
        return $this->patronymic ?? null;
    }

    private function setMail(string $mail) {
        $this->mail = $mail;
    }

    public function getMail() {
        return $this->mail ?? null;
    }

    private function setCreatedDate(string $createdDate) {
        $this->createdDate = new DateTime($createdDate);
    }

    public function getCreatedDate() {
        return $this->createdDate->format("d.m.Y H:i") ?? null;
    }

    private function setGroup(string $group) {
        $this->groupCode = $group;
    }

    public function getGroup() : string {
        return $this->groupCode ?? 'NO_USER';
    }

    public function getGroupSession() : string {
        return $_SESSION['user']['group'] ?? 'NO_USER';
    }

}