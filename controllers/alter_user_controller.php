<?php
class Alter_user_controller
{
    private $model;
    
    private function init(){
        include_once ($_SERVER['DOCUMENT_ROOT'] . 'models/alter_user_model.php');
        $this->model = new Alter_user_model;   
    }

    public function main()
    { 
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION["access_id"] == 1)
        {
            $this->init();
            $this->model->change();
        } else if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $_SESSION["access_id"] == 1) {
            $this->init();
            $data = array();
            $incoming = file_get_contents("php://input");
            parse_str($incoming, $data);
            $shop_login = $data["login"];
            $this->model->delete($shop_login);
        }
    }
}

?>
