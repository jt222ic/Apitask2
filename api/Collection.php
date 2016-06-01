<?php

class Collection
{
    public $isHome;
    public $keys;
    public $Ids;

public $Collections = array();    // <---KEys
public $Artifacts = array();      //<---Ids


function __construct($keys, $isHome)
{
    $this->keys = $keys;
    $this->isHome = $isHome;
}

function addCollection($key)
{
    $this->Collections[] = $key;
}

function addArtifacts($Ids)
{
    $this->Artifacts[] = $Ids;
}
}