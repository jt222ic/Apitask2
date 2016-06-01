

<?php
require_once("api/Artifact.php");
require_once("api/Collection.php");
require_once("api/DAL.php");

class ApiController
{
    private $artifactPath = "api/data/";
    private $collectionHomeKey = "home";    // source folder instead of c: told by Michael
    private $artifacts = array();
    private $collections = array();
    private $DAL;
      
    function __construct()
    {
  $this->DAL = new DAL();
  $this->collections = $this->DAL->getCollections();
  $this->artifacts = $this->DAL->getArtifacts();
  
    }
    function test()
    {
        echo "BAJS";
    }
    function CreateArtifact($file, $collectionKey)
    {
        $name = $file['name'];
        
        $fileName = md5($name.rand()).'.'.pathinfo($name,PATHINFO_EXTENSION);   //reading on hash on strings to return empty strings //return information file Path
        $path = $this->artifactPath.$fileName;                                  // path way addition to the name of the file 
        
        if(move_uploaded_file($file['tmp_name'],$path))
        {
            $id = 0;
            foreach($this->artifacts as $artifact)                   // foreach each in array start id with 0, if tmp file does not exist, if yes add another id 
            { 
                if($this->artifact->id >$id)
                {
                $id = $artifact->id;
                
                var_dump($id);
                }
            }
        $id++;
        $this->artifacts = new Artifact($id,$fileName, $name);                           // saving to dataACCESS, with the artifact and id
        $this->DAL->addArtifacts($id);
        
        $this->collection = $this-GetCollectionByKey($collectionKey);
        $this->collection->addArtifacts($id);
        $this->DAL->saveArtifact($this->artifacts); 
        $this->collection->saveCollections($this->collection);                     // saving the collection 
        
        return true;
    }
    else 
    {
     return false;
    }
    
  } 
  //  Write collection key to create collection
  // USE "HOME" as Root directory for all collection
  function createCollection($collectionKey){
        $key = md5(rand());
        $exists = true;
        while($exists){
            $exists = false;
            $key = md5(rand());
            foreach($this->collections as $collection){
                if($key == $collection->key){
                    $exists = true;
                }
            }
        }
        if($collectionKey === $this->collectionHomeKey){
            $this->collections[] = new Collection($key, true);
        }
        else{
            $this->collections[] = new Collection($key, false);
            foreach($this->collections as $collection){
                if($collection->key == $collectionKey){
                    $collection->addCollection($key);
                }
            }
        }
        $this->DAL->saveCollections($this->collections);
    }
    function GetCollectionByKey($collectionKey)                //sending collection key  "home"
    {
       if($collectionKey == $this->collectionHomeKey)
       {
           $tempCollection = new Collection("home",true);
           foreach($this->collections as $collection)
           {
               
               if($collection->isHome == true)             
               {
                   $tempCollection->addCollection($collection->key);
               }
            }
           return $tempCollection;                                    // return temporary collection with key
       }
       else
       {
           foreach($this->collections as $collection)             // if false return the  normally collection
           {
               return $collection;
           }
       }
    }
    function getArtifactLink($artifact){
        return $this->artifactPath . $artifact->fileName;
    }
    
     function getArtifactById($artifactId){
        foreach($this->artifacts as $artifact){
            if($artifact->id == $artifactId){
                return $artifact;
            }
        }
     }
    function removeArtifact($artifactId)
    {
      $artifact = $this->getArtifactById($artifactId);
      foreach($this->collections as $collection)
      {
          foreach($collection->artifacts as $index => $artifacting)   //foreaching through collection instead of for looping to use => to create a new array artifacing 
          {
              
              if($artifacting == $artifactId)
              { 
                  unset($collection->artifact[$index]);             // remove by the index value location
              }
          }
      }
        foreach($this->artifacts as $index => $artifacting){
            if($artifacting->id == $artifactId){
                unset($this->artifacts[$index]);
            }
    }
        $this->DAL->saveCollections($this->collections);
        $this->DAL->saveArtifacts($this->artifacts);
        $this->DAL->removeFile($artifact->fileName);
}
 function removeCollection($collectionKey){
        $collection = $this->getCollectionByKey($collectionKey);
        
        //REMOVE COLLECTIONS IN COLLECTIONS
        foreach($collection->collections as $index => $key){
            $this->removeCollectionInCollection($key);
            unset($collection->collections[$index]);
            $this->removeCollectionByCollectionId($key);
        }
        
        //REMOVE THIS COLLECTION
        $this->removeCollectionByCollectionId($collectionKey);
        
        //CLEAN UP ARTIFACTS
        foreach($this->artifacts as $index => $artifact){
            $count = 0;
            foreach($this->collections as $tempcollection){
                foreach($tempcollection->artifacts as $id){
                    if($artifact->id == $id){
                        $count++;
                    }
                }
            }
            if($count <= 0){
                unset($this->artifacts[$index]);
                $this->DAL->removeFile($artifact->fileName);
            }
        }
        //REMOVE THIS COLLECTION IN OTHER COLLECTIONS
        foreach($this->collections as $collection){
            foreach($collection->collections as $index => $key){
                if($collectionKey == $key){
                    unset($collection->collections[$index]);
                }
            }
        }
        
        $this->DAL->saveCollections($this->collections);
        $this->DAL->saveArtifacts($this->artifacts);
    }
    
function removeCollectionByCollectionId($collectionKey)
{
    foreach($this->collections as $index => $collection)
{
    if($collection->key == $collectionKey)
    {
        unset($this->collection[$index]);
    }
    $this->DAL->saveCollections($this->collections);
}

}
function removeCollectionInCollection($collectionKey)
{
    $collection = $this->getCollectionByKey($collectionKey);
    foreach($this->collection->collections as $index => $key)
    {
    $collection = $this->getCollectionByKey($collectionKey);
    unset($collection->collections[$index]);
    $this->removeCollectionInCollectionId($collectionKey);
    }
    $this->DAL->saveCollections($this->collection);
}
function shareArtifactWithCollection($artifactId, $collectionKey){
        //Dela en existerande artifact med en till collection
        //(lägg till artifactID till collectionKey I registret)
        $collection = $this->getCollectionByKey($collectionKey);
        $collection->addArtifact($artifactId);
        $this->DAL->saveArtifacts($this->artifacts);
        $this->DAL->saveCollections($this->collections);
    }
    
   // UPDATE//

function replaceArtifact($artifactId,$file)
{
    $artifact = $this->getArtifactById($artifactId);
    
    $this->DAL->removeFile($artifact->fileName);
    $artifact->name =$file["name"];
    
    $path = $this->artifactPath.$artifact->fileName;
    
    
    if(move_uploaded_file($file['tmp_name'], $path))
    {
         $this->DAL->saveCollections($this->collections);
         $this->DAL->saveArtifacts($this->artifacts);
    }
}
}



