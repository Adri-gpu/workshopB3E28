<html>
<head>
    <title>Directions</title>
    <link rel="stylesheet" href="directions.css">
</head>

<body>
<div class=container>
    <?php


        /**
         * base fullurl : https://maps.googleapis.com/maps/api/directions/json 
         * origin=Brooklyn 
         * destination=Queens 
         * mode=transit 
         * language = fr
         * transit_routing_preference = less_walking / fewer_transfers
         * key=AIzaSyB_hPyIm4QUJpav-aZCq6EcE3iMGNWZkJA
         */
         /**
          * TO-DO and improvements : 
          * Comment code
          * Add "call taxi" button when walking is needed
          * Integrate directions to the dashboard
          * Integrate detector to directions 
          *  -> have a car and want to drive ? travel_mode -> transit/others 
          *  -> can't walk ? transit_routing_preference -> less_walking / fewer_transfer
          * Optimize code -> make functions
          * Adapt generated directions text/layout for detected disabilities (bigger font, shorter instructions...)
          */
        $mode = "transit";//transit, car, train, bycicle
        $origin = $_POST['origin'];
        $destination = $_POST['destination'];
        $origin_LngLat = geoCode($origin);
        $destination_LngLat = geoCode($destination);
        $fullurl = "https://maps.googleapis.com/maps/api/directions/json?origin=".$origin_LngLat["lat"].",".$origin_LngLat["lng"]."&destination=".$destination_LngLat["lat"].",".$destination_LngLat["lng"]."&mode=".$mode."&language=fr&key=AIzaSyB_hPyIm4QUJpav-aZCq6EcE3iMGNWZkJA";
        $string = file_get_contents($fullurl); // get json content
        $decoded_route = json_decode($string, true); //json decoder 
        //echo $fullurl."<br/>";
        if(count($decoded_route["routes"]) != 0)
        {
            $json_steps = $decoded_route["routes"][0]["legs"][0]["steps"];
            $numsteps = 0;
            foreach ($json_steps as $key => $step) {
                $formatted_steps[$numsteps] = $step;
                $numsteps++;
            }
            foreach ($formatted_steps as $key => $step) {     
                if($step["travel_mode"]=="TRANSIT"){//If next step is transit mode
                    //unused $step["transit_details"]["line"]["vehicle"]["name"] vehicle name (train, bus...)
                    $line = null;
                    if(isset($step["transit_details"]["trip_short_name"])){
                        $line = " - Ligne : ".$step["transit_details"]["trip_short_name"];
                    }
                    echo "<a class=step>".$step["html_instructions"]." - Compagnie : "." ".$step["transit_details"]["line"]["agencies"][0]["name"].$line." - Arrêt : ".$step["transit_details"]["arrival_stop"]["name"]."</a><br/>";
    
                }else if($step["travel_mode"]=="WALKING"){//If next step is walking
                    $substeps = $step["steps"];
                    foreach ($substeps as $key => $substep) {
                        if(isset($substep["html_instructions"])){
                            echo "<a class=step>".$substep["html_instructions"]." puis continuer ".$substep["distance"]["value"]."m</a><br/>";
                        }else{
                            echo "<a class=step>".$step["html_instructions"]." (".$step["distance"]["value"]."m)</a><br/>";
                        }
                    }
                }    
            }
        }
        else
        {
            echo "Aucun chemin possible allant de " . $_POST['origin'] . " à " . $_POST['destination'];
        }

        function geoCode($address){
            /**
             * base url : https://maps.googleapis.com/maps/api/geocode/json?
             * sensor=false&
             * address=".$address."&
             * key=AIzaSyB_hPyIm4QUJpav-aZCq6EcE3iMGNWZkJA
             */
            $fullurl = "https://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=".$address."&key=AIzaSyB_hPyIm4QUJpav-aZCq6EcE3iMGNWZkJA";
            $geocode = file_get_contents($fullurl);
            $decoded_geocode = json_decode($geocode, true);
            $lngLat = $decoded_geocode["results"][0]['geometry']['location'];
            return $lngLat;
        }
    ?>
</div>

<?php

?>
</body>
</html>