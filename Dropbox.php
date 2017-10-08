<?php

/**
 * phpDropbox class
 *
 * @author José Javier Fernández Mendoza <josejavierfm@gmail.com>
 * @version 1.0.0
 * @copyright Copyright (c), José Javier Fernández Mendoza. All rights reserved.
 * @license BSD License
 */



class phpDropbox{
    // current version
    const VERSION = '1.0.0';

    const API_URL = 'https://api.dropboxapi.com/';
    const API_CONTENT_URL = 'https://content.dropboxapi.com/';
    const TOKEN = 'xxxxxxxxxxxxxxxxxxxx';

    public function __construct()
    {
        
    }
    public function __destruct()
    {
        if($this->curl != null) curl_close($this->curl);
    }

    function MetadataDROPBOX($ruta){
            $api_url = self::API_URL.'2/files/get_metadata'; //dropbox api url
            

            $jsonv=json_encode(
                    array(
                        "path"=> "/".$ruta,
                         "include_media_info"=>false,
                         "include_deleted"=> false,
                         "include_has_explicit_shared_members"=> false
                    )
                );
            $headers = array('Authorization: Bearer '. self::TOKEN,
                'Content-Type: application/json'
                

            );

            $ch = curl_init($api_url);

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POST, true);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonv);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
           
            

            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            //echo($http_code.'<br/>');


            curl_close($ch);
            return $response;
    }

    function FicherosDROPBOX($ruta){
            $api_url = self::API_URL.'2/files/list_folder'; //dropbox api url
            

            $jsonv=json_encode(
                    array(
                         "path"=> "/".$ruta,
                         "recursive"=> false
                    )
                );
            $headers = array('Authorization: Bearer '. self::TOKEN,
                'Content-Type: application/json'
                

            );

            $ch = curl_init($api_url);

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POST, true);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonv);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
           
            

            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            //echo($http_code.'<br/>');


            curl_close($ch);
            return $response;
    }

    function SubirDROPBOX($fichero,$carpetalocal="",$carpetaDropbox=""){
            $api_url = self::API_CONTENT_URL.'2/files/upload'; //dropbox api url
            if ($carpetaDropbox!=""){
                $carpetaDropbox="/".$carpetaDropbox;
            }
            $jsonv=json_encode(
                    array(
                        "path"=> $carpetaDropbox.'/'. basename($fichero),
                        "mode" => "add",
                        "autorename" => true,
                        "mute" => false
                    )
                );
            //echo $jsonv;
            $headers = array('Authorization: Bearer '. self::TOKEN,
                'Content-Type: application/octet-stream',
                'Dropbox-API-Arg: '.$jsonv
                

            );

            $ch = curl_init($api_url);

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POST, true);

            $path = $carpetalocal.'/'.$fichero;
            $fp = fopen($path, 'rb');
            $filesize = filesize($path);
            //echo $filesize;

            curl_setopt($ch, CURLOPT_POSTFIELDS, fread($fp, $filesize));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //curl_setopt($ch, CURLOPT_VERBOSE, 1); // debug

            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            //echo($response.'<br/>');
            //echo($http_code.'<br/>');


            curl_close($ch);
            if ($http_code=="200"){
                return true;
            }else{
                return false;
            }
    }

}