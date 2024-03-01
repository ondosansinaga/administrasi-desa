<?php

namespace App\Services\Model;

use App\Models\RequestLetter;

class RequestLetterEntity
{
    private ?int $id;
    private ?int $userId;
    private ?int $letterId;
    private ?int $status;
    private ?string $docUrl;
    private ?string $dateRequest;
    private ?string $dateStatus;
    private ?UserEntity $user;
    private ?LetterEntity $letter;

    public function __construct(
        ?int          $id = null,
        ?int          $userId = null,
        ?int          $letterId = null,
        ?int          $status = null,
        ?string $docUrl = null,
        ?string       $dateRequest = null,
        ?string       $dateStatus = null,
        ?UserEntity   $user = null,
        ?LetterEntity $letter = null,
    )
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->letterId = $letterId;
        $this->status = $status;
        $this->docUrl = $docUrl;
        $this->dateRequest = $dateRequest;
        $this->dateStatus = $dateStatus;
        $this->user = $user;
        $this->letter = $letter;
    }

    public static function fromRequestLetter(RequestLetter $requestLetter): RequestLetterEntity
    {
        $user = UserEntity::fromUser($requestLetter->user);
        $letter = LetterEntity::fromLetter($requestLetter->letter);

        return new RequestLetterEntity(
            id: $requestLetter->id,
            userId: $requestLetter->user_id,
            letterId: $requestLetter->letter_id,
            status: $requestLetter->status,
            docUrl:$requestLetter->doc_url,
            dateRequest: $requestLetter->request_date,
            dateStatus: $requestLetter->status_date,
            user: $user,
            letter: $letter,
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDocUrl(): ?string
    {
        return $this->docUrl;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getLetterId(): ?int
    {
        return $this->letterId;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function getDateRequest(): ?string
    {
        return $this->dateRequest;
    }

    public function getDateStatus(): ?string
    {
        return $this->dateStatus;
    }

    public function getUser(): ?UserEntity
    {
        return $this->user;
    }

    public function getLetter(): ?LetterEntity
    {
        return $this->letter;
    }

}
