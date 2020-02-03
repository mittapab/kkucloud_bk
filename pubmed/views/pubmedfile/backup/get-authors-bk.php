<?php 

use yii\helpers\Url;
use yii\helpers\Html;
 
 $authors = [];
 $address = [];
 $fullauthors = [];
 $i = 0;
 $au_num = 1;
 $ad_num = 1;
 $fau_num = 1;
 foreach($data_authors as $row){   
   
    if($row['element'] == 'AU'){  $authors[$i] = $row['content']; } 
    if($row['element'] == 'AD'){  $address[$i] = $row['content']; }
    if($row['element'] == 'FAU'){  $fullauthors[$i] = $row['content']; }

    $i++;
    
  }  

?>

<div class="modal-header ">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
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
        <?php foreach($address as $row_ad){  echo  $ad_num.'. '.$row_ad.'<br><br>';  $ad_num++;   } ?><br><br>
        </p>
        <h4><b>Abstract</b></h4>
        <?=$row_publish['abstract']?><br><br>
        
        <p style='font-size:12px;'><b>PMID: </b><?=$row_publish['PMID']?></p>


  <!-- <tr>
      <td>OWNER</td>
      <td><?=$row_publish['owner']?></td>
  </tr>   
  <tr>
      <td>Status</td>
      <td><?=$row_publish['status']?></td>
  </tr>   
  <tr>
      <td>Date last revised</td>
      <td><?=$row_publish['date_last_revised']?></td>
  </tr>   
  <tr>
      <td>Date of publication</td>
      <td><?=$row_publish['date_of_publication']?></td>
  </tr>
  <tr>
      <td>Year</td>
      <td>
      <?php //echo substr($row_publish['date_of_publication'] ,0 , 4);
        echo "<a href='".Url::to(['pubmedfile/author-year' , 'year' => substr($row_publish['date_of_publication'] ,0 , 4) ])."'>".substr($row_publish['date_of_publication'] ,0 , 4).'</a>';
     ?>
     </td>
  </tr>
 
  <tr>
      <td>Abstract</td>
      <td><?=$row_publish['abstract']?></td>
  </tr> 
  <tr>
      <td>Copyright Information</td>
      <td><?=$row_publish['copyright_Information']?></td>
  </tr>    
  <tr>
      <td>Language</td>
      <td><?=$row_publish['language']?></td>
  </tr>    
  <tr>
      <td>Date of electronic publication</td>
      <td><?=$row_publish['date_of_electronic_publication']?></td>
  </tr>
  <tr>
      <td>Place of publication</td>
      <td><?=$row_publish['place_of_publication']?></td>
  </tr>
  <tr>
      <td>Journal Title abbreviation</td>
      <td><?=$row_publish['journal_Title_abbreviation']?></td>
  </tr>
  <tr>
      <td>Journal title</td>
      <td><?=$row_publish['journal_title']?></td>
  </tr>            
  <?php  } ?>
    
     <tr>
       <td>Authors</td>
       <td><?php foreach($authors as $row_au){  
           echo $row_au.'<sup>'.$au_num.'</sup>, '; $au_num++;   
           } ?></td>
     </tr>
     <tr>
  </table> -->
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

<script>


  $("#btn-details").click(function(){
    $("#details").toggle("slow");
  });

</script>


