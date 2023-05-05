<?php

namespace App\Services;


class EmailService
{
    protected $mailer;

    public function __construct()
    {
        $this->mailer = new class {
            public function send()
            {
                return true;
            }
        };
        //...
    }

    public function send($to, $subject, $body)
    {
        try {
            //...
            $this->mailer->send();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
