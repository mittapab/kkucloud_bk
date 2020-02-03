<?php

namespace backend\modules\pubmed\models;

use Yii;

/**
 * This is the model class for table "issn_table".
 *
 * @property int $id
 * @property string $element ชื่อย่อ
 * @property string $content รายละเอียด
 * @property int $id_published
 */
class IssnTable extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'issn_table';
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
            'element' => 'ชื่อย่อ',
            'content' => 'รายละเอียด',
            'id_published' => 'Id Published',
        ];
    }
}
