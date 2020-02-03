<?php

namespace backend\modules\pubmed\models;

use Yii;

/**
 * This is the model class for table "author_table".
 *
 * @property int|null $id
 * @property string|null $content
 * @property int|null $id_published
 */
class AuthorTable extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'author_table';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_published'], 'integer'],
            [['content'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'id_published' => 'Id Published',
        ];
    }
}
