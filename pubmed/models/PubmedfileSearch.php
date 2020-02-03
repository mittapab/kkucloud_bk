<?php

namespace backend\modules\pubmed\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\pubmed\models\Pubmedfile;
use yii\db\Query;

/**
 * PubmedfileSearch represents the model behind the search form of `backend\modules\pubmed\models\Pubmedfile`.
 */
class PubmedfileSearch extends Pubmedfile
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['file_name'], 'safe'],
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
        $query = null;
        //$sql = published::find()
        $sql= (new Query())
        ->select([
            'pubmedfile.id AS id',
            'pubmedfile.file_name AS file_name' ,
            'pubmedfile.file_size AS file_size' , 
            'pubmedfile.created_at AS file_created' , 
            'user.username AS username'])
        ->from('pubmedfile')
        ->leftjoin('user' , 'pubmedfile.create_by = user.id');
        // ->where('file_id');
           
        


        if(isset($params['term'])){
            $query = $sql
                ->where('pubmedfile.file_name LIKE :fileName OR pubmedfile.file_size LIKE :fileSize',[
                ':fileName' => "%{$params['term']}%",
                ":fileSize"=> "%{$params['term']}%",
               ]);
        }else{
            $query = $sql;//->all();//->with('user');
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
           
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'file_name', $this->file_name])
              ->andFilterWhere(['like', 'file_size', $this->file_name]);


        return $dataProvider;

        
    }
}
