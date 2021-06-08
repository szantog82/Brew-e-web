<?php class Mongodb_controller{

public function main(){
    echo "hello world";
    $uri = "mongodb://mongodb:" . "aa" . "@szantog82-shard-00-00.1dmlm.mongodb.net:27017,szantog82-shard-00-01.1dmlm.mongodb.net:27017,szantog82-shard-00-02.1dmlm.mongodb.net:27017/szantog82?ssl=true&replicaSet=atlas-zj6i4v-shard-0&authSource=admin&retryWrites=true&w=majority";
    
    try{
        $conn = new MongoClient();
        echo "hello world";
        $db = $conn->selectDB("demo");    
        print_r($db->listCollections());
    } catch (Exception $e){
        print_r($e);
    }
    
    //$db = $m->Recipes;
    //echo "hello world";
    
    
    $conn->close();
}

}
?>