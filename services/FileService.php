<?php

namespace app\services;

use app\models\File;
use Yii;
use yii\base\Exception;
use yii\web\UploadedFile;

class FileService
{
    private string $dirToCreate = '';
    private string $dir = '';

    public function __construct(string $type, int $id = null)
    {
        if ($type === 'task') {
            $this->dir = "/uploads/tasks/$id/";
        } elseif ($type === 'avatar') {
            $this->dir = "/uploads/avatars/$id/";
        }

        $this->dirToCreate = Yii::getAlias('@webroot') . $this->dir;
    }

    /**
     * Upload file to 2 directories: tasks files and avatar files
     * @param \yii\web\UploadedFile $uploadedFile
     * @param string $type
     * @param int|null $id
     * @return \app\models\File
     * @throws \yii\base\Exception
     */
    public function upload(UploadedFile $uploadedFile, string $type, int $id = null): File
    {
        if (!is_dir($this->dirToCreate)) {
            mkdir($this->dirToCreate);
        }

        $fileName = "$uploadedFile->baseName.$uploadedFile->extension";
        $url = "{$this->dir}{$fileName}";

        $uploadedFile->saveAs(Yii::getAlias('@webroot') . $url);

        $file = new File();
        $file->url = $url;

        if (!$file->save()) {
            throw new Exception('Не удалось сохранить файл');
        }

        return $file;
    }
}