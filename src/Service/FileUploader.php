<?php
/**
 * Created by PhpStorm.
 * User: Ros
 * Date: 13.9.2020 г.
 * Time: 13:08
 */

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{

    private $targetDir;


    public function setTargetDir(string $targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $uploadedFile)
    {

        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = $originalFilename .'.'. $uploadedFile->guessExtension();

        try {
            $uploadedFile->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            return $e;
        }

        return $fileName;

    }

    private function getTargetDirectory()
    {
        return $this->targetDir;
    }

}