<?php

namespace backend\modules\pubmed\models;

use Yii;

/**
 * This is the model class for table "ref_published".
 *
 * @property int $id
 * @property string $PMID
 * @property int $file_id
 */
class RefPublished extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_published';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_id'], 'integer'],
            [['PMID'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'PMID' => 'P M I D',
            'file_id' => 'File ID',
        ];
    }
}
