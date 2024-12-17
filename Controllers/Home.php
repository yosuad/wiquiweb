<?php

class Home extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }
    public function home($parems)
    {
        $this->views->getView($this, "home");
    }
}
