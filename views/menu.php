<?php
class Menu
{
    private $page;

    public function __construct($page)
    {
        $this->page = $page;
    }

    public function main($param = -1)
    {
        session_start();
?>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <style>
         @import url('https://fonts.googleapis.com/css2?family=Arima+Madurai:wght@900&display=swap');
         @import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap');
    
        html {
            position: relative;
            min-height: 100%;
        }
    
        img
        { 
            max-width: 600px;
            max-height: 480px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .jumbotron p {
            font-size: 18x;
            text-align: justify;
            margin-left: 60px;
            margin-right: 60px;
            line-height: 1.5;
            font-family: 'Open Sans', sans-serif;
        }
        
        .h2, h2 {
            font-size: 20px;
        }
        
        .h1, h1 {
            font-family: 'Arima Madurai', cursive;
        }
        
        h6 {
           font-size: 15px;
           margin: 20px;
        }
        
       .navbar-inverse .navbar-nav > li > a {
            color: white;
            font-family: 'Open Sans', sans-serif;
            font-weight: bold;
            font-size: 12px;
        }
        
        .container .navbar-brand, .navbar > .container-fluid .navbar-brand {
            font-family: 'Open Sans', sans-serif;
            text-transform: uppercase;
            color: white;
            font-weight: 600;
        }
        
    </style>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2">
  <title>Kavehazak</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>


<nav class="navbar navbar-inverse" role="navigation">
    <div class="container-fluid">
      <div class="navbar-header" style="margin-left: 10%"><a href="/" class="navbar-brand">Kavehazak</a>
      </div>

      <ul class="nav navbar-nav">
          <li><a href='/'>Fooldal</a></li>
          <li><a href='/about'>Rolunk</a></li>
          <li><a href='/kapcsolat'>Kapcsolat</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right" style="margin-right: 10%">
          <?php
        if (isset($_SESSION["access_id"]) && $_SESSION["access_id"] == 1)
        {
            echo "<li><a href='/admin'><span class='glyphicon glyphicon-tasks'></span> Admin</a></li>";
        }
?>
        <?php
        if (isset($_SESSION["login"]) && !empty($_SESSION["login"]))
        {
            $url = $_SESSION["access_id"] == 1 ? "/#" : "/settings";
            echo "<li><a href='" . $url . "' style='color: yellow; font-style: italic;'>Udvozollek, " . $_SESSION["login"]  . "</a></li>";
            if ($_SESSION["access_id"] == 2){
             echo "<li><a href='/blogfeltoltes'><span class='glyphicon glyphicon-edit'></span> Uj blog</a></li>";   
             echo "<li><a href='/show_own_blogs'><span class='glyphicon glyphicon-th-list'></span> Blogjaim</a></li>";
             echo "<li><a href='/drink_menu_edit'><span class='glyphicon glyphicon-glass'></span> Itallapom</a></li>";
             echo "<li><a href='/get_orders' style='color: cyan;'><span class='glyphicon glyphicon-cutlery'></span> Rendeléseim</a></li>";
             echo "<li><a href='/broadcast_edit'><span class='glyphicon glyphicon-envelope'></span> Körüzenet</a></li>";
            }

            echo "<li><a href='/kijelentkezes'><span class='glyphicon glyphicon-log-out'></span> Kijelentkezes</a></li>";
        }
        else
        {
            echo "<li><a href='#' style='color: yellow; font-style: italic;'>Vendeg</a></li>";
            echo "<li><a href='/bejelentkezes'><span class='glyphicon glyphicon-log-in'></span> Bejelentkezes</a></li>";
        }
?>
      </ul>
    </div>
  </nav>
 
<?php
    }

}

?>
