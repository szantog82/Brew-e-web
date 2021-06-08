<?php
class Get_shops_model{

public function main(){
        $d = new Database;
        $conn = $d->get_connection();
            try
            {
                $query = "select city, description, email, id, lat_coord, lon_coord, name, postalcode, street, tax_num from kavehaz where is_active = 1";
                $shops = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
            }
            catch(Exception $e)
            {
                print_r($e);
            }
        return $shops;
}
}
?>