<html>
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
<?php

$csv = "test.csv";

main::Program($csv);

//Main Program
class  main {

    public static function Program($csv){
        $csvrecords = CSVCommands::readCSV($csv);
        CommonFunctions::PrintStatement((html::generateTable($csvrecords)));
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


class html{
    //Convert the object to an array
    public static function Convertarray($csvrecords){

        foreach($csvrecords as $records){
            $array = $records->createArray();
            $value[] = array_values($array);
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
        $header = "";
        $header .="<tr>";
        foreach($headers as $keys=>$values){
            $header.= "<th scope='col'>".$values."</th>";
        }
        $header.="</tr>";

        CommonFunctions::PrintStatement(self::generateTHead($header));
    }

    //Get the values of the arrays
    public static function getValues($records){
        foreach($records as $records){
            $array = $records->createArray();
            $row[] = array_values($array);
        }
        return $row;
    }
    //generate header
    public static function generateRows(Array $row){
        $rows = self::getValues($row);
        $data = "";
        foreach($rows as $value){
             $data.= "<tr>";
            foreach($value as $value1){
                $data .= "<td>".$value1."</td>";
            }
                $data.= "</tr>";
        }
        CommonFunctions::PrintStatement(self::generateTBody($data));
    }

    //Generate thead tags
    public static function generateTHead($html){
        $thead = "<thead>".$html."</thead>";
        print $thead;
    }
    //Generate tbody tags
    public static function generateTBody($html){
        $tbody = "<tbody>".$html."</tbody>";
        print $tbody;
    }
    //Generate entire table
    public static function generateTable($csvrecords){
        CommonFunctions::PrintStatement("<table class= 'table table-striped'>");

        self::generateHeader($csvrecords);
        self::generateRows($csvrecords);
        CommonFunctions::PrintStatement("</table>");
    }

}


class CommonFunctions{
    //function to print a variable
    public static function PrintStatement($print){
        print ($print);
    }
}

?>

</html>
