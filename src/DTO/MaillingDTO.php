<?php

namespace App\DTO;

use App\Entity\Mail;

class MaillingDTO
{
    public string $from;
    public string $to;
    public string $subject = 'Arkada Studio';
    public string $template = 'signup.html.twig';
    public string $name;
    public string $body = '';
}
