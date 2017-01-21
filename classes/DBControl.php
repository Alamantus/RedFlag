<?php

/**
 * Created by PhpStorm.
 * User: rantenesse
 * Date: 1/20/2017
 * Time: 4:55 PM
 */
class DBControl
{
    private $db = '../resources/warner.db';
    public $results;
    public $results_count;

    public function query ($query_string) {
        $dbconnection = new PDO('sqlite:' . $this->db);
        $dbconnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbconnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
        $dbconnection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        try {
            $queryResults = $dbconnection->prepare($query_string);
            $queryResults->execute();
            $this->results = $queryResults;
            $this->results_count = count($queryResults->fetchAll());
            return true;
        }
        catch (PDOException $ex) {
            // echo $ex->getMessage();
            $this->results = null;
            $this->results_count = null;
            return false;
        }
    }
}