<?php
class Logout_user_controller{

public function main()
    {
      include_once ($_SERVER['DOCUMENT_ROOT'] . 'models/logout_user_model.php');
      $model = new Logout_user_model;
      $model->main();
}
}
?>