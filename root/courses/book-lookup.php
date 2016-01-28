<?php
    class BookLookup {
        
        public function __construct() {}
        
        public static function runGoogleBooksRESTCall($isbn) {
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, "https://www.googleapis.com/books/v1/volumes?q=isbn:".$isbn);
            $json_response = curl_exec($ch);
            curl_close($ch);
            
//            $json_response = file_get_contents();
//            var_dump($json_response);
            $lookup = json_decode($json_response, true);
            return $lookup;
        }
    }


?>