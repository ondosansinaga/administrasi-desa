<?php

namespace App\Services\Model;

use App\Models\Letter;

class LetterEntity
{
    private ?int $id;
    private ?string $title;

    public function __construct(?int $id = null, ?string $title = null)
    {
        $this->id = $id;
        $this->title = $title;
    }

    public static function fromLetter(Letter $letter): LetterEntity
    {
        return new LetterEntity(
            id: $letter->id,
            title: $letter->title,
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }


}
