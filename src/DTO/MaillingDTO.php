<?php

namespace App\DTO;

use App\Entity\Mail;

class MaillingDTO
{
    public string $from;
    public string $to;
    public string $subject = 'Arkada Studio';
    public string $template = 'signup.html.twig';
    public string $name = '';
    public string $body = '';
    public string $email_id;
    public string $password ='';
    public string $last_name = '';
    public string $token = '';
}
