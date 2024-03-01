<?php

namespace App\Services\Model;

enum UserType: int {
    case ADMIN = 1;
    case WARGA = 2;
}
