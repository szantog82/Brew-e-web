<?php
class Blog_upload_model
{

    public function main()
    {
        $title = $_POST["blog_title"];
        $text = $_POST["blog_text"];

        if (strlen($title) < 3 || strlen($text) < 3)
        {
            return 0;
        }
        else
        {
            $d = new Database;
            $conn = $d->get_connection();
            
             $data = ['shop_id' => $_SESSION["id"],
                    'text' => $text,
                    'title' => $title, 
                    'upload_date' => time()
                    ];

            try
            {
                $sql = "insert into blog (shop_id, text, title, upload_date) values (:shop_id, :text, :title, :upload_date)";
                $conn->prepare($sql)->execute($data);
                return 1;
            }
            catch(Exception $e)
            {
                print_r($e);
            }
        }
    }
}

?>