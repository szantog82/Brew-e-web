<?php
class Upload_order_model
{

    public function main()
    {

        $d = new Database;
        $conn = $d->get_connection();
        
        $uploaded_data = json_decode($_POST["bucket"], true);

        try
        {
            $max_id = $conn->query("select max(order_id) from rendeles")->fetchColumn();
            $date = time();

            foreach ($uploaded_data as $d)
            {

                $data = ['order_id' => $max_id + 1, 
                'item_id' => $d["item_id"],
                'item_count' => $d["item_count"],
                'user_id' => $_SESSION["id"], 
                'shop_id' => $d["shop_id"], 
                'order_date' => $date,
                'is_complete' => 0
                
                ];

                $sql = "insert into rendeles (order_id, item_id, item_count, user_id, shop_id, order_date, is_complete) values (:order_id, :item_id, :item_count, :user_id, :shop_id, :order_date, :is_complete)";
                $conn->prepare($sql)->execute($data);
            }
            return 1;
        }
        catch(Exception $e)
        {
            print_r($e);
            return 0;
        }
    }
}

?>
