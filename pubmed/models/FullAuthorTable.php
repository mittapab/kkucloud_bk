<?php

namespace backend\modules\pubmed\models;

use Yii;

/**
 * This is the model class for table "full_author_table".
 *
 * @property int $id
 * @property string $element
 * @property string $content
 * @property int $id_published
 */
class FullAuthorTable extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'full_author_table';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['id_published'], 'integer'],
            [['element'], 'string', 'max' => 255],
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
        ];
    }
}
