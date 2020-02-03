<?php

namespace backend\modules\pubmed\models;

use Yii;

/**
 * This is the model class for table "fields_tables".
 *
 * @property int $id
 * @property string $key
 * @property string $value
 */
class FieldsTables extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fields_tables';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key'], 'string', 'max' => 100],
            [['value'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'value' => 'Value',
        ];
    }
}
