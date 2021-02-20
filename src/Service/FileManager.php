<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: Ros
 * Date: 13.9.2020 г.
 * Time: 13:08
 */

namespace App\Service;

use App\Entity\Image;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileManager
{

    /**
     * @var string
     */
    private $targetDir;

    /**
     * @var Filesystem
     */
    private $fileSystem;

    public function __construct(Filesystem $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    public function setTargetDir(string $targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $uploadedFile)
    {

        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = $originalFilename . '.' . $uploadedFile->guessExtension();

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


    public function deleteImage(Image $image)
    {
        $fileSystem = $this->fileSystem;
        $pathToImg = $this->getTargetDirectory() . $image->getName();

        $fileSystem->remove($pathToImg);
    }

    public function deleteAll()
    {
        $fileSystem = $this->fileSystem;
        $directory = $this->getTargetDirectory();
        $fileSystem->remove($directory);
    }
}