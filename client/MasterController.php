<?php



class MasterController
{
    
    private $Api;
    private $CollectionView;
    private $Layout;
    
    
    function __construct($Api,$CollectionView)
    {
        $this->Api =$Api;
        $this->CollectionView = $CollectionView;
      }

function init()
{
   if($this->CollectionView->doesUserWantToCreateCollection())
   {
       $this->Api->createCollection($this->CollectionView->getCurrentCollectionKey());
       $this->CollectionView->refreshCurrentPage();
   } 
   // CREATE ARTIFACT
   else if($this->CollectionView->doesUserWantToGetArtifact())                   
   {
    $file = $this->CollectionView->getFile();
    $key = $this->CollectionView->getCurrentFileUploadCollectionKey();
    echo "HEJ";
    var_dump($file);
    $this->Api->createArtifact($file,$key);
    $this->CollectionView->refreshCurrentPage();
   }
   
   // DELETE ARTIFACT
   elseif($this->CollectionView->doesUserWantToDeleteArtifact()){
       
            $id = intval($this->CollectionView->getArtifactDeleteId());
            $this->Api->removeArtifact($id);
            $this->CollectionView->refreshCurrentPage();
        }
        elseif($this->CollectionView->doesUserWantToShareArtifact()){
            $id = intval($this->CollectionView->getShareArtifactId());
            $collectionKey = trim($this->CollectionView->getShareArtifactCollectionKey());
            $this->Api->shareArtifactWithCollection($id, $collectionKey);
            $this->CollectionView->refreshCurrentPage();
        }
        //DELETE COLLECTION
        elseif($this->CollectionView->doesUserWantToDeleteCollection()){
            $key = $this->CollectionView->getCollectionKeyToDelete();
            $this->Api->removeCollection($key);
            $this->CollectionView->refreshCurrentPage();
        }
        
       //UPDATE FILE
        elseif($this->CollectionView->doesUserWantToReplaceFile()){
            $id = $this->CollectionView->getFileReplaceId();
            $file = $this->CollectionView->getFileReplace();
            $this->Api->replaceArtifact($id, $file);
            $this->CollectionView->refreshCurrentPage();
        }
        
 
    
 
}
    
    
}
