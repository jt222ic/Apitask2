<?php

class Artifact{
    

public $fileName;
public $id;
public $name;

function __construct($id,$fileName,$name)
{
    $this->id = $id;
    $this->fileName = $fileName;
    $this->name = $name;
}
}