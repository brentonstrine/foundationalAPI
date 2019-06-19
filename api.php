<?php

/* MOST SIMPLE API */

/*
 * Add functions to class Methods
 * currently, the script supports the call api.php/test
 * */

// respond as JSON
header("Content-Type: application/json");

$api =  new Api();
echo $api->result;


/**
 * Class Api
 */
class Api {

    /**
     * @var Methods
     */
    private $methodInstance;
    /**
     * @var false|string
     */
    public $result;

    /**
     * Api constructor.
     */
    function __construct() {
        // 1. transform request to method
        $finalFunction =$this->extractMethod();
        // 2. create instance of target class
        $this->methodInstance = new Methods();
        // 3. Call target-function
        $this->result = json_encode($this->methodInstance->$finalFunction());
    }

    /**
     * Transforms the request into the format methodFunction
     *
     */
    private function extractMethod(){
        // Step 1: transform URL into array
        $url_parts = explode('/',$_SERVER['REQUEST_URI']);
        // Step 2: Generate the function-string
        /*
         * Breakdown:
         *  - take the method and transform it to lowercase (e.g. GET-call = 'get'
         *  - take the last element of the array
         *  - clear away any possible parameters
         *  - capitalize the first letter
         * */
        return strtolower($_SERVER['REQUEST_METHOD']) . ucfirst(strtok(end($url_parts), '?'));
    }

}

/**
 * Class Methods
 */
class Methods{
    /**
     * @return array
     */
    function getTest(){
        return !empty($_GET) ? $_GET : ['test'=>'called without parameters'];
    }
}