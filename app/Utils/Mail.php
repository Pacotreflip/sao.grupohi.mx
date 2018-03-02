<?php

namespace Ghi\Utils;


use Illuminate\Support\Facades\Config;

class Mail extends \PHPMailer
{


    function __construct()
    {
        // echo "inicializando".Config::get('phpmailer.host');

        $this->IsSMTP();
        $this->Host = Config::get('phpmailer.host');
        $this->SMTPDebug = Config::get('phpmailer.debug');
        $this->SMTPAuth = Config::get('phpmailer.auth');
        $this->Port = Config::get('phpmailer.port');
        $this->Username = Config::get('phpmailer.username');
        $this->Password = Config::get('phpmailer.password');
    }


}

?>