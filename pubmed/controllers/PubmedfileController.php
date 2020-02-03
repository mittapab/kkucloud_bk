<?php

namespace backend\modules\pubmed\controllers;

use appxq\sdii\utils\VarDumper;
use Yii;
use backend\modules\pubmed\models\Pubmedfile;
use backend\modules\pubmed\models\PubmedfileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use backend\modules\pubmed\models\AuthorTable;
use backend\modules\pubmed\models\Publisheds;
use backend\modules\pubmed\models\Utations;
use backend\modules\pubmed\models\FieldsPublished;
use backend\modules\pubmed\models\FieldsTables;
use backend\modules\pubmed\models\Authors;
use backend\modules\pubmed\models\PublishedsSearch;
use backend\modules\pubmed\models\RefPublished;
use yii\data\ActiveDataProvider;
use backend\modules\pubmed\models\YearTable;
// use backend\modules\pubmed\models\User;
/**
 * PubmedfileController implements the CRUD actions for Pubmedfile model.
 */
class PubmedfileController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Pubmedfile models.
     * @return mixed
     */

    public function actionGetAuthorSearch(){


        $model_author = Authors::find()->select('id_published')->distinct()->where('content LIKE :fau' ,[':fau' => $_GET['fau']])->all();
        $id_published = [];
        foreach($model_author as $r){$id_published[] = $r['id_published'];}
        $searchModel = new PublishedsSearch();
        $model_pubmed = $searchModel->searchAuthor(Yii::$app->request->queryParams ,  $id_published);
        //ดึงข้อมูลปี
        $data_year = YearTable::find()->orderBy(['year'=>SORT_DESC])->all();
        //ดึงข้อมูลชื่ออาจารย์
        $data_authors = Authors::find()->select('content')->distinct()->where('element = :FAU',[':FAU'=> 'FAU'])->all();

        if (Yii::$app->getRequest()->isAjax) {
            return $this->renderAjax('get-author-search', [
                'dataProvider' => $model_pubmed,
                'pubmed' => $model_pubmed,
                'id' => $id, 
                'data_year' => $data_year,
                'data_authors' => $data_authors,
            ]);
        } else {
            return $this->render('get-author-search', [
                'dataProvider' => $model_pubmed,
                'pubmed' => $model_pubmed,
                'id' => $id,
                'data_year' => $data_year,
                'data_authors' => $data_authors,
            ]);
        }



    }

    public function actionGetAuthorYear(){

        $searchModel = new PublishedsSearch();
        $model_year =  $searchModel->searchYear(Yii::$app->request->queryParams , $_GET['year']);
        $data_year = YearTable::find()->orderBy(['year'=>SORT_DESC])->all();
         //ดึงข้อมูลชื่ออาจารย์
         $data_authors = Authors::find()->select('content')->distinct()->where('element = :FAU',[':FAU'=> 'FAU'])->all();
        if (Yii::$app->getRequest()->isAjax) {

            return $this->renderAjax('get-author-year', [
                'dataProvider' => $model_year,
                'data_year' => $data_year,
                'data_authors' => $data_authors,
            ]);
        } else {
            return $this->render('get-author-year', [
                'dataProvider' => $model_year,
                'data_year' => $data_year,
                'data_authors' => $data_authors,
           ]);
        }



    }


     public function actionIndex()
    {
        $searchModel = new PubmedfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams , $_GET['id']);

        // $pages = new Pagination(['totalCount' => $dataProvider->count()]);
        //SELECT  pm.file_name ,  pm.file_size , pm.created_at ,
        // `user`.username FROM pubmedfile as pm LEFT JOIN `user` ON  `user`.id = pm.create_by
        // print_r($dataProvider);
        // exit();
        return $this->render('index', [
            'searchModel' => $searchModel, 
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pubmedfile model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */





    public function actionAuthorYear(){
       //
        $model_year = Publisheds::find()->where('date_of_publication LIKE "%'.$_GET['year'].'%"' ,[':year' => $_GET['year']])->all();
        return $this->render('author-year' , [
            'year' => $_GET['year'],
            'model_year' => $model_year,
        ]);
    

    }


    public function actionAuthorSearch(){
        
        $model_author = Authors::find()->select('id_published')->distinct()->where('content LIKE :fau' ,[':fau' => $_GET['fau']])->all();
        $id_published = [];
        foreach($model_author as $r){$id_published[] = $r['id_published'];}
        $model_pubmed = Publisheds::find()->where(['in' , 'id' , $id_published])->all();
        
        return $this->render('author-search' , [
            'author' => $_GET['fau'],
            'pubmed' => $model_pubmed,
        ]);
   
    }




    public function actionGetAuthors()
    { 
        $id_published = Yii::$app->request->get('id_published');
        
        $data_publish = Publisheds::find()->where('id = :id' , [':id' => $id_published])->all();
        $data_authors = Authors::find()
        ->where('id_published = :id_published' , [ ':id_published' => $id_published ,])
        ->all();
        $searchModel = new PublishedsSearch();
        $model_pubmed = $searchModel->searchAuthor(Yii::$app->request->queryParams ,  $id_published);
        //ดึงข้อมูลปี
        $data_year = YearTable::find()->all();
        //ดึงข้อมูลชื่ออาจารย์
        $data_authors_sreach = Authors::find()->select('content')->distinct()->where('element = :FAU',[':FAU'=> 'FAU'])->all();
 
        // return $this->renderAjax('get-authors', [
        //     'data_authors' => $data_authors ,
        //     'data_publish' => $data_publish,
        //     // 'model_au' => $data_authors,
        //     // 'model_ad' => $data_authors2,
        // ]);

          return $this->render('get-authors', [
            'data_authors' => $data_authors ,
            'data_publish' => $data_publish,
            'data_year' => $data_year,
            'data_authors_sreach' => $data_authors_sreach,
            // 'model_au' => $data_authors,
            // 'model_ad' => $data_authors2,
        ]);

    }


    public function actionGetDataPubmeds()
    {
        $searchModel = new PubmedfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (Yii::$app->getRequest()->isAjax) {
            return $this->renderAjax('get-data-pubmeds', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->render('get-data-pubmeds', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionGetDataPublisheds($id)
    {
        $searchModel = new PublishedsSearch();
        $dataProvider = $searchModel->searchPublished(Yii::$app->request->queryParams , $id);
        //ดึงข้อมูลปีที่ตีพิมพ์
        $data_year = YearTable::find()->all();
        //ดึงข้อมูลชื่ออาจารย์
        $data_authors = Authors::find()->select('content')->distinct()->where('element = :FAU',[':FAU'=> 'FAU'])->all();




        if (Yii::$app->getRequest()->isAjax) {
            return $this->renderAjax('get-data-publisheds', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'id' => $id,
                'data_year' =>  $data_year,
                'data_authors' => $data_authors,
            ]);
        } else {
            return $this->render('get-data-publisheds', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'id' => $id,
                'data_year' =>  $data_year,
                'data_authors' => $data_authors,
            ]);
        }
    }

    
    public function actionView($id)
    {  
        $element = 'AU'; // element author
        // ดึงข้อมูลจากตาราง publisheds ที่ตรงกับไอดี
        $data_publish = Publisheds::find()->where('file_id = :id' , [':id' => $id])->all(); 
        // ดึงข้อมูลจากตาราง utations ที่ตรงกับไอดี
        $data_utation = Utations::find()->where('file_id = :id' , [':id' => $id])->one();
        //defind id published 
        $id_published = $data_utation->id_published;
        //กำหนดข้อมูลผู้แต่งที่จำนำมาแสดง จาก id_published และ element
        $data_authors = Authors::find()
        ->where('id_published = :id_published' , [ ':id_published' => $id_published ,])
        ->andWhere('element = :element' , [ ':element' => $element ,])
        ->all();
        //กำหนดข้อมูลที่อยู่ที่จำนำมาแสดง จาก id_published และ element
        $element2 = 'AD';
        $data_authors2 = Authors::find()
        ->where('id_published = :id_published' , [ ':id_published' => $id_published ,])
        ->andWhere('element = :element' , [ ':element' => $element2 ,])
        ->all();

        //ส่งค่าไปที่ view
        return $this->render('view', [
            'model' => $data_publish ,
            'model_au' => $data_authors,
            'model_ad' => $data_authors2,
            // 'id_published'=>$id
        ]);
    }

    public function actionCreate()
    {  
        //======================== เป็นส่วนที่ upload file ===========================
        $model = new Pubmedfile();
        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'file_name');
        
            //หากใช้ path ให้ใช้ Alias
            $path = Yii::getAlias("@storage").'/web/source/';
           //$path = "ezupload/";
            if ($file != null) {
                $file->saveAs($path . $file->baseName . '.' . $file->extension);
                $model->file_name = $file->baseName . '.' . $file->extension;
                $model->file_size = ($file->size / 1000).' KiB';
                $model->created_at =  new \yii\db\Expression('NOW()');
                $model->create_by = isset(Yii::$app->user->id) ? Yii::$app->user->id : '1';
                $model->save(false);
            //====================== end of upload file ==================================

            //====================== read file upload =====================================
                $file_id = Yii::$app->db->getLastInsertID();
                $handle = file_get_contents($path . $file->baseName . '.' . $file->extension);
                file_put_contents($path . $file->baseName . '.txt', $handle);
                $handle = fopen($path . $file->baseName . '.txt', "r");
                $dataArray = [];
                $outputArr = [];
                $row = 0;
                $subrow = 1;
                if ($handle) {
                    while (($line = fgets($handle)) !== false) {
                        $dataArray = explode('- ', $line);

                        if (count($dataArray) > 1) {

                            if (strlen($dataArray[0]) < 10) {

                                $outputArr[$row] = [
                                    'key' => $dataArray[0],
                                    'value' => $dataArray[1],
                                ];

                                $row++;
                                $subrow = $row;
                            } else {

                                $subrow -= 1;
                                $outputArr[$subrow]['value'] .= '- ' . $dataArray[0] . $dataArray[1];
                                $subrow++;
                            }

                        } else {
                            if (!empty($outputArr)) {
                                $subrow -= 1;
                                $outputArr[$subrow]['value'] .= $dataArray[0];
                                $subrow++;
                            }
                        }
                    }
                }
                //========================================= End of read file ===============================================
                
             
                // ดึงข้อมูลจากตาราง FieldsPublished ออกมา
                $field_published_model = FieldsPublished::find()->all();

                //สร้าง array ขึ้นมาเพื่อเตรียมรับ คอลัมน์คีย์ และ ค่า จากตาราง FieldsPublished
                $arr_key = [];
                $rd = [];
                $jh = 0;
                foreach ($field_published_model as $r) {
                    $arr_key[$r['key']] = $r['value'];
                }

                $element = [];
                $value_string_sql = ''; //ต่อสตริงคิวรี่
                $vales_sql = ''; //ต่อสตริงคิวรี่
                $update_sql = '';
                $update_arry_pmid = [];
                $arr_ref_pmid  = [];
                
                //วนลูปหากต่อสตริง โดยใช้ คีย์จาก ไฟล์ text ที่เป็นได้เทียบกับ key ที่ดึงมาจาก ตาราง
                
                foreach ($outputArr as $r) {   

                    $r['key'] = trim($r['key']);

                    if($r['key'] == 'AB'){ 

                        $r['value'] = addslashes($r['value']);
                        // echo "<pre>";
                        // echo addslashes($r['value']);
                        // echo "</pre>";

                        //$r['value'] = str_replace(" ' ", '' , $r['value']); 
                    
                    
                    }//htmlspecialchars($r['value'], ENT_QUOTES);  }
                    
                    // echo "<pre>";
                    // print_r($rd);
                //     // echo "</pre>";
                //     $jh++;
                // }

                // exit();
                // if($x ==5 ){

                    if($r['key'] == 'PMID'){

                      $ref_model = new RefPublished();
                      $ref_model->PMID = trim($r['value']);
                      $ref_model->file_id =  $file_id;
                      $ref_model->save(false);

                    }

                   //ตรวจสอบว่า key จากไฟล์ text มีในตารางหรือไม่ ถ้าหากมีให้ต่อสตริง sql
                    if (array_key_exists($r['key'], $arr_key)) { 
                       
                        $value_string_sql .= $arr_key[$r['key']] . ',';

                        if( $arr_key[$r['key']] == 'date_of_publication'){
                            
                            /** ==================== Query Year ============================*/
                            $year = substr(trim($r['value']) ,0,4);
                            $sql_get_year = "SELECT * FROM year_table WHERE year=".$year;
                            $model_get_year = Yii::$app->db->createCommand($sql_get_year)->queryOne();
                            if($model_get_year){

                            $sql_update_year = "UPDATE year_table SET year=".$year." WHERE year=".$year;
                            Yii::$app->db->createCommand($sql_update_year)->execute();

                            }else{

                                $model_year = new YearTable();
                                $model_year->year = $year;
                                $model_year->save(false);

                               }

                            /** ==================== End Query Year ============================*/

                          }
                         /**  ====================== NEW CODE ==============================    */
                        if($r['key'] === 'PMID'){  
                            
                            $update_sql .= '|#'.$arr_key[$r['key']] . '="'.trim($r['value']).'",';
                            $update_arry_pmid[] = trim($r['value']);

                        }else{
                            $update_sql .= $arr_key[$r['key']] . '="'.$r['value'].'" ,';
                        }
                      
                        /**  ====================== END NEW CODE ==============================    */
                        
                        if($r['key'] === 'PMID'){ $vales_sql .= '|'; }
                        
                        $vales_sql .= "'" . trim($r['value']) . "',"; 
                      

                    }
                }

                $ex_fields = explode('PMID', $value_string_sql);
                $ex_values = explode('|', $vales_sql);

                
                // กรณีอัปเดต
                 /**  ====================== NEW CODE ==============================    */
                $update_fields = explode('|#', $update_sql);
               
                // Save data in database  (ปัญหาคือเมื่อมีการต่อสตริง มันจะวนลูปต่อจนครบทุกแถว เราต้องจำกัดให้หยุดแค่แถวสุดท้าย)
                
                $value_string_sql =  $ex_fields; 
                $vales_sql = $ex_values;
                unset($vales_sql[0]);
                unset($value_string_sql[0]);

                //กรณีอัปเดต
                 /**  ====================== NEW CODE ==============================    */
                $update_val = $update_fields;
                unset($update_fields[0]);

          try { 
               /**  ====================== NEW CODE ==============================    */
                $j_pmid_chk = 0;
                $sign_update = 1;

                for($i=1;$i<=count($vales_sql);$i++){

                  /**  ====================== NEW CODE ==============================    */
                 
                  $sql_check_pmid = 'SELECT id , PMID FROM publisheds WHERE PMID = '.$update_arry_pmid[$j_pmid_chk].''; 

                  $check_pmid =  Yii::$app->db->createCommand($sql_check_pmid)->queryOne();

             
                /**  ====================== END NEW CODE ==============================    */
                 
              if($check_pmid){ 
                    
                 /**  ====================== NEW CODE ==============================    */
                    $update_val[$i] = substr($update_val[$i], 0, -1);
                    $sql = "UPDATE publisheds SET ".$update_val[$i].' WHERE PMID = '.$update_arry_pmid[$j_pmid_chk].' ';
                    Yii::$app->db->createCommand($sql)->execute();
                    $id =  $check_pmid['id']; //Yii::$app->db->getLastInsertID();
                    $sign_update = 2;
                   

               }else{

                //date_of_publication
              

                $value_string_sql[$i] = substr('PMID'.$ex_fields[$i], 0, -1);
                $vales_sql[$i] = substr($vales_sql[$i], 0, -1);    
                $sql = "INSERT INTO publisheds(" . $value_string_sql[$i] . " , file_id) VALUES(" . $vales_sql[$i] . ", ".$file_id.")";
                Yii::$app->db->createCommand($sql)->execute();
                $id = Yii::$app->db->getLastInsertID();
            
           
            }

  

    //=====================================================================================================
   //========================================= Save To Utation ===========================================
  //=====================================================================================================
                
           
                // bind params
                $search_id = [':id' => $id];
                //find data
                $model_public = Publisheds::findOne(['id' => $search_id]);

                  // select column                        
                  $sq_col = "SELECT DISTINCT column_name 
                  FROM INFORMATION_SCHEMA.COLUMNS
                  WHERE TABLE_NAME = 'publisheds'";

                  $data = Yii::$app->db->createCommand($sq_col)->query();

                  //สร้าง array เพื่อเตรียมรับค่าจากตาราง  Publisheds
                  $array_col = [];
                
                 //วนลูปกกำหนดค่าคอลัมให้อยู่ใน array
                 foreach ($model_public as $data_col) {
                     $array_col[] = $data_col;
                 }
                 
                 // ยกเลิก array 0 เพราะเป็นค่าไอดี ซึง่เราไม่ต้องการ ซึ่งใช้ function unset();
                 unset($array_col[0]);

                 $j = 1;
                 $ele = 0;
                 
                 $model_utation = Utations::find()->where('id_published = :id' ,[':id' => $id])->all();

                 //print_r($model_utation);

                 $array_utation = [];

                 foreach($model_utation as $r_utation){
                    
                    $array_utation[] = $r_utation['id'];

                 }

                //  print_r($array_utation);


                 $count_utation = 0;
                
                foreach ($data as $r) {

                  

                    // ถ้าหากคอลัม ไม่ใช่คอลัม ID  ให้กำหนดค่าแล้วบันทึกลง database
                    if ($r['column_name'] !== 'id') {
                        
                         /**  ====================== NEW CODE ==============================    */
                        if( $sign_update == 2){

                           // $model_utation = Utations::find($array_utation[$count_utation])->one();
                           $sql_utation = "SELECT *  FROM utations WHERE id = ".$array_utation[$count_utation];
                           $model_update_utation  = Yii::$app->db->createCommand($sql_utation)->queryOne();
                           
                        //    echo $sql_utation;
                          
                           $model_update_utation['field'] = '-'; //$arr_key[0] ;
                           $model_update_utation['content'] = $array_col[$j];
                           $model_update_utation['table_name'] = 'publisheds';//$r['column_name'];
                           $model_update_utation['var_name'] = $r['column_name'];
                           $model_update_utation['id_published'] = $model_public->id;
                           $model_update_utation['file_id'] = $file_id;

                           $sql_update_utation = 'UPDATE utations SET field="'. $model_update_utation['field'].'",';
                           $sql_update_utation .= 'content="'. $model_update_utation['content'].'",';
                           $sql_update_utation .= 'table_name="'. $model_update_utation['table_name'].'",';
                           $sql_update_utation .= 'var_name="'. $model_update_utation['var_name'].'",';
                           $sql_update_utation .= 'id_published='. $model_update_utation['id_published'].',';
                           $sql_update_utation .= 'file_id='. $model_update_utation['file_id'].'';
                           $sql_update_utation .= ' WHERE id='.$array_utation[$count_utation];
                           Yii::$app->db->createCommand($sql_update_utation)->execute();

                        //    echo $sql_update_utation;
                        //    echo'<br><br>';
                          
                         }else{

                            $model_utation = new Utations();
                            
                         /**  ====================== END NEW CODE ==============================    */
                        //date_of_publication



                        $model_utation->field = ''; //$arr_key[0] ;
                        $model_utation->content = $array_col[$j];
                        $model_utation->table_name = 'publisheds';//$r['column_name'];
                        $model_utation->var_name = $r['column_name'];
                        $model_utation->id_published = $model_public->id;
                        $model_utation->file_id = $file_id;
                        $model_utation->save(false);

                        }
                        
                        $j++;
                        $ele++;
                        $count_utation++;
                    }
                      

                  }

              //==============================  CLEAR =========================================
                            
                //=================================================================
                //                         Find Table
                //=================================================================

                   //กำหนด วันเป็นวันปัจจุบัน
                    $date = new \yii\db\Expression('NOW()');
                    // กำหนด user id ถ้าหากไม่มีให้กำหนดเท่ากับ 1
                    $user_id = isset(Yii::$app->user->id) ? Yii::$app->user->id : '1';
                    
                    // กำหนดว่าคีย์แต่ละตีย์มี table อะไร 
                    $arr_key_table = [];
                   // ดึงข้อมูลจาก FieldsTables
                    $field_table_model = FieldsTables::find()->all();

                    foreach ($field_table_model as $field_table) {
                        $arr_key_table[$field_table['key']] = $field_table['value'];
                    }
                     
                    /**
                     * เนื่องจากใช้ตัว $outputArr ซึ่งมีทุกตารางแล้ววนลูป 3 รอบทำให้ มันมีค่าตั้งแต่ต้น 
                     * เราจำเป็นต้องจำกัดให้มันวน 1 pmid ใน ใน 1 รอบ วนลูป 3 ครั้ง
                     */
                    $string_key = '';
                    $array_key = [];
                    $array_val = [];

                    foreach ($outputArr as $r) {

                        
                        $r['key'] = trim($r['key']);

                        $string_key .= $r['key']."|"; 
                        $string_key_ex = explode('PMID',$string_key);
                       

                        if($r['key'] == 'PMID'){  $string_val .= '|';}
                        $string_val .= $r['value'].'#'; 
                        $string_valex = explode('|',$string_val);
                     
                    
                    }
                    
                    // กำหนดอาเรย์แถวของรอบที่... เพื่อทำการนำค่าออกมา 
                    $string_key_exx[$i] = explode('|',$string_key_ex[$i]);
                    $string_valexx[$i] = explode('#',$string_valex[$i]);
                    $j_val = 0;
                    $insert_count = 1;

                    foreach($string_key_exx[$i] as $key){ $array_key[$i][] = $key; }
                    foreach($string_valexx[$i] as $val){ $array_val[$i][] = $val; }

                    unset($string_valexx[$i][0]);


                    $count_x = 0;

                    $arr_key_val[$i] = array_combine( $array_key[$i] , $array_val[$i] ); 
                     for($i_key = 1; $i_key <= count($array_key[$i]); $i_key++){

                      //ตรวจสอบว่าใน text มีคีย์ที่ตรงกับ คีย์ ในตารางรึเปล่า ถ้ามีให้ทำการกำหนดแล้วบันทึกลง database
                       if (array_key_exists($array_key[$i][$i_key], $arr_key_table)) {

                        
                        
                        //=====================  เขียนโค้ด ================================
                        if( $sign_update == 2){

                            $sql_author = "SELECT * FROM authors WHERE id_published=".$model_public->id;
                            $model_authors = Yii::$app->db->createCommand($sql_author)->queryAll(); 

                            $sql_update_authors = 'SELECT * FROM authors WHERE id='.$model_authors[$count_x]['id'];
                            $model_update_authors = Yii::$app->db->createCommand($sql_update_authors)->queryOne(); 

                            $model_update_authors['element'] = $array_key[$i][$i_key]; 
                            $model_update_authors['content'] = $array_val[$i][$i_key];
                            $model_update_authors['id_published'] = $id;
                            $model_update_authors['create_date'] = $date;
                            $model_update_authors['create_by'] = $user_id;
                            $model_update_authors['type'] = $arr_key_table[$r['key']];
 
                            $sql_update_authors = 'UPDATE authors SET element="'.$model_update_authors['element'].'",';
                            $sql_update_authors .= 'content="'.$model_update_authors['content'].'",';
                            $sql_update_authors .= 'id_published="'.$model_update_authors['id_published'].'",';
                            $sql_update_authors .= 'create_date='.$model_update_authors['create_date'].',';
                            $sql_update_authors .= 'create_by='.$model_update_authors['create_by'].',';
                            $sql_update_authors .= 'type=""';
                            $sql_update_authors .= ' WHERE id='.$model_authors[$count_x]['id'];
                            Yii::$app->db->createCommand($sql_update_authors)->execute();

                            $count_x++;


                        }else{

                            $arr_key_table = str_replace("_", " ", $arr_key_table);
                            $arr_key_table = str_replace("table", " ", $arr_key_table);
                            $sql_author = "INSERT INTO authors (element , content , id_published ,create_date , create_by ,type)";
                            $sql_author .= ' VALUES("' .$array_key[$i][$i_key]. '"  , "' .$array_val[$i][$i_key] . '"  , "' . $id . '" ,' . $date . ', "' . $user_id . '" ,"' . $arr_key_table[$r['key']] . '")';
                            Yii::$app->db->createCommand($sql_author)->execute();

                        }
                      

                      }

                    }

                    $j_pmid_chk++;

                 }
               
               
                } catch (MySQLException $e) {
                    $e->getMessage();
                }
                //========================================================================================
               
                // รีไดเรกไปที่ หน้า view
                return $this->redirect(['view', 'id' => $model->id]);
            }

        }
        //หากไม่ใช่ให้ไปหน้า create
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Pubmedfile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /*****
     * Update Setting 
     * Not Array
     * Deletes an existing Pubmedfile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Pubmedfile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pubmedfile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pubmedfile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAuthUser(){
       
        $user_id = isset(Yii::$app->user->id) ? Yii::$app->user->id : '1';

       
        $sql = "SELECT * FROM user WHERE id=".$user_id;// User::find()->where('id = :id' , [':id' => $user_id])->one();
        $model_user = Yii::$app->db->createCommand($sql)->queryOne();
        if($model_user){
         $session = Yii::$app->session;
         $session->set('user_id', $user_id);
         //return $this->render('index');
         $this->redirect(['pubmedfile/index','id'=> $user_id]);

       }else{
           echo"404";
       }
        
    }
}


    