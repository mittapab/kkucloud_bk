<?php

namespace backend\modules\pubmed\models;

use Yii;

/**
 * This is the model class for table "pubmedfile".
 *
 * @property int $id ไอดีชื่อไฟล์
 * @property string|null $file_name ชื่อไฟล์
 */
class Pubmedfile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pubmedfile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'safe'],
            [['create_by'], 'integer'],
            [['file_name'], 'file' , 'extensions' => 'nbib','maxSize' => 512000, 'skipOnEmpty' => false],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_name' => 'File name',
            'created_at' => 'Crated date',
            'created_by'  => 'Create by',
        ];
    }
}
