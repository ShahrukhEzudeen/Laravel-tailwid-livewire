<?php

namespace App\Class;

class UserDetail
{
    public int $id;
    public string $name;
    public string $email;
    public string $roles;

    public function __construct(int $id, string $name, string $email,string $roles)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->roles = $roles;
    }
}
