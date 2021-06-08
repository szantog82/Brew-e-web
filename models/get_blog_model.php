<?php
class Get_blog_model{

public function main($shop_id){
        $d = new Database;
        $conn = $d->get_connection();
            try
            {
                if ($shop_id == -1){
                 $query = "select b.id, title, text, upload_date, name as shop_name from blog as b inner join kavehaz on b.shop_id = kavehaz.id order by upload_date desc";   
                } else {
                 $query = "select b.id, title, text, upload_date, name as shop_name from blog as b inner join kavehaz on b.shop_id = kavehaz.id where shop_id = " . $shop_id . " order by upload_date desc";   
                }
                $items = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
            }
            catch(Exception $e)
            {
                print_r($e);
            }
        return $items;
}
}
?>