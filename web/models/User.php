<?php
require_once 'models/BaseModel.php';


class User extends BaseModel
{
    function __construct()
    {
        parent::__construct();
    }

    public function create(
        string $name,
        string $email,
        string $password,
        string $profile_resource_id
    )
    {
        $sql = "INSERT INTO users(
                    name,
                    email,
                    password,
                    profile_resource_id
                )
                VALUES(
                    :name,
                    :email,
                    :password,
                    :profile_resource_id
                )
                ;";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':profile_resource_id', $profile_resource_id);
        $stmt->execute();
    }

    public function getUserByEmail(string $email): array
    {
        $sql = "SELECT
                    count(*)
                FROM
                    users
                WHERE
                    email = :email
                ;";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        var_dump(gettype($stmt->fetchAll(PDO::FETCH_ASSOC)));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
