<?php
class Modify_shop_params_model {

public function main(){
        $data = array(
            "id" => $_SESSION["id"],
            "city" => $_POST["city"],
            "description" => $_POST["description"],
            "name" => $_POST["name"],
            "postalcode" => $_POST["postalcode"],
            "street" => $_POST["street"],
            "tax_num" => $_POST["tax_num"],
            "lat_coord" => $_POST["lat_coord"],
            "lon_coord" => $_POST["lon_coord"]
            );
        
        $d = new Database;
        $conn = $d->get_connection();
        $query = "update kavehaz set city=:city, description=:description, lat_coord=:lat_coord, lon_coord=:lon_coord, postalcode=:postalcode, street=:street, tax_num=:tax_num, name=:name where id=:id";
        try{
        $conn->prepare($query)->execute($data);
        return 1;
        } catch (Exception $e){
            return 0;
        }
}
   
}

?>