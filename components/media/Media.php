<?php
/**
 * Created by PhpStorm.
 * User: smile
 * Date: 26.11.15
 * Time: 20:03
 */

namespace app\components\media;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use \yii\web\UploadedFile;

class Media extends Component
{

    public $uploadRoute = 'frontend/media/chunkUpload';

    public $handleRoute = 'frontend/media/handle';

    public $dropZone = false;

    public $tmpDirectory = '@app/web/uploads/tmp/';

    public $storageDirectory = '@app/web/uploads/storage/';

    public $storageUrl = '/uploads/storage/';

    public $maxFileSize = 30000000;

    public $maxChunkSize = 2000000;

    public $acceptMimeTypes = 'image/jpeg,image/png,video/avi,video/mp4,video/mpeg';

    const RANDOM_DIR_LENGTH = 2;

    /**
     * Initialize component options
     * @author Alex Makhorin
     */
    public function init()
    {
        $this->tmpDirectory = rtrim(Yii::getAlias($this->tmpDirectory), '/') . '/';
        $this->storageDirectory = rtrim(Yii::getAlias($this->storageDirectory), '/') . '/';
        $this->storageUrl = rtrim($this->storageUrl, '/') . '/';
    }

    /**
     * Saves file to a random folder
     * @param UploadedFile $fileData
     * @author Alex Makhorin
     */
    public function saveFileToStorage($fileData)
    {
        /*
        object(stdClass)[82]
          public 'name' => string 'SampleVideo_1080x720_20mb.mp4' (length=29)
          public 'size' => int 21069678
          public 'type' => string 'video/mp4' (length=9)
          public 'url' => string 'http://tims2.localhost/files/SampleVideo_1080x720_20mb.mp4' (length=58)
          public 'deleteUrl' => string 'http://tims2.localhost/index.php?imag=SampleVideo_1080x720_20mb.mp4' (length=67)
          public 'deleteType' => string 'DELETE' (length=6)
        */

//        'rename(
//                /home/makhorin/projects/tims2/httpdocs/web/uploads/tmp/SampleVideo_1080x720_20mb.mp4,
//                /home/makhorin/projects/tims2/httpdocs/web/uploads/storage/82/evi_3779ef3b): No such file or directory'

        $tmpFilePath = $this->tmpDirectory . $fileData->name;

        $randomDir = $this->generateRandomDirectory($fileData->name);
        $randomName = $this->generateRandomName();

        $newPath = $this->storageDirectory . $randomDir . '/' . $randomName;

        $this->createFolders($newPath);
        rename($tmpFilePath, $newPath);

        return $this->storageUrl . $randomDir . '/' . $randomName;
    }

    public function generateRandomDirectory($fileName, $length = self::RANDOM_DIR_LENGTH)
    {
        return substr(md5($fileName . time()) , 0, $length);
    }

    /**
     * Generate random file name
     * @param int $length
     * @return string
     * @author Alex Makhorin
     */
    private function generateRandomName($length = 8)
    {
        return 'evi_' . substr(md5(time() . mt_rand(0, 65535)), 0, $length);
    }

    /**
     * Create nested directories for a file
     * @param string $filePath
     * @author Alex Makhorin
     */
    private function createFolders($filePath)
    {
        $parts = explode('/', $filePath);
        // skip file name
        $parts = array_slice($parts, 0, count($parts) - 1);
        $targetPath = implode('/', $parts);
        $path = realpath($targetPath);

        if (!$path) {
            $oldmask = umask(0);
            mkdir($targetPath, 0777, true);
            umask($oldmask);
        }
    }
}