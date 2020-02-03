<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\pubmed\models\PublishedsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pubmedfile');
$this->params['breadcrumbs'][] = $this->title;
   
$authors = [];
 $address = [];
 $fullauthors = [];
 $i = 0;
 $au_num = 1;
 $ad_num = 1;
 $fau_num = 1;
 $check_ad = 0;

 foreach($data_authors as $row){   
    
       if($row['element'] == 'FAU'){  $fullauthors[$i] = $row['content']; }
       if($row['element'] == 'AU'){  $authors[$i] = $row['content']; } 
       $i++;
    
  }  

  //======================  chk address ==================

  foreach($data_authors as $row){ 
      
  if($row['element'] != 'AD'){ $check_ad = 1; }

  if( $check_ad == 1){ 

      if($row['element'] == 'AD'){

    //   $address[$i] = $row['content']; 
      $i++; 
      $check_ad = 2;

     }
  }
  
  if($check_ad == 2){
      
   if($row['element'] == 'AD'){  $address[$i] .= $row['content']."<br>";  }

  }

}  

 ?>
    <div class="publisheds-index">
        <div class="sdbox-body">
            <div class="row">
            <div class='col-md-2'>
              <b> ปีที่ตีพิมพ์ </b>
               <ul class="list-group">
                  <li class="list-group-item">
                  <?php  
                         echo '<a id="btn-show-year" style="color:#595D6E;" href="#">
                         <span class="glyphicon glyphicon-play"></span>
                         select Year
                         </a>';
                         echo "<div id='show-year' style='display:none;'>"; 
                         $arr_year =[];    
                         
                         foreach($data_year as $row){
                         echo "<a href='".Url::to(['/pubmed/pubmedfile/author-year' , 'year' => $row['year'] ])."'>".$row['year']."</a><br>";
                         //echo '<hr>';
                        }

                        echo "</div>";
                  ?>
                   </li>
              </ul>
              <b> ชื่อผู้แต่ง </b>
               <ul class="list-group">
                  <li class="list-group-item">

                  <?php  
                           echo '<a id="btn-show-au" href="#" style="color:#595D6E;">
                           <span class="glyphicon glyphicon-play"></span>
                           select Authors
                           </a>';
                           echo'<div id="show-au" style=\'display:none;\'>';
                         $arr_fau =[];    
                         
                         foreach($data_authors_sreach as $row_fau){
                         echo "<a href='".Url::to(['/pubmed/pubmedfile/author-search' , 'fau' => $row_fau['content']])."'>". $row_fau['content']."</a><br>";
                        //  echo '<hr>';
                        }
                        echo'</div>';
                  ?>
                   </li>
              </ul>
            </div>
                <div class="col-md-10">

                <div class="modal-header ">
    <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
    <h4 class="modal-title">PAPER</h4>
</div>
<div class="modal-body">
   <table class='table table-bordered table-striped'>
      
    <?php foreach($data_publish as $row_publish){  ?>
 
    
      <?=$row_publish['source']?> <br><br>
  
      <h4><b><?=$row_publish['title']?></b></h4><br>

      <b><?php foreach($fullauthors as $row_fau){  
           echo "<a href='".Url::to(['pubmedfile/author-search' , 'fau' => $row_fau ])."'>".$row_fau.'<sup>'.$fau_num.'</sup>, </a>'; $fau_num++;   
           } ?></b><br><br>
    
        
         <button id='btn-details' type="button" class="btn btn-default btn-sm" >
          <span class="glyphicon glyphicon-plus"></span> <b>author Inoformation</b>
        </button><hr>
        
         <p id='details' style='display:none;'>

        
        <?php 
        
        // print_r($address);
        
        foreach($address as $row_ad)
        {  
            echo  $ad_num.'. '.$row_ad.'<br><br>';  $ad_num++;   
        
        
        } ?><br><br>
        </p>
        <h4><b>Abstract</b></h4>
        <?=$row_publish['abstract']?><br><br>
        
        <p style='font-size:12px;'><b>PMID: </b><?=$row_publish['PMID']?></p>
           
  <?php  } ?>
    

</div>
<div class="modal-footer">
    <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
</div>

                </div>
            </div>
        </div>
    </div>

<?= ModalForm::widget([
    'id' => 'modal-publisheds',
    'size' => 'modal-lg',
]);
?>

<?php \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
    <script>

$("#btn-show-au").click(function(){
    $("#show-au").toggle("slow");
  
  });

  $("#btn-show-year").click(function(){
    $("#show-year").toggle("slow");
    
  });


$("#btn-details").click(function(){
    $("#details").toggle("slow");
  });
    //======================================================
    
        $(".btn-view-auth").on('click', function(){
            let url = $(this).attr('data-url');
            // alert(url);
            modalPublished(url);
            return false;
        });
        // JS script
        $('#publisheds-grid-pjax').on('click', '#modal-addbtn-publisheds', function () {
            modalPublished($(this).attr('data-url'));
        });

        $('#publisheds-grid-pjax').on('click', '#modal-delbtn-publisheds', function () {
            selectionPublishedGrid($(this).attr('data-url'));
        });

        $('#publisheds-grid-pjax').on('click', '.select-on-check-all', function () {
            window.setTimeout(function () {
                var key = $('#publisheds-grid').yiiGridView('getSelectedRows');
                disabledPublishedBtn(key.length);
            }, 100);
        });

        $('#publisheds-grid-pjax').on('click', '.selectionPublishedIds', function () {
            var key = $('input:checked[class=\"' + $(this).attr('class') + '\"]');
            disabledPublishedBtn(key.length);
        });

        $('#publisheds-grid-pjax').on('dblclick', 'tbody tr', function () {
            var id = $(this).attr('data-key');
            modalPublished('<?= Url::to(['publisheds/view', 'id' => ''])?>' + id);
        });

        $('#publisheds-grid-pjax').on('click', 'tbody tr td a', function () {
            var url = $(this).attr('href');
            var action = $(this).attr('data-action');

            if (action === 'update' || action === 'view') {
                modalPublished(url);
            } else if (action === 'delete') {
                yii.confirm('<?= Yii::t('app', 'Are you sure you want to delete this item?')?>', function () {
                    $.post(
                        url
                    ).done(function (result) {
                        if (result.status == 'success') {
                            <?= SDNoty::show('result.message', 'result.status')?>
                            $.pjax.reload({container: '#publisheds-grid-pjax'});
                        } else {
                            <?= SDNoty::show('result.message', 'result.status')?>
                        }
                    }).fail(function () {
                        <?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"')?>
                        console.log('server error');
                    });
                });
            }
            return false;
        });

        function disabledPublishedBtn(num) {
            if (num > 0) {
                $('#modal-delbtn-publisheds').attr('disabled', false);
            } else {
                $('#modal-delbtn-publisheds').attr('disabled', true);
            }
        }

        function selectionPublishedGrid(url) {
            yii.confirm('<?= Yii::t('app', 'Are you sure you want to delete these items?')?>', function () {
                $.ajax({
                    method: 'POST',
                    url: url,
                    data: $('.selectionPublishedIds:checked[name=\"selection[]\"]').serialize(),
                    dataType: 'JSON',
                    success: function (result, textStatus) {
                        if (result.status == 'success') {
                            <?= SDNoty::show('result.message', 'result.status')?>
                            $.pjax.reload({container: '#publisheds-grid-pjax'});
                        } else {
                            <?= SDNoty::show('result.message', 'result.status')?>
                        }
                    }
                });
            });
        }

        function modalPublished(url) {
            $('#modal-publisheds .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
            $('#modal-publisheds').modal('show')
                .find('.modal-content')
                .load(url);
            
            //$this->redirect('/pubmed/index',302);
        }

        function initPublisheds(url){
            //let url = '<?= \yii\helpers\Url::to(['/pubmed/pubmedfile/get-data-publisheds'])?>';
            $.get(url,function (res) {
                $("#preview-pubmedfile").html(res);
            });
        }
        $('.table thead tr th a').on('click',function(){
           let url = $(this).attr('href');
            initPublisheds(url);
           return false;
        });


    </script>
<?php \richardfan\widget\JSRegister::end(); ?>