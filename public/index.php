<html>
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
<?php

$csv = "/home/gafar/PhpstormProjects/CSV_project/test.csv";

main::Program($csv);


class  main {

    public static function Program($csv){
        $csvrecords = CSVCommands::readCSV($csv);
        // print(html::convertArray($csvrecords));
        print(html::generateTable($csvrecords));

    }
}


//Class for csv record object
class csvrecord{

    public function __construct(Array $fieldnames = null, $values=null){

        $record = array_combine($fieldnames,$values);
        // print_r($record);
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


class html{

    public static function Convertarray($csvrecords){
        $statements= '$array = $keys->createArray(); $value[] = array_values($array);';
        //print_r($statements);
        foreach($csvrecords as $records){
            $array = $records->createArray();
            $value[] = array_values($array);
            // print_r($value);
        }
        return $array;
    }

    //Get the keys of the arrays
    public static function getKeys(Array $records){
        $array = self::Convertarray($records);
        $keys = array_keys($array);
        return $keys;
    }
    //generate header
    public static function generateHeader(Array $key){
        $headers = self::getKeys($key);
        print "<thead><tr>";
        foreach($headers as $keys=>$values){
            $header = "<th scope='col'>".$values."</th>";
            print ($header);
        }
        print "</tr></thead>";
    }

    //Get the values of the arrays
    public static function getValues($records){
        foreach($records as $records){
            $array = $records->createArray();
            $row[] = array_values($array);
            //       print_r($row);
        }
        return $row;
    }
    //generate header
    public static function generateRows(Array $row){
        $rows = self::getValues($row);
        //  print_r($rows);
        foreach($rows as $value){
            print "<tr>";
            foreach($value as $value1){
                $data = "<td>".$value1."</td>";
                print($data);
            }
            print "</tr>";
            // $newrow = self::generateTR($data);
        }
        //return $newrow;
    }

    public static function generateTR($html){
        $tr = "<tr>".$html."</tr>";
        print $tr;
    }

    public static function generateTHead($html){
        $thead = "<thead>".$html."</thead>";
        print $thead;
    }
    public static function generateTBody($html){
        $tbody = "<tbody>".$html."</tbody>";
        print $tbody;
    }
    public static function generateTable($csvrecords){
        print "<table class= 'table table-striped'>";

        self::generateTHead(self::generateTR(self::generateHeader($csvrecords)));
        self::generateTBody(self::generateTR(self::generateRows($csvrecords)));
        print "</table>";
    }

}


class CommonFunctions{
    //function to print a variable
    public static function PrintStatement($print){
        print ($print);
    }
    //function for a foreach loop
    public static function Loop($array, $action){
        foreach($array as $keys){
            eval($action);
        }
    }
}

?>

</html>
