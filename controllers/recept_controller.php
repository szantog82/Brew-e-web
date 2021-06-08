<?php
class Recept_controller
{

    private $success;

    public function main()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $url = $_POST["address"];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            if ($output == false) {
                $output = file_get_contents($url);
            }
            curl_close($ch);
            
            $title = "";
            $img = "";
            
            
            $dochtml = new DOMDocument();
            $dochtml->loadHTML(file_get_contents($url));

            //
            //For parsing title
            //
            $selector = "";
            $h1 = $dochtml->getElementsByTagName('h1');
            if (sizeof($h1) == 1) {
                $title = $h1[0]->nodeValue;
                $selector = "<h1";
            } else if (sizeof($h1) > 1){
                foreach ($h1 as $h) {
                    if (strpos($h->getAttribute('class'), 'title') !== false || strpos($h->getAttribute('class'), 'cim') !== false) {
                        $title = $h->nodeValue;
                        $selector = "<h1";
                    }
                }
                if (strlen($title) < 3) {
                    $title = $h1[0]->nodeValue;
                }
            } else {
                $h2 = $dochtml->getElementsByTagName('h2');
                $title = $h2[0]->nodeValue;
                $selector = "<h2";
            }
            
            
            //
            //For parsing and resizing image
            //
            $img_start_pos = strpos($output, $selector);
            $img_start_part = substr($output, $img_start_pos);
            $dochtml2 = new DOMDocument();
            $dochtml2->loadHTML($img_start_part);
            $imgs = $dochtml2->getElementsByTagName('img');
            $img = utf8_decode($imgs[0]->getAttribute('src'));
            //resizing
            $NEW_IMG_SIZE = 100;
            $img_data = getimagesize($img);
            $img_data_ratio_wh = $img_data[0] / $img_data[1];
            // Resample
            $resized_img = imagecreatetruecolor($NEW_IMG_SIZE, $NEW_IMG_SIZE / $img_data_ratio_wh);
            imagecopyresampled($resized_img, imagecreatefromjpeg($img) , 0, 0, 0, 0, $NEW_IMG_SIZE, $NEW_IMG_SIZE / $img_data_ratio_wh, $img_data[0], $img_data[1]);
            // Buffering
            ob_start();
            imagepng($resized_img);
            $contents =  ob_get_clean();
            $recipe_image = "data:image/png;base64," . base64_encode($contents);
            if (strlen($recipe_image) < 200) {
                $img_start_pos = strpos($output, "Hozzával");
                $img_start_part = substr($output, $img_start_pos);
                $dochtml2 = new DOMDocument();
                $dochtml2->loadHTML($img_start_part);
                $imgs = $dochtml2->getElementsByTagName('img');
                $img = utf8_decode($imgs[0]->getAttribute('src'));
                //resizing
                $NEW_IMG_SIZE = 100;
                $img_data = getimagesize($img);
                $img_data_ratio_wh = $img_data[0] / $img_data[1];
                // Resample
                $resized_img = imagecreatetruecolor($NEW_IMG_SIZE, $NEW_IMG_SIZE / $img_data_ratio_wh);
                imagecopyresampled($resized_img, imagecreatefromjpeg($img) , 0, 0, 0, 0, $NEW_IMG_SIZE, $NEW_IMG_SIZE / $img_data_ratio_wh, $img_data[0], $img_data[1]);
                // Buffering
                ob_start();
                imagepng($resized_img);
                $contents =  ob_get_clean();
                $recipe_image = "data:image/png;base64," . base64_encode($contents);
            }

            

            //
            //For parsing ingredients
            //
            $ingredients_pos = strpos($output, ">Hozzávalók");
            if ($ingredients_pos == false) {
                $ingredients_pos = strpos($output, "hozzávalók");    
            }
            if ($ingredients_pos == false) {
                $ingredients_pos = strpos($output, "Recept hozzávalók");    
            }
            if ($ingredients_pos == false) {
                $ingredients_pos = strpos($output, "Hozzávaló");    
            }
            if ($ingredients_pos == false) {
                $ingredients_pos = strpos($output, "Recept");    
            }
            $ingredients_part = substr($output, $ingredients_pos);
            if (strpos($ingredients_part, "script") < strpos($ingredients_part, "</p>") && strpos($ingredients_part, "script") < strpos($ingredients_part, "</li>")) {
                $ingredients_end_pos = strpos($ingredients_part, "script");
                $ingredients_part = substr($ingredients_part, 0, $ingredients_end_pos);
                $ingredients_part = preg_replace('/div[\sa-zA-Z"=\-\\:\;]*>/',"li>", $ingredients_part);
            } else {
                $ingredients_end_pos = strpos($ingredients_part, "</div>");
                if ($ingredients_end_pos < 30) {
                    $ingredients_ul_pos = strpos($ingredients_part, "</ul>");
                    $ingredients_end_pos = strpos($ingredients_part, "</div>", $ingredients_ul_pos);
                }
                $ingredients_end_alt_pos = strpos($ingredients_part, "Elkész");
                if ($ingredients_end_alt_pos && $ingredients_end_alt_pos < $ingredients_end_pos) {
                    $ingredients_part = substr($ingredients_part, 0, $ingredients_end_alt_pos);
                } else {
                    $ingredients_part = substr($ingredients_part, 0, $ingredients_end_pos);
                }
                 if (strpos($ingredients_part, "<li") == false) {
                    $ingredients_part = preg_replace('/p\s?[a-zA-Z \d\" \;:]*>/i',"li>", $ingredients_part);
                    $ingredients_part = preg_replace('/<br\s*\/>/i',"<br>", $ingredients_part);
                    $ingredients_part = preg_replace('/<br>/',"</li><li>", $ingredients_part);
                } else {
                     $ingredients_part = preg_replace('/<li[a-z A-Z = \"\-\_\d:;]*/',"<li",$ingredients_part);   
                }
            }
            $arr = str_split($ingredients_part);
            $i = 0;
            $last_ingredient_element = 0;
            $anchor = -1;
            $str = "";
            $ingredients = [];
            foreach ($arr as $a){
                if ($a == ">" && $arr[$i - 1] == "i" && $arr[$i - 3] == "<"){
                    $anchor = $i + 1;
                } else if ($a == '>' && $arr[$i - 1] == 'i' && $arr[$i - 3] == '/') {
                    if (strlen(strip_tags($str)) > 2){
                     $ingredients[] = preg_replace('/\s+/S', " ", strip_tags($str));   
                    }
                    $str = "";
                    $anchor = -1;
                    $last_ingredient_element = $i;
                }
                
                if ($anchor != -1 && $i >= $anchor){
                    $str .= $a;
                }
                
                $i++;
            }

            //
            //For parsing instructions
            //
            $offset = 0;
            $instructions_start_pos = strpos($output, ">Elkészítés:");
            $offset = 15;
            if (!$instructions_start_pos) {
               $instructions_start_pos = strpos($output, ">Elkészítése:"); 
               $offset = 16;
            }
            if (!$instructions_start_pos) {
               $instructions_start_pos = strpos($output, ">Elkészítés"); 
               $offset = 14;
            }
            $instructions_part = substr($output, $instructions_start_pos);
                           // echo $instructions_part;
            $arr_parse_end = str_split($instructions_part);
            $end_found = 0;
            $i = 0;
            foreach ($arr_parse_end as $a) {
                if ($i > 50 && $a == "v" && $arr_parse_end[$i - 1] == "i" && $arr_parse_end[$i - 2] == "d" && $arr_parse_end[$i - 3] == "<") {
                    $end_found--;    
                }
                if ($i > 50 && $a == "v" && $arr_parse_end[$i - 1] == "i" && $arr_parse_end[$i - 2] == "d" && $arr_parse_end[$i - 3] == "/" && $arr_parse_end[$i - 4] == "<") {
                    $end_found++;
                }
                if ($end_found > 0) {
                    break;
                }
                $i++;    
            }
            $instructions_part = substr($instructions_part, $offset, $i);
            //if there are no </li> elements, convert <p>-s to <li>-s
            if (!strpos($instructions_part, "<li")) {
                $instructions_part = preg_replace('/p\s?[a-zA-Z \d\" \;:]*>/',"li>", $instructions_part);
            }
            $arr = str_split($instructions_part);
            $instructions_str = "";
            $i = 0;
            $instructions_arr = [];
            if ($instructions_start_pos) {
            foreach ($arr as $a) {
                if ($arr[$i - 1] == '>' && $arr[$i - 2] == 'i' && $arr[$i - 4] == '/') {
                    if (strlen(strip_tags($instructions_str)) > 7){
                        $instructions_arr[] = preg_replace('/\s+/S', " ", strip_tags($instructions_str));   
                    }
                    $instructions_str = "";
                    //continue;
                }
                $instructions_str.= $a;
                $i++;
            }
             if (count($instructions_arr) < 1){
                $instructions_arr[] = strip_tags($instructions_str);
            }
            }
            if (empty($instructions_arr)) {
                $instr_new = substr($output, $ingredients_pos + $last_ingredient_element);
                $end_div_pos = strpos($instr_new, "</div>", 50);
                $instr_new = substr($instr_new, 0, $end_div_pos);
                //echo $instr_new;
                $dochtml5 = new DOMDocument();
                $dochtml5->loadHTML($instr_new);
                $ps = $dochtml5->getElementsByTagName('p');
                foreach ($ps as $p) {
                    if (strlen(utf8_decode($p->nodeValue)) > 7){
                        $instructions_arr[] = utf8_decode($p->nodeValue);   
                    }
                }
            }
            
            //
            //Classifications
            //
            $dairy_products = ["sajt", "tej", "tejföl", "tejszín", "tejszin", "parmezán", "túró", " vaj"];
            $meat_products = ["sertés", "marha", "baromfi", "tyúk", "csirke", "pulyka", "hús", " hal ", "ponty", "busa", "lazac", "oszriga", "kagyló", "csiga", "rák", "kolbász", "bacon", "felvágott", "sonka", "máj", "kacsa"];
            $gluten_products = ["liszt", "zab", "árpa", "rozs"];
            $egg_products = ["tojás"];
            $dairy = 0;
            $meat = 0;
            $egg = 0;
            $gluten = 0;
            $skip_gluten = false;
            $skip_dairy = false;
            
            foreach ($ingredients as $i) {
                
                if (strpos($i, "gluténmentes") != false || strpos($i, "GM") != false || strpos($i, "csicseriborsóliszt") != false || strpos($i, "sárgaborsóliszt") != false || strpos($i, "rizsliszt") != false || strpos($i, "kukoricaliszt") != false) {
                    $gluten = 0;   
                    $skip_gluten = true;
                }
                
                if (strpos($i, "vegán") != false || strpos($i, "vegan") != false || strpos($i, "kókusztej") != false || strpos($i, "növényi tej") != false || strpos($i, "zabtej") != false || strpos($i, "rizstej") != false || strpos($i, "tejmentes") != false) {
                    $dairy = 0;   
                    $skip_dairy = true;
                }
                
                if (!$skip_dairy){
                 foreach ($dairy_products as $d){
                    if (strpos($i, $d) != false) {
                        $dairy = 1;
                        break;
                    }
                }   
                }
                
                foreach ($meat_products as $m){
                    if (strpos($i, $m) != false) {
                        $meat = 1;
                        break;
                    }
                }
                
                foreach ($egg_products as $e){
                    if (strpos($i, $e) != false) {
                        $egg = 1;
                        break;
                    }
                }
                
                if (!$skip_gluten){
                    foreach ($gluten_products as $g){
                        if (strpos($i, $g) != false) {
                            $gluten = 1;
                            break;
                        }
                    }
                    
                }
            }

            
            //
            //Sending back datas
            //
            $data = array(
                "title" => $title,
                "ingredients" => $ingredients,
                "instructions" => $instructions_arr,//strip_tags($instructions_str),
                "img" => $recipe_image,
                "dairy" => $dairy,
                "meat" => $meat,
                "egg" => $egg,
                "gluten" => $gluten
                );
            
            print_r(json_encode($data, JSON_UNESCAPED_UNICODE));








        } else if ($_SERVER['REQUEST_METHOD'] === 'GET'){
            ?>
            <head>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
    .test_p:hover {
        background: yellow;
        cursor: pointer;
    }
    
    img {
        max-width: 250px;
        max-height: 250px;
    }
    
</style>

<script>
  $(document).ready(function() {
    $("#submit").click(function(e) {
        get_data($("#webcim").val());
      e.preventDefault();
    });
    $("#dropdown").change(function(){
     var selected = $(this).children("option:selected").val();
     get_data(selected);
     $("#webcim").val(selected);
    });
  });
  
  function get_data(url){
      $.ajax({
        url: "/recept",
        type: "POST",
        data: {
          address: url
        },
        success: function(data) {
            console.log(data);
            var data = JSON.parse(data);
            $("#response").empty();
            $("#response").append("<input type='checkbox' " + ((data.meat == 0) ? "checked" : "") + "> <label>Husmentes</label><br>");
            $("#response").append("<input type='checkbox' " + ((data.dairy == 0) ? "checked" : "") + "> <label>Tejmentes</label><br>");
            $("#response").append("<input type='checkbox' " + ((data.gluten == 0) ? "checked" : "") + "> <label>Glutenmentes</label><br>");
            $("#response").append("<input type='checkbox' " + ((data.egg == 0) ? "checked" : "") + "> <label>Tojasmentes</label><br>");
            $("#response").append("<h2>" + data.title + "</h2>");
            $("#response").append("<img src='" + data.img + "'/>");
            var ingredients = data.ingredients;
            var instructions = data.instructions;
            $("#response").append("<h4 style='margin-top: 20px'><u>Hozzavalok:</u></h4>");
            $("#response").append("<ul>");
            ingredients.forEach(function(item, index){
                $("#response ul").append("<li>" + item + "</li>");
            });
            $("#response").append("</ul>");
            $("#response").append("<h4 style='margin-top: 20px'><u>Elkeszites:</u></h4>");
            $("#response").append("<ol stype='margin-top: 10px'>");
            instructions.forEach(function(item, index){
                $("#response ol").append("<li>" + item + "</li>");    
            });
            $("#response").append("</ol>");
        }
      });
  };
</script>
<meta charset="UTF-8">
</head>
<body>
  <div class="container">
      <h1>Recept app tesztelő</h1>
      <h3>Teszt oldalak</h3>
      <select id="dropdown">
          <option>https://femina.hu/recept/parmezanos-fokhagymas-sult-sparga/</option>
          <option>https://receptneked.hu/sertes/sertes-szeletek/tepsis-sult-karaj/</option>
          <option>https://sobors.hu/receptek/tejszines-spargakremleves-recept/</option>
          <option>https://www.mindmegette.hu/rakott-krumpli.recept/</option>
          <option>https://www.nosalty.hu/recept/erdelyi-padlizsankrem-11-egyszeruen</option>
          <option>https://www.mindenmentes.hu/2020/09/edesburgonyas-brownie-glutenmentes-vegan-tene/</option>
          <option>https://prove.hu/vegan-juhturos-sztrapacska-tofuropogossal-glutenmentes-opcio/</option>
          <option>https://szatmariferi.blog.hu/2021/05/11/spargas_tarhonyasalata</option>
          <option>https://izeselet.hu/receptek/malnas-edesburgonya-brownie/</option>
          <option>http://chiliesvanilia.hu/2016/08/24/szuperropogos-rantott-csirke-husz-perc-alatt/</option>
          <option>https://www.fuszereslelek.hu/paprikakremleves-granatalmasziruppal/</option>
          <option>https://babramegy.blog.hu/2019/10/30/chikhirtma_gruz_safranyos_citromos_csirkeleves</option>
          <option>https://vegasztromania.blog.hu/2011/09/20/crumble_aka_morzsasuti_oszi_gyumolcsokkel</option>
          <option>https://steinerkristofreceptjei.blog.hu/2012/11/09/malai_kofta_indiai_zoldseggomboc_paradicsomos_kesudioszoszban</option>
      </select>
    <form class="form-group">
      <label>Webcim</label>
      <input type="text" id="webcim" class="form-control"><br>
      <input id="submit" type="submit">
    </form>
    <div id="response"></div>
  </div>
</body>

<?php

        }
    }

}

?>