<?php
class Kijelentkezes_controller{

public function main()
    {
      include_once ($_SERVER['DOCUMENT_ROOT'] . 'models/kileptet_model.php');
      $model = new Kileptet_model;
      $model->main();
      header('Location: /');
}
}
?>