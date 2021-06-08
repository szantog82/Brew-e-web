<?php
class Get_location_data_controller
{

    public function main()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $lon = $_POST["lon"];
            $lat = $_POST["lat"];
            $type = $_POST["type"];
            if ($type == "normal"){
                $url = "https://nominatim.openstreetmap.org/?addressdetails=1&q=" . $_POST["location"] .  "&format=json&limit=1";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_REFERER, 'http://www.szantog82.nhely.hu/regisztracio');
                $content = json_decode(curl_exec($ch), true);
                $output = array(
                    "lat" =>  $content[0]["lat"],
                    "lon" => $content[0]["lon"]
                    );
                print_r(json_encode($output));
            } else {
            $url = "https://nominatim.openstreetmap.org/reverse?format=xml&lat=" . $lat . "&lon=" . $lon . "&zoom=18&addressdetails=1";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_REFERER, 'http://www.szantog82.nhely.hu/regisztracio');
            $content = curl_exec($ch);
            $xml = simplexml_load_string($content);
            print_r(json_encode($xml->addressparts, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));}
        }
    }
}

?>