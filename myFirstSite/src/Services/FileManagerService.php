<?php

namespace App\Services;

use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileManagerService implements FileManagerServiceInterface
{
    private $postImageDirectory;
    
    public function getPostImageDirectory () 
    {
        return $this->postImageDirectory;

    }
    public function __construct($postImageDirectory)
    {
        $this->postImageDirectory = $postImageDirectory;
    }

    public function imagePostUpload (UploadedFile $file): string 
    {
        $fileName = uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->getPostImageDirectory(), $fileName);
        } catch (FileException $exeption) {
            return $exeption;
        }

        return $fileName;
    }

    public function removePostImage (string $fileName)
    {
        $fileSystem = new Filesystem();
        $fileImage = $this->getPostImageDirectory(). $fileName;
        try {
            $fileSystem->remove($fileImage);
        } catch (IOExceptionInterface $exeption) {
            echo $exeption->getMessage();
        }

    }

}