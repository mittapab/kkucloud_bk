<?php

namespace backend\modules\pubmed\models;

use Yii;

/**
 * This is the model class for table "utation".
 *
 * @property int $id
 * @property string $field
 * @property string $content
 * @property string $table_name
 * @property string $var_name
 * @property int $id_field
 * @property int $file_name
 */
class Utation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['field', 'content', 'table_name', 'var_name', 'id_publish', ], 'required'],
            [['content'], 'string'],
            [['id_field', 'file_name'], 'integer'],
            [['field', 'table_name', 'var_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'field' => 'Field',
            'content' => 'Content',
            'table_name' => 'Table Name',
            'var_name' => 'Var Name',
            'id_field' => 'Id Field',
            'file_name' => 'File Name',
        ];
    }
}
