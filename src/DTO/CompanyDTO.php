<?php

namespace App\DTO;

use App\Entity\Company;

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

    public function __construct($name = null, $address = null, $country = null, $city = null, $postalCode = null, $sector = null, $size = null, $website = null, $phoneNumber = null, $email = null, $type = null)
    {
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
