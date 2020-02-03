<?php

namespace backend\modules\pubmed\models;

use Yii;

/**
 * This is the model class for table "year_table".
 *
 * @property int $id
 * @property int $year
 */
class YearTable extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'year_table';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'year' => 'Year',
        ];
    }
}
