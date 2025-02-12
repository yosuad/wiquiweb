<?php

class Home extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }
    public function home()
    {
        $data['tag_page'] = "wiquiweb | Inicio";
        $data['page_title'] = "Págoma Principal";
        $data['page_name'] = "home";


        $this->views->getView($this, "home", $data);
    }
}
