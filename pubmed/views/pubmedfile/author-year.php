<?php

$this->title = $model->file_name; //$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pubmedfiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);


?>

<h3>Publications <?= $year ?></h3>
<hr/>
<div class='row'>
<div class='col-md-6'><!--<b style='float:right; padding-top:5px;'>( ค้นหาไฟล์ในปี <?= $year ?> )--></b></div>
  <div class='col-md-6'>
   <form id="form-search">
            <div class="input-group">
                <input id="term" type="text" class="form-control" placeholder="ค้นหาข้อมูลในปี <?= $year ?> ( PMID , Title , Abstract ) ">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit">
                        <i class="glyphicon glyphicon-search"></i> ค้นหา
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class='row' >
  <div class='col-md-12'>
  <div id="preview-authorsearchyear"></div>
</div>

<?php \richardfan\widget\JSRegister::begin(); ?>
<script>
    function initPublisheds(){
        
        let url = '<?= \yii\helpers\Url::to(['/pubmed/pubmedfile/get-author-year' , 'year' => $year])?>';
        searchPublisheds(url);
    }
    function searchPublisheds(url){
        $.get(url,function (res) {
            $("#preview-authorsearchyear").html(res);
        });
    }
    initPublisheds();

    $("#form-search").on('submit', function () {
       let term = $("#term").val();
       let url = '<?= \yii\helpers\Url::to(['/pubmed/pubmedfile/get-author-year', 'year' =>  $year])?>&term='+term;
     
       searchPublisheds(url);
       return false;
    });
</script>
<?php \richardfan\widget\JSRegister::end(); ?>


<?php  

//  foreach($model_year as $p_yaer){

//     echo $p_yaer['PMID'].'<br>';
//     echo $p_yaer['title'].'<br>';
//     echo $p_yaer['abstract'].'<br>';

//  }




?>