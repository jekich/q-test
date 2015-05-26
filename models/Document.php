<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "document".
 *
 * @property string $id
 * @property string $name
 * @property string $description
 *
 * @property File[] $files
 */
class Document extends \yii\db\ActiveRecord
{
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
            [['name'], 'required'],
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


}
