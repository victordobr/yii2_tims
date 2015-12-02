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

    public $previewDirectory = '@app/web/uploads/gallery';

    public $maxFileSize = 30000000;

    public $maxChunkSize = 2000000;

    public $acceptMimeTypes = 'image/jpeg,image/png,video/avi,video/mp4,video/mpeg';

    /**
     * Initialize component options
     * @author Alex Makhorin
     */
    public function init()
    {
        $this->tmpDirectory = rtrim(Yii::getAlias($this->tmpDirectory), '/') . '/';
        $this->previewDirectory = rtrim(Yii::getAlias($this->previewDirectory), '/') . '/';
    }

    /**
     * Add ne DB record for video. Save original video file to hard drive. Encode original video to new format.
     * @param UploadedFile $file
     * @param int $owner Id of a user who uploaded file
     * @return FileModel $item
     * @author Alex Makhorin
     */
    public function addVideo($file, $owner)
    {
//        //Create thumb frame
//        $ffmpeg = FFMpeg::create([
//            'timeout' => 0,
//        ]);
//        $video = $ffmpeg->open($this->tmpDirectory . $file->name);
//        $duration = $video->getStreams()->videos()->first()->get('duration');
//
//        $item = $this->createItemRecord(PlaylistType::VIDEO, $file, $owner, (int)$duration);
//        $this->createFolders($this->getFilePath($item->primaryKey,
//            $this->getFileName($item->file_name, $item->type, FileSize::RACK)));
//
//        $path = $this->getThumbPath($item);
//
//        $tags = $video->getStreams()->videos()->first()->get('tags');
//
//        $frameWidth = $this->previewDimension[0];
//        $frameHeight = $this->previewDimension[1];
//        if (!empty($tags['rotate']) && $tags['rotate'] == '90') {
//            $frameWidth = $this->previewDimension[1];
//            $frameHeight = $this->previewDimension[0];
//        }
//
//        $video
//            ->frame(TimeCode::fromSeconds(round($duration / 2)))
//            ->addFilter(new FrameSizeFilter($frameWidth, $frameHeight))
//            ->save($path);
//
//        //Add to queue
//        $this->addToQueue($item, $file->name);
//
//        return $item;
    }
}