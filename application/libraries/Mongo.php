<?php
require 'vendor/autoload.php';

use MongoDB\Client;

class Mongo {

    public $client;
    public $db;

    public function __construct()
    {
        $this->client = new Client("mongodb://localhost:27017");
        $this->db = $this->client->doctorpatient;
    }
}