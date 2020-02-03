<?php

namespace backend\modules\pubmed\models;

use Yii;

/**
 * This is the model class for table "authors".
 *
 * @property string $id
 * @property string $element
 * @property string $content
 * @property string $id_published
 * @property string $create_date วันที่
 * @property int $create_by
 * @property string $type
 */
class Authors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'authors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_date'], 'safe'],
            [['create_by'], 'integer'],
            [['id', 'element', 'content', 'id_published'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'element' => 'Element',
            'content' => 'Content',
            'id_published' => 'Id Published',
            'create_date' => 'วันที่',
            'create_by' => 'Create By',
            'type' => 'Type',
        ];
    }
}
