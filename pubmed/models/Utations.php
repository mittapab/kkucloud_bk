<?php

namespace backend\modules\pubmed\models;

use Yii;

/**
 * This is the model class for table "utations".
 *
 * @property int $id
 * @property string|null $field
 * @property string|null $content
 * @property string|null $table_name
 * @property string|null $var_name
 * @property int|null $id_published
 */
class Utations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'utations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['id_published'], 'integer'],
            [['field'], 'string', 'max' => 20],
            [['table_name', 'var_name'], 'string', 'max' => 255],
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
            'id_published' => 'Id Published',
        ];
    }
}
