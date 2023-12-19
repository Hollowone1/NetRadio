<?php

namespace radio\net\domaine\dto;

class EmissionDTO extends DTO
{
    public $id;

    public function __construct () {
        $this->id = 1;
    }

    public function toArray () {
        return [
            'id' => $this->id
        ];
    }
}