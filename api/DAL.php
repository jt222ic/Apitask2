<?php



class DAL
{
 private $dataPath = "api/data/";
 private $registryPath = "api/registry/";
 
    function saveCollections($collections){
        $str = serialize($collections);
        file_put_contents($this->registryPath."collections.regi", $str);
    }
    function getCollections()
    {
        if(file_exists($this->registryPath."collections.regi"))   
        {
           $str = file_get_contents($this->registryPath . "collections.regi");     
           $collection = unserialize($str); 
           if($collection == null){
               return array();
           }
           else{
           return $collection;
           }
         }
         return array();
    }
    function getArtifacts()
    {
        if(file_exists($this->registryPath."artifacts.regi"))   // existens of the file, registry path and the folder
        {
           $str = file_get_contents($this->registryPath . "artifacts.regi");      // get the string out of file bfuck
           $artifacts = unserialize($str);                                          // convert  string to object
           
           if($artifacts == null)
           {
              return array();
           }
           else 
           {
               return $artifacts;
           }
           
           }
        else
        {
            return array();
        }
    }
    
    function saveArtifacts($artifacts)
    {
        $str= serialize($artifacts);
        file_put_contents($this->registryPath."artifacts.regi",$str);
    }
    
    function removeFile($fileName){
        $file = $this->dataPath.$fileName;
        unlink($file);
    }
    
}