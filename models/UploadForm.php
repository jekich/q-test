<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class UploadForm
 */
class UploadForm extends Model
{
    /**
     * @var integer
     */
    public $ownerId;

    /**
     * @var UploadedFile|Null file attribute
     */
    public $file;

    /**
     * @var File
     */
    private $model;

    public function init()
    {
        parent::init();
        $this->model = new  File();
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'file'],
            [['ownerId'], 'integer']
        ];
    }

    public function save()
    {
        $result = false;

        if ($this->file && $this->validate()) {
            $result = true;
            $fileName = $this->generateName() . '.' . $this->file->extension;
            $path = File::getPath() . DIRECTORY_SEPARATOR . $fileName;

            if (!$this->file->saveAs($path)) {
                $result = false;
            }

            if ($result) {
                $this->model->name = $fileName;
                $this->model->original_name = $this->file->baseName . '.' . $this->file->extension;
                $this->model->owner_id = $this->ownerId;
                $this->model->size = $this->file->size;
                $this->model->is_image = $this->isImage($path);

                if (!$this->model->save()) {
                    if (file_exists($path)) {
                        unlink($path);
                    }
                    $result = false;
                }
            }

        }

        return $result;
    }

    public function getFileModel()
    {
        return $this->model;
    }

    private function generateName()
    {
        return md5(microtime());
    }


    public function isImage($filename) {
        $is = @getimagesize($filename);

        if ( !$is )
            return false;
        else
            return true;
    }
}