<?php
class View_model
{

    public function __construct($viewName, $url = 0)
    {
        $d = new Database;
        $conn = $d->get_connection();
        include_once ($_SERVER['DOCUMENT_ROOT'] . 'views/' . $viewName . '.php');
        $class = ucfirst($viewName);
        $view = new $class;

        switch ($viewName)
        {
            case 'main_page':
                $query = "select blog.id, text, title, upload_date, name as shop_name from blog inner join kavehaz where blog.shop_id=kavehaz.id";
                $data = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
                $view->main($data);
            break;
            case 'blog':
                $query = "select blog.id, text, title, upload_date, name as shop_name from blog inner join kavehaz where blog.shop_id=kavehaz.id and blog.id=" . $url[1];
                $data = $conn->query($query)->fetch(PDO::FETCH_ASSOC);
                $view->main($data);
            break;
            case 'drink_menu_edit':
                $query = "select * from itallap where shop_id=" . $_SESSION["id"];
                $items = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
                $query2 = "select distinct item_group from itallap where shop_id=" . $_SESSION["id"];
                $groups = $conn->query($query2)->fetchAll(PDO::FETCH_ASSOC);
                $view->main($items, $groups);
            break;
            case 'admin_main':
                $query = "select login, email, name, is_active from kavehaz";
                $shops = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
                $query2 = "select login, email, is_active, family_name, first_name from felhasznalo";
                $users = $conn->query($query2)->fetchAll(PDO::FETCH_ASSOC);
                $view->main($shops, $users);
                break;
            case 'show_own_blogs':
                $query = "select * from blog where shop_id=" . $_SESSION["id"];
                $blogs = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
                $view->main($blogs, $url[1]);
                break;
            case 'settings':
                $query = "select city, login, description, email, lat_coord, lon_coord, name, postalcode, street, tax_num from kavehaz where id=" . $_SESSION["id"];
                $shop_data = $conn->query($query)->fetch(PDO::FETCH_ASSOC);
                $view->main($shop_data);
                break;
            case 'get_orders':
                $query = "SELECT r.order_date, r.order_id, r.item_count, r.is_complete, f. id as user_id, f.family_name, f.first_name, f.email, f.login, i.item_name, i.item_price, i.id as item_id 
                FROM rendeles as r inner join itallap as i on r.item_id = i.id inner join felhasznalo as f on r.user_id = f.id where r.shop_id=" . $_SESSION["id"]. " order by order_date desc";
                $orders = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
                $view->main($orders);
                break;
            case 'broadcast':
                $view->main();
                break;
            default:
                $view->main();
                break;
        }
    }

}

?>
