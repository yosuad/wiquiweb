<?php
class Landing extends Controllers {
    public function __construct() {
        parent::__construct();
    }

    public function landing() {
        $this->views->getView($this, "landing");
    }
}
?>
