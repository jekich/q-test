<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "file".
 *
 * @property string $id
 * @property string $name
 * @property string $original_name
 * @property string $owner_id
 * @property string $deleted
 * @property string $is_image
 * @property string $size
 *
 * @property Document $owner
 */
class File extends \yii\db\ActiveRecord
{
    const UPLOAD_FOLDER = 'uploads';

    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'original_name', 'owner_id'], 'required'],
            [['owner_id', 'size'], 'integer'],
            [['name', 'original_name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['deleted', 'is_image'], 'boolean']
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
            'original_name' => 'Original Name',
            'owner_id' => 'Owner ID',
            'deleted' => 'Удален',
            'is_image' => 'Изображение',
            'size' => 'Размер'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(Document::className(), ['id' => 'owner_id']);
    }

    /**
     * @inheritdoc
     * @return FileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FileQuery(get_called_class());
    }

    public static function getPath() {
        return Yii::getAlias('@app') . DIRECTORY_SEPARATOR . self::UPLOAD_FOLDER;
    }

    public function getFilePath() {
        return self::getPath() . DIRECTORY_SEPARATOR . $this->name;
    }


    public function fileDelete() {
        $this->deleted= 1;
        return $this->save();
    }
}
