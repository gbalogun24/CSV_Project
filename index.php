<?php

$csv = "/home/gafar/PhpstormProjects/CSV_new/file.csv";

main::Program($csv);


class  main {

    public static function Program($csv){
        $csvrecords = CSVCommands::readCSV($csv);
        print_r($csvrecords);
    }
}


//Class for csv record object
class csvrecord{

    public function _contruct(Array $fieldnames, $values){
        $this->getProperties(fieldnames,values);
    }

    public function getProperties($fieldname, $value){
        $this->{$fieldname} = $value;
    }

}

//Record factory
class csvrecordsFactory{

//Function to create array of records
    public static function createCSVRecords(Array $fieldnames, $values){
        $csvrecords = new csvrecord($fieldnames, $values);
        print_r($csvrecords);
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
            if($count == 0){
                $fieldnames = $readfile;
            }
            else{
                $csvrecords[] = csvrecordsFactory::createCSVRecords($fieldnames, $csvtext);
            }
            // $csvrecords[] = $csvtext;
            $count++;
        }
        fclose($readfile);
        return $csvrecords;
    }
}

?>