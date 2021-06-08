<?php
class Upload_order_controller
{

    public function main()
    {
       if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION["login"] != "")
        {
            include_once ($_SERVER['DOCUMENT_ROOT'] . 'models/upload_order_model.php');
            $model = new Upload_order_model;
            $success = $model->main();
            
            $data = array(
              'success' => $success,
              'session_id' => session_id()
              );
            echo json_encode($data);
      } else {
          $data = array(
              'success' => 0,
              'session_id' => ""
              );
            echo json_encode($data);
      }
    }

}

?>
