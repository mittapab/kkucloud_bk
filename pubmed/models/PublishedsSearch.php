<?php

namespace backend\modules\pubmed\models;

use appxq\sdii\utils\VarDumper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\pubmed\models\Publisheds;
use backend\modules\pubmed\models\RefPublished;

/**
 * PublishedsSearch represents the model behind the search form about `backend\modules\pubmed\models\Publisheds`.
 */
class PublishedsSearch extends Publisheds
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['PMID', 'owner', 'status', 'date_last_revised', 'date_of_publication', 'title', 'abstract', 'copyright_Information', 'language', 'publication_type', 'date_of_electronic_publication', 'place_of_publication', 'journal_Title_abbreviation', 'journal_title', 'NLM_Unique_ID', 'subset', 'entrez_date', 'MeSH_date', 'create_date', 'publication_status', 'source'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
    public function search($params , $id)
    {
        $query = null;
    $sql = Publisheds::find()->where('file_id = :id' , [':id' => $id ]);
        if(isset($params['term'])){
            $query = $sql
                ->andwhere('PMID LIKE :pmid OR owner LIKE :owner OR title like :title OR abstract like :abstract',[
                ':pmid' => "%{$params['term']}%",
                ":owner"=> "%{$params['term']}%",
                ":title"=> "%{$params['term']}%",
                ":abstract" => "%{$params['term']}%",
            ]);
            //VarDumper::dump($query);
        }else{
            $query = $sql;
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

        $query->andFilterWhere(['like', 'PMID', $this->PMID])
            ->andFilterWhere(['like', 'owner', $this->owner])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'date_last_revised', $this->date_last_revised])
            ->andFilterWhere(['like', 'date_of_publication', $this->date_of_publication])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'abstract', $this->abstract])
            ->andFilterWhere(['like', 'copyright_Information', $this->copyright_Information])
            ->andFilterWhere(['like', 'language', $this->language])
            ///->andFilterWhere(['like', 'publication_type', $this->publication_type])
            ->andFilterWhere(['like', 'date_of_electronic_publication', $this->date_of_electronic_publication])
            ->andFilterWhere(['like', 'place_of_publication', $this->place_of_publication])
            ->andFilterWhere(['like', 'journal_Title_abbreviation', $this->journal_Title_abbreviation])
            ->andFilterWhere(['like', 'journal_title', $this->journal_title])
            ->andFilterWhere(['like', 'NLM_Unique_ID', $this->NLM_Unique_ID])
            ->andFilterWhere(['like', 'subset', $this->subset])
            ->andFilterWhere(['like', 'entrez_date', $this->entrez_date])
            ->andFilterWhere(['like', 'MeSH_date', $this->MeSH_date])
            ->andFilterWhere(['like', 'create_date', $this->create_date])
            ->andFilterWhere(['like', 'publication_status', $this->publication_status])
            ->andFilterWhere(['like', 'source', $this->source]);

        return $dataProvider;



        
    }

    public function searchAuthor($params , $id_published)
    {
    $query = null;
    ////Publisheds::find()->where(['in' , 'id' , $id_published])->all();

    $sql = Publisheds::find()->where(['in' , 'id' , $id_published]);
        if(isset($params['term'])){
            $query = $sql
                ->andwhere('PMID LIKE :pmid OR  title like :title OR abstract like :abstract',[
                ':pmid' => "%{$params['term']}%",
                ":title"=> "%{$params['term']}%",
                ":abstract" => "%{$params['term']}%",
            ]);
            //VarDumper::dump($query);
        }else{
            $query = $sql;
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

        // $query->andFilterWhere([
        //     'id' => $this->id,
        // ]);

        $query->andFilterWhere(['like', 'PMID', $this->PMID])
              ->andFilterWhere(['like', 'title', $this->title])
              ->andFilterWhere(['like', 'abstract', $this->abstract]);
       
        return $dataProvider;
        //return  $sql;
    }

    public function searchYear($params , $year)
    {
    $query = null;
  
    //Publisheds::find()->where('date_of_publication LIKE "%'.$_GET['year'].'%"' ,[':year' => $_GET['year']])->all();

    $sql = Publisheds::find()->where('date_of_publication LIKE "%'.$year.'%"');
        if(isset($params['term'])){
            $query = $sql
                ->andwhere('PMID LIKE :pmid OR  title LIKE :title OR abstract LIKE :abstract',[
                ':pmid' => "%{$params['term']}%",
                ":title"=> "%{$params['term']}%",
                ":abstract" => "%{$params['term']}%",
            ]);
            //VarDumper::dump($query);
        }else{
            $query = $sql;
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

        // $query->andFilterWhere([
        //     'id' => $this->id,
        // ]);

        $query->andFilterWhere(['like', 'PMID', $this->PMID])
              ->andFilterWhere(['like', 'title', $this->title])
              ->andFilterWhere(['like', 'abstract', $this->abstract]);
       
        return $dataProvider;
        //return  $sql;

     }

     public function searchPublished($params , $id)
     {
     $query = null;
        
     $ref_model = RefPublished::find()->where('file_id = :id' , [':id' => $id])->all();
     $arr_pmid = [];
     

     foreach( $ref_model as $row){  $arr_pmid[] = $row['PMID']; }
    //  echo"<pre>";
    //  print_r($arr_pmid);
    //  echo"</pre>";

     $sql = Publisheds::find()->where(['IN' , 'PMID' , $arr_pmid ]);
    //  echo $sql->createCommand()->getRawSql();
    //  exit();
         if(isset($params['term'])){
             $query = $sql
                 ->andwhere('PMID LIKE :pmid OR owner LIKE :owner OR title like :title OR abstract like :abstract',[
                 ':pmid' => "%{$params['term']}%",
                 ":owner"=> "%{$params['term']}%",
                 ":title"=> "%{$params['term']}%",
                 ":abstract" => "%{$params['term']}%",
             ]);
             //VarDumper::dump($query);
         }else{
             $query = $sql;
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
 
         $query->andFilterWhere(['like', 'PMID', $this->PMID])
             ->andFilterWhere(['like', 'owner', $this->owner])
             ->andFilterWhere(['like', 'status', $this->status])
             ->andFilterWhere(['like', 'date_last_revised', $this->date_last_revised])
             ->andFilterWhere(['like', 'date_of_publication', $this->date_of_publication])
             ->andFilterWhere(['like', 'title', $this->title])
             ->andFilterWhere(['like', 'abstract', $this->abstract])
             ->andFilterWhere(['like', 'copyright_Information', $this->copyright_Information])
             ->andFilterWhere(['like', 'language', $this->language])
             ///->andFilterWhere(['like', 'publication_type', $this->publication_type])
             ->andFilterWhere(['like', 'date_of_electronic_publication', $this->date_of_electronic_publication])
             ->andFilterWhere(['like', 'place_of_publication', $this->place_of_publication])
             ->andFilterWhere(['like', 'journal_Title_abbreviation', $this->journal_Title_abbreviation])
             ->andFilterWhere(['like', 'journal_title', $this->journal_title])
             ->andFilterWhere(['like', 'NLM_Unique_ID', $this->NLM_Unique_ID])
             ->andFilterWhere(['like', 'subset', $this->subset])
             ->andFilterWhere(['like', 'entrez_date', $this->entrez_date])
             ->andFilterWhere(['like', 'MeSH_date', $this->MeSH_date])
             ->andFilterWhere(['like', 'create_date', $this->create_date])
             ->andFilterWhere(['like', 'publication_status', $this->publication_status])
             ->andFilterWhere(['like', 'source', $this->source]);
 
         return $dataProvider;
 
 
 
         
     }
 
}
