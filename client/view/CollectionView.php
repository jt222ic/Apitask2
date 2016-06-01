<?php


class CollectionView
{
    
    var $message;
    private static $GETCollectionKey = 'key';
    private static $POSTArtifactId = 'fileID';
    private static $POSTfile ='file';
    private static $POSTfileUpload = 'fileUpload';
    private static $POSTCreatecollection ='create';
    private static $POSTCollectionDelete = 'CollectionDelete';
    private static $POSTArtifactDelete = 'ArtifactDelete';
    private static $POSTShareArtifact = 'ShareArtifact';
    private static $POSTReplaceFile= 'ReplaceFile';
    private static $POSTReplaceFileUpload = 'ReplaceFileUpload';
    private static $POSTShareArtifactCollectionKey= 'ShareArtifactCollectionKey';
    private $api;
    
  function __construct($apiController)
  {
    $this->api = $apiController;
  }
    function renderPage()
    {
      $message = "";
      $collection;
      $currentCollection;
      $canCreateArtifact = true;
      
       // $this->api->test();
        $collection = $this->api->GetCollectionByKey($this->getCurrentCollectionKey());
        $currentCollection = $this->getCurrentCollectionKey();
        if($currentCollection == "home"){
            $canCreateArtifact = false;
        }
        
        
      $message .= '<form action="" method="POST">
                    <button type="submit" name="'. self::$POSTCreatecollection .'" value="'. $currentCollection .'">Create new collection</button>
                </form>';
                
                // Create Collection //
    $message .= "<h2>Collections</h2>";
    $message .= '<ul id="collections">';
       foreach($collection->Collections as $key){
            $message .='<li class="collection">
                        <a href="/?'. self::$GETCollectionKey .'='. $key .'">'.
                            $key
                        .'
                        </a>';
                        
                        // Delete COllection
             $message .= '<form action="" method="POST">
                <button type="submit" name="'. self::$POSTCollectionDelete .'" value="'.$key .'"> Delete</button>
                       </form>
                    </li>';
        }
   // artifact
            $message .= '<form action="" method="POST" enctype="multipart/form-data" id="createArtifact">
                        <h3>Upload artifact</h3>
                        <input type="file" name="'. self::$POSTfileUpload .'">
                        <button type="submit" name="'. self::$POSTfile .'" value="'.$currentCollection .'">Upload</button>
                    </form>';
            $message .= '<ul>';
            
            var_dump($POSTfile);
            
            
        $message .= "<h2>Artifacts</h2>";
        $message .= '<ul id="artifacts">';
        
        
        foreach($collection->Artifacts as $id){
            var_dump($collection->Artifacts);
            $message .= 'naaajJ';
            $artifact = $this->api->getArtifactById($id);
            $link = $this->api->getArtifactLink($artifact);
          //  $message .= "<li class='artifact'>";
            $message .= '<a href="'. $link.'">' . $artifact->name . '</a>';
            
            $message .= '<form action="" method="POST">
                        <button type="submit" name="'. self::$POSTArtifactDelete .'" value="'. $id .'"> Delete</button>
                        </form>';
            $message .= '<form action="" method="POST" enctype="multipart/form-data">
               
                        <button type="submit" name="'. self::$POSTShareArtifact .'" value="'. $id .'"> Share Artifact</button>
                        <input type="text" name="'. self::$POSTShareArtifactCollectionKey .'">
                        <br>
                        <br>
                        <input type="file" name="'. self::$POSTReplaceFileUpload .'">
                        <button type="submit" name="'. self::$POSTReplaceFile .'" value="'. $id .'">Replace</button>
                    </form>';
            $message .= "</li>";
        }
        $message .= '</ul>';
      return $message;
    }
    
    function GetFile()
    {
      return $_FILES[self::$POSTfileUpload];
    }
      function getCurrentFileUploadCollectionKey(){
        return $_POST[self::$POSTfile];
    }
      function doesUserWantToCreateCollection(){
       return isset($_POST[self::$POSTCreatecollection]);
      }
      
      function doesUserWantToGetArtifact()
      {
          return isset($_POST[self::$POSTfile]);
      }
      
     function getCurrentCollectionKey(){
        if(isset($_GET[self::$GETCollectionKey])){
            return $_GET[self::$GETCollectionKey];
        }
        return "home";
    }
     function refreshCurrentPage(){
        header("Location:/?". self::$GETCollectionKey . "=" . $this->getCurrentCollectionKey());
    }
    
    function doesUserWantToDeleteArtifact(){
        return isset($_POST[self::$POSTArtifactDelete]);
    }
    
   
     function getArtifactDeleteId(){
        return $_POST[self::$POSTArtifactDelete];
    }
     function doesUserWantToShareArtifact(){
        return isset($_POST[self::$POSTShareArtifact]);    
    }
    
    function getShareArtifactId(){
        return $_POST[self::$POSTShareArtifact];    
    }
    
    function getShareArtifactCollectionKey(){
        return $_POST[self::$POSTShareArtifactCollectionKey];    
    }
      function doesUserWantToDeleteCollection(){
        return isset($_POST[self::$POSTCollectionDelete]);    
    }
    function getCollectionKeyToDelete(){
        return $_POST[self::$POSTCollectionDelete];
    }
     function doesUserWantToReplaceFile(){
        return isset($_POST[self::$POSTReplaceFile]);
    } 
      function getFileReplaceId(){
        return $_POST[self::$POSTReplaceFile];
    }
     function getFileReplace(){
        return $_FILES[self::$POSTReplaceFileUpload];
    }
        
}