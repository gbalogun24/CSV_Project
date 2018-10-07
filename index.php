<?php

$csv = "/home/gafar/PhpstormProjects/CSV_new/file.csv";

main::Program($csv);


class  main {

    public static function Program($csv){
        $csvrecords = CSVCommands::readCSV($csv);
        $record = csvrecordsFactory::createCSVRecords();
        foreach($csvrecords as $records){
            $array = $records->createArray();
            print_r($array);
        }

    }
}


//Class for csv record object
class csvrecord{

    public function __construct(Array $fieldnames = null, $values=null){

        $record = array_combine($fieldnames,$values);
        foreach($record as $key=>$value){
            $this->getProperties($key,$value);
        }

    }

    public function createArray(){
        $array = (array) $this;
        return $array;
    }

    public function getProperties($fieldname = null, $value = null){
        $this->{$fieldname} = $value;
    }
}


//Record factory
class csvrecordsFactory{

//Function to create array of records
    public static function createCSVRecords(Array $fieldnames=null, $values=null){

        $csvrecords = new csvrecord($fieldnames, $values);
        return $csvrecords;
    }

}

//Class for CSV commands
class CSVCommands {

    //Read the csv file
    public static function readCSV($file){

        $readfile = fopen($file,"r");
        $fieldnames = array();
        $count = 0;
        //Loop through the file
        while (($csvtext = fgetcsv($readfile, 50000,",")) !== FALSE) {
            //Get the field names from the first line
            if($count == 0){
                $fieldnames = $csvtext;
            }
            //Get the values after
            else{
                $csvrecords[] = csvrecordsFactory::createCSVRecords($fieldnames, $csvtext);
            }
            $count++;
        }
        fclose($readfile);
        return $csvrecords;
    }

}


?>