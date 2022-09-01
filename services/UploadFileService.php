<?php

namespace app\services;

use app\models\File;
use Yii;
use yii\base\Exception;
use yii\web\UploadedFile;

class UploadFileService
{
    public function upload(UploadedFile $uploadedFile, string $type, int $id = null): File
    {
        if ($type === 'task') {
            $dir = "/uploads/tasks/$id/";
        }

        if ($type === 'avatar') {
            $dir = "/uploads/avatars/$id/";
        }

        $dirToCreate = Yii::getAlias('@webroot') . $dir;

        if (!is_dir($dirToCreate)) {
            mkdir($dirToCreate);
        }

        $fileName = "$uploadedFile->baseName.$uploadedFile->extension";
        $url = "{$dir}{$fileName}";

        $uploadedFile->saveAs(Yii::getAlias('@webroot') . $url);

        $file = new File();
        $file->url = $url;

        if (!$file->save()) {
            throw new Exception('Не удалось сохранить файл');
        }

        return $file;
    }
}