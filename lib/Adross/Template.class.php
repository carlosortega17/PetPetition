<?php
namespace Adross;
class Template
{
    private $body;
    
    public function __construct($path, $context=[])
    {
        $body = $this->ChargeTemplate($path, $context);
        extract($context);
        ob_start();
        include("views/templates/main.html");
        $this->body = ob_get_clean();        
    }

    public function ChargeTemplate($path, $context)
    {
        extract($context);
        ob_start();
        include($path);
        return ob_get_clean();
    }

    public function __toString()
    {
        return $this->body;
    }
}