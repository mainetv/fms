<!-- Allotment Activity Modal -->
<div class="modal fade" id="attach_allotment_modal" role="dialog" aria-labelledby="attach_allotment_label" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">  
      <div class="modal-header">
        <h5 class="modal-title" id="attach_allotment_modal_header">Select allotment to attach</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>         
      <div class="modal-body">
        <input type="text" id="rs_allotment_id_edit" name="rs_allotment_id_edit" hidden>
        <div class="form-group row">
          <div class="table-responsive">
            <table id="all_allotment_table" style="width: 100%;">
              <tbody>
              </tbody>
            </table>
          </div>               
        </div>
      </div>  
    </div>
  </div>
</div>
<!-- END Allotment Activity Modal -->

<div class="modal fade" id="particulars_template_modal" role="dialog" aria-labelledby="particulars_template_label" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="particulars_template_header">Select transaction to insert template</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>         
      <div class="modal-body">
        <div class="form-group row">
          <div class="table-responsive">
            <table id="particulars_template_table" style="width: 100%;">
              <tbody>
              </tbody>
            </table>
          </div>               
        </div>
      </div>   
    </div>
  </div>
</div>

{{-- <div id="openModal" class="modalDialog">
	<div>
		<a href="#close" title="Close" class="close">X</a>
      <br />
      <table width="680" border="0" cellspacing="0" cellpadding="5">
    <tr>
      <td height="31" valign="top" class="normfont"><strong>Select transaction</strong></td>
    </tr>
  </table>
  <div style="height:500px; overflow-x: hidden; overflow-y: scroll">
  <table width="680" border="0" cellspacing="0" cellpadding="5">
    <?php
		// $hs=mysql_query("select * from particulars_temp") ;
		// $how=mysql_num_rows($hs) ;
		// while($i < $how) {
	?>
    <tr>
      <td valign="top"><a href="#" onclick="getparticular(<?php echo $i+1 ?>)"><span style="color:#006"><?php echo nl2br(mysql_result($hs,$i,"transaction")) ?></span></a><input type="hidden" name='temps[<?php echo $i+1 ?>]' id='temps[<?php echo $i+1 ?>]' value='<?php echo mysql_result($hs,$i,"particulars") ?>' /></input>
        </td>
    </tr>
    <?php
			$i++ ;
		}
	?>
  </table>
</div> --}}


