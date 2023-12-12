<?php
// src/DTO/CompanyDTO.php

namespace App\DTO;

class CompanyDTO
{
    public $name;
    public $address;
    public $country;
    public $city;
    public $postalCode;
    public $sector;
    public $size;
    public $website;
    public $phoneNumber;
    public $email;
    public $type;

    public function __construct(
        string $name,
        string $address,
        string $country,
        string $city,
        string $postalCode,
        string $sector,
        int $size,
        ?string $website,
        ?string $phoneNumber,
        ?string $email,
        ?string $type
    ) {
        $this->name = $name;
        $this->address = $address;
        $this->country = $country;
        $this->city = $city;
        $this->postalCode = $postalCode;
        $this->sector = $sector;
        $this->size = $size;
        $this->website = $website;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
        $this->type = $type;
    }
}
