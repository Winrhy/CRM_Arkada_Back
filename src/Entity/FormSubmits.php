<?php

namespace App\Entity;

use App\Repository\FormSubmitsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\UuidV6 as Uuid;

#[ORM\Entity(repositoryClass: FormSubmitsRepository::class)]
class FormSubmits
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $data = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $submit_date = null;

    #[ORM\Column(length: 255)]
    private ?string $submit_ip = null;

    #[ORM\Column(length: 255)]
    private ?string $useragent = null;

    #[ORM\ManyToOne(inversedBy: 'formSubmits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Form $form_id = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(string $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function getSubmitDate(): ?\DateTimeImmutable
    {
        return $this->submit_date;
    }

    public function setSubmitDate(\DateTimeImmutable $submit_date): static
    {
        $this->submit_date = $submit_date;

        return $this;
    }

    public function getSubmitIp(): ?string
    {
        return $this->submit_ip;
    }

    public function setSubmitIp(string $submit_ip): static
    {
        $this->submit_ip = $submit_ip;

        return $this;
    }

    public function getUseragent(): ?string
    {
        return $this->useragent;
    }

    public function setUseragent(string $useragent): static
    {
        $this->useragent = $useragent;

        return $this;
    }

    public function getFormId(): ?Form
    {
        return $this->form_id;
    }

    public function setFormId(?Form $form_id): static
    {
        $this->form_id = $form_id;

        return $this;
    }
}
