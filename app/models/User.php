<?php
// app/models/User.php
require_once __DIR__ . '/../core/Model.php';

class User extends Model
{
    public function getUserById($user_id)
    {
        $this->query("SELECT * FROM users WHERE id = :id");
        $this->bind(':id', $user_id);
        return $this->single();
    }

    public function updateUser($user_id, $nama, $email, $password = null)
    {
        // Jika password kosong, update hanya nama dan email
        if ($password) {
            $this->query("UPDATE users SET nama = :nama, email = :email, password = :password WHERE id = :id");
            $this->bind(':password', $password);
        } else {
            $this->query("UPDATE users SET nama = :nama, email = :email WHERE id = :id");
        }
        $this->bind(':nama', $nama);
        $this->bind(':email', $email);
        $this->bind(':id', $user_id);

        return $this->execute();
    }

    public function findByEmail($email)
    {
        $this->query("SELECT * FROM users WHERE email = :email");
        $this->bind(':email', $email);
        return $this->single();
    }
}
