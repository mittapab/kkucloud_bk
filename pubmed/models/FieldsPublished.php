<?php

namespace backend\modules\pubmed\models;

use Yii;

/**
 * This is the model class for table "fields_published".
 *
 * @property int $id
 * @property string|null $key
 * @property string|null $value
 */
class FieldsPublished extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fields_published';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key'], 'string', 'max' => 20],
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
