<?php

namespace App\Enums;

abstract class UserTypes
{
    const User = 1;
    const Moderator = 2;
    const Admin = 3;

    const LIST = [
        1 => "User",
        2 => "Moderator",
        3 => "Admin"
    ];
}
