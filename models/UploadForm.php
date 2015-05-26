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
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'file'],
            [['ownerId'], 'integer']
        ];
    }

    public function save() {
        if ($this->file && $this->validate()) {

            $result = true;
            $fileName = $this->generateName() . '.' . $this->file->extension;
            $path = File::getPath() . DIRECTORY_SEPARATOR . $fileName;

            if (!$this->file->saveAs($path)) {
                $result = false;
            }

            if ($result) {
                $model = new File();
                $model->name = $fileName;
                $model->original_name = $this->file->baseName . '.' . $this->file->extension;
                $model->owner_id = $this->ownerId;
                if (!$model->save()) {
                    if (file_exists($path)) {
                        unlink($path);
                    }
                    $result = false;
                }
            }

        } else {
            $error = $this->getErrors();
        }

        return true;
    }


    private function generateName() {
        return md5(microtime());
    }
}