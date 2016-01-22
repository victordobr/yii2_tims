<?php
/**
 * Media.php represents Media class file.
 * @author Alex Makhorin
 */

namespace app\components\media;

use app\models\File;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use \yii\web\UploadedFile;
use yii\web\HttpException;
use yii\helpers\Url;
use app\enums\FileType;
/**
 * Media class implements the component to handle media files.
 * @author Alex Makhorin
 */
class Media extends Component
{

    public $uploadRoute = 'frontend/records/chunkUpload';

    public $handleRoute = 'frontend/records/handle';

    public $dropZone = false;

    public $tmpDirectory = '@app/web/uploads/tmp/';

    public $storageDirectory = '@app/web/uploads/storage/';

    public $storageUrl = '/uploads/storage/';

    public $maxFileSize = 30000000;

    public $maxChunkSize = 2000000;

    public $acceptMimeTypes = 'image/jpeg,image/png,image/bmp,video/avi,video/mp4,video/mpeg,video/x-flv';

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
     * @param \stdClass $fileData, example:
     * object(stdClass)[82]
     *   public 'name' => string 'SampleVideo_1080x720_20mb (1).mp4' (length=33)
     *   public 'size' => int 21069678
     *   public 'type' => string 'video/mp4' (length=9)
     *   public 'extension' => string 'mp4' (length=3)
     *
     * @return int File record id
     * @author Alex Makhorin
     */
    public function saveFileToStorage($fileData)
    {
        $tmpFilePath = $this->tmpDirectory . $fileData->name;

        $randomDir = $this->generateRandomDirectory($fileData->name);
        $randomName = $this->generateRandomName();

        $newPath = $this->storageDirectory . $randomDir . '/' . $randomName . '.' . $fileData->extension;

        $this->createFolders($newPath);
        rename($tmpFilePath, $newPath);

        $url = $this->storageUrl . $randomDir . '/' . $randomName . '.' . $fileData->extension;

        if (strpos($fileData->type, 'video/') === 0) {
            $type = FileType::TYPE_VIDEO;
        } elseif (strpos($fileData->type, 'image/') === 0) {
            $type = FileType::TYPE_IMAGE;
        } else {
            is_file($newPath) && unlink($newPath);
            throw new HttpException(400, 'No data to handle');
        }

        $file = new File();
        $file->file_type = $type;
        $file->mime_type = $fileData->type;
        $file->url = $url;
        $isSaved = $file->save();
        if(!$isSaved) {
            throw new HttpException(500, 'DB error occured: ' . \yii\helpers\VarDumper::dumpAsString($file->getErrors()));
        }

        return $file->primaryKey;
    }

    public function assignFileToRecord($fileId, $recordId, $record_video_type)
    {
        $file = File::findOne($fileId);
        if(!$file) {
            throw new HttpException(500, 'No file found');
        }

        $file->record_id = $recordId;
        $file->record_file_type = $record_video_type;

        return $file->save(false);
    }

    /**
     * Generate random directory name based on file name
     * @param string $fileName
     * @param int $length
     * @return string
     * @author Alex Makhorin
     */
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

    public function createMediaUrl($fileRecord)
    {
        return !empty($fileRecord->url) ? Url::base(true) . $fileRecord->url : null;
    }
}