<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PubmedfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pubmedfiles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pubmedfile-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Upload File', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <div class="row">
    <div class="col-md-6 col-md-offset-6">
        <form id="form-search">
            <div class="input-group">
                <input id="term" type="text" class="form-control" placeholder="ค้นหาข้อมูล">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit">
                        <i class="glyphicon glyphicon-search"></i> ค้นหา
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="preview-pubmedfile"></div>

<?php \richardfan\widget\JSRegister::begin(); ?>
<script>

    // ส่ง url ไปเพื่อดึงไฟล์ออกมาในตอนแรก
    function initPubmedfiles(){
        let url = '<?= \yii\helpers\Url::to(['/pubmed/pubmedfile/get-data-pubmeds'])?>';
        searchPubmedfiles(url);
    }

    // ฟังก์ชั่นส่งค่า
    function searchPubmedfiles(url){
        $.get(url,function (res) {
            $("#preview-pubmedfile").html(res);
        });
    }
    
    //เรียกใช้ ฟังชั่นก์เพื่อทำการเรียกข้อมูล
    initPubmedfiles();

    //ส่งค่าตอนค้นหา
    $("#form-search").on('submit', function () {
       let term = $("#term").val();
       let url = '<?= \yii\helpers\Url::to(['/pubmed/pubmedfile/get-data-pubmeds'])?>?term='+term;
       searchPubmedfiles(url);
       return false;
    });
</script>
<?php \richardfan\widget\JSRegister::end(); ?>
<br>

</div>
