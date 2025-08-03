<?php
// app/models/User.php


class User extends Model
{
    public function insertUser($data)
    {
        $stmt = $this->db->prepare("INSERT INTO users (nama, email, password, no_hp, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['nama'],
            $data['email'],
            $data['password'],
            $data['no_hp'],
            $data['role']
        ]);
    }

    public function getUserById($user_id)
    {
        $this->query("SELECT * FROM users WHERE id = :id");
        $this->bind(':id', $user_id);
        return $this->single();
    }

    public function updateUser($user_id, $nama, $email, $password = null)
    {
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

    public function updateUserByAdmin($user_id, $nama, $email, $password = null, $no_hp = '', $role = '')
    {
        if ($password) {
            $this->query("UPDATE users SET nama = :nama, email = :email, password = :password, no_hp = :no_hp, role = :role WHERE id = :id");
            $this->bind(':password', $password);
        } else {
            $this->query("UPDATE users SET nama = :nama, email = :email, no_hp = :no_hp, role = :role WHERE id = :id");
        }

        $this->bind(':nama', $nama);
        $this->bind(':email', $email);
        $this->bind(':no_hp', $no_hp);
        $this->bind(':role', $role);
        $this->bind(':id', $user_id);

        return $this->execute();
    }


    public function findByEmail($email)
    {
        $this->query("SELECT * FROM users WHERE email = :email");
        $this->bind(':email', $email);
        return $this->single();
    }

    public function getUserCount()
    {
        $this->query("SELECT COUNT(*) as total FROM users");
        return $this->single()['total'];
    }

    public function getAllUsers()
    {
        $this->query("SELECT * FROM users ORDER BY role ASC");
        return $this->resultSet();
    }

    public function deleteUser($id)
    {
        $this->query("DELETE FROM users WHERE id = :id");
        $this->bind(':id', $id);
        $this->execute();
    }
}
