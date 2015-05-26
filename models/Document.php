<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "document".
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $status
 *
 * @property File[] $files
 */
class Document extends \yii\db\ActiveRecord
{
    const STATUS_TEMP = 0;
    const STATUS_ACTIVE = 1;

    const SCENARIO_TEMP = 'temp';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'document';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required', 'on' => self::SCENARIO_DEFAULT],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'status' => 'Status'
        ];
    }

    /**
     * @inheritdoc
     * @return DocumentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DocumentQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['owner_id' => 'id']);
    }


    public function afterDelete() {
        $this->deleteDocumentFiles();
        parent::afterDelete();
    }

    protected function deleteDocumentFiles() {
        foreach ($this->files as $file) {
            $file->fileDelete();
        }
    }


    public function beforeSave($insert) {
        if ($this->getScenario() == self::SCENARIO_DEFAULT) {
            $this->status = self::STATUS_ACTIVE;
        }

        return parent::beforeSave($insert);
    }
}
