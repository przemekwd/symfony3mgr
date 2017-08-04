<?php

namespace AppBundle\Service;

class AlbumCoverUploader extends FileUploader
{
    public function __construct($targetDir)
    {
        parent::__construct($targetDir);
    }
}