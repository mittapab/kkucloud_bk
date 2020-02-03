<?php

namespace backend\modules\pubmed\models;

use appxq\sdii\utils\VarDumper;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\pubmed\models\Utations;

/**
 * UtationSearch represents the model behind the search form of `app\models\Utation`.
 */
class UtationSearch extends Utation
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_publish', ], 'integer'],
            [['field', 'content', 'table_name', 'var_name'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Utations::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            // 'id_field' => $this->id_field,
            // 'file_name' => $this->file_name,
        ]);

        $query->andFilterWhere(['like', 'field', $this->field])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'table_name', $this->table_name])
            ->andFilterWhere(['like', 'var_name', $this->var_name]);

        return $dataProvider;
    }
}
