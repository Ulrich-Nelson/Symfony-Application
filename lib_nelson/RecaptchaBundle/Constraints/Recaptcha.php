<?php

namespace Tapinfort\RecaptchaBundle\Constraints;

use Symfony\Component\Validator\Constraint;

// classe permettant de gérer la contrainte lors je l'éxécution du recaptcha
class Recaptcha extends Constraint
{
    public $message = "Captcha invalide";
}
