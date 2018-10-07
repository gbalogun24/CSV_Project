<?php

//CSV file class
class CSV{


    public function _contruct($file){
        $this->csvfile = $file;
    }
//Function to return csv file
    public function getCSV(){
        return $this->csvfile;
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



?>