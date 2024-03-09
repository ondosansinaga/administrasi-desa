<?php

namespace App\Events;

use App\Services\Model\UserEntity;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserRegistered
{
    use Dispatchable, SerializesModels;

    public UserEntity $userEntity;

    /**
     * Create a new event instance.
     *
     * @param UserEntity $userEntity
     */
    public function __construct(UserEntity $userEntity)
    {
        $this->userEntity = $userEntity;
    }
}
