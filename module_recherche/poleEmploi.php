
<?php

class PoleEmploi {
    
    const URL_TOKEN = 'https://entreprise.pole-emploi.fr/connexion/oauth2/access_token?realm=/partenaire';
    const URL_OFFRE =  'https://api.emploi-store.fr/partenaire/offresdemploi/v2/offres/search?accesTravailleurHandicape=true&entreprisesAdaptees=true&motsCles=';
    
    private static $API_CONNECTION = array(
        'grant_type' => 'client_credentials',
        'client_id' => 'PAR_workshop_359c674297048cfde9b37d65c8d3b3499b62ac87a2ce8e8a56b2afb9c2481b23',
        'client_secret' => '919ff61f4366eac87fde75865dd05d2bb846a857fb4a8abdbf51e5da3463b58f',
        'scope'=> 'application_PAR_workshop_359c674297048cfde9b37d65c8d3b3499b62ac87a2ce8e8a56b2afb9c2481b23 api_offresdemploiv2 o2dsoffre'
    );

    public function __construct(){

    }

    function getApi($methode,$token ='',$motCles=''){
        $curl = curl_init();
        switch ($methode) {
            case 'POST':
                $optionHeader = array(
                    "Content-type: application/x-www-form-urlencoded",
                );
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(self::$API_CONNECTION)); 
                curl_setopt($curl, CURLOPT_URL, self::URL_TOKEN);
                break;
            case 'GET':
                $auth = 'Bearer '.$token;
                $optionHeader = array(
                    'Authorization: '.$auth,
                    'Accept: application/json',
                    'Content-Type: application/json'       
                );
                $urlGet = self::URL_OFFRE.urlencode($motCles);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($curl, CURLOPT_URL, $urlGet);
                break;
        }
        curl_setopt($curl, CURLOPT_HEADER,true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $optionHeader);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($curl);
        $error = curl_error($curl);
        $result = array( 'header' => '',
                         'body' => '',
        );
        if ( $error != "" )
        {
            $result['curl_error'] = $error;
            return $result;
        }
       
        $header_size = curl_getinfo($curl,CURLINFO_HEADER_SIZE);
        $result['header'] = substr($response, 0, $header_size);
        $result['body'] = substr( $response, $header_size );
        curl_close($curl);
        $data = json_decode($result['body'],true);
        print_r($data);

        return $data;   
    }

    function getOffres ($motCles){
        $data = $this->getApi('POST','');
        $token = $data["access_token"];
        $results = $this->getApi('GET',$token,$motCles);
        return $results['resultats'];
    }

}

?>


