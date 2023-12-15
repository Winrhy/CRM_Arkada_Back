<?php

namespace App\DTO;

use App\Entity\Company;
use App\Form\Type\CompanyType;
use App\Service\CompanyService;



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

    
    /**
     * Maps the DTO properties to a Company entity.
     *
     * @param Company $company The company entity to map the properties to.
     */
    public function mapToEntity(Company $company): void
    {
        $company->setName($this->name);
        $company->setAddress($this->address);
        $company->setCountry($this->country);
        $company->setCity($this->city);
        $company->setPostalCode($this->postalCode);
        $company->setSector($this->sector);
        $company->setSize($this->size);
        $company->setWebsite($this->website);
        $company->setPhoneNumber($this->phoneNumber);
        $company->setEmail($this->email);
        $company->setType($this->type);
    }
}
