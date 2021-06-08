<?php
class Alter_shop_model
{
    private $conn;
    
    private function init(){
        $d = new Database;
        $this->conn = $d->get_connection();   
    }

    public function change()
    {
        $this->init();
        try
        {
            $this->conn->prepare("Update kavehaz set is_active=" . $_POST["active_value"] . " where login='" . $_POST["login"] . "'")->execute();
        }
        catch(Exception $e)
        {
            print_r($e);
        }

    }

    public function delete($shop_login)
    {
        $this->init();
        try
        {
            $this->conn->prepare("delete from kavehaz where login='" . $shop_login . "'")->execute();
        }
        catch(Exception $e)
        {
            print_r($e);
        }
    }
}
?>
