
{{-- START --}}
  {{-- modal start --}}
    $('#qop_modal').on('hide.bs.modal', function(){
      init_view_qop();
      clear_attributes();
      clear_fields();      
    }); 
    
    $('#qop_modal').on('shown.bs.modal', function () {
      $('#pap_id').focus();
    })  

    $("#comment_modal").on("hidden.bs.modal", function(){ 
      $('.director_comments_tbody tr').remove();
      $('.budget_officer_comments_tbody tr').remove();
    });
  {{-- modal end --}}

  {{-- view start --}}   
    function init_view_qop(){
      $('.qop-field')
        .val('')
        .attr('disabled', true);

      $('.save-buttons')
        .removeClass('d-inline')
        .addClass('d-none')
        .attr('disabled', true);
    }
  {{-- view end --}}

  {{-- add start --}}     
    function init_add_qop(){
      $('.qop-field')
        .attr('disabled', false);
        
      $('.save_qop.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);      
    }
    
    $('.btn_add').on('click', function(){   
      init_add_qop();  
      var division_id = $(this).data('division-id');
      var year = $(this).data('year');
      $(".modal-body #division_id").val(division_id);
      $(".modal-body #year").val(year);
      $('#qop_modal_header').html("Add New Quarterly Obligation Program Item");        
      $('#qop_modal').modal('toggle')       
    })

    $('.save_qop').on('click', function(e){     
      e.prevenDefault;  
      clear_attributes();      
      $.ajax({
        method: "POST",
        url: "{{ route('quarterly_obligation_program.postAction') }}",
        data: {
          '_token': '{{ csrf_token() }}',      
          'add_qop' : 1,
          'division_id' : $('#division_id').val(),
          'year' : $('#year').val(),
          'pap_id' : $('#pap_id').val(),
          'activity_id' : $('#activity_id').val(),
          'subactivity_id' : $('#subactivity_id').val(),
          'expense_account_id' : $('#expense_account_id').val(),
          'object_expenditure_id' : $('#object_expenditure_id').val(),
          'object_specific_id' : $('#object_specific_id').val(),
          'pooled_at_division_id' : $('#pooled_at_division_id').val(),
          'q1_amount' : $('#q1_amount').val(),
          'q2_amount' : $('#q2_amount').val(),
          'q3_amount' : $('#q3_amount').val(),
          'q4_amount' : $('#q4_amount').val(),
        },
        success:function(data) {
          console.log(data);
          if(data.errors) {         
            if(data.errors.pap_id){
              $('#pap_id').addClass('is-invalid');
              $('#pap-error').html(data.errors.pap_id[0]);
            } 
            if(data.errors.activity_id){
              $('#activity_id').addClass('is-invalid');
              $('#activity-error').html(data.errors.activity_id[0]);
            } 
            if(data.errors.subactivity_id){
              $('#subactivity_id').addClass('is-invalid');
              $('#subactivity-error').html(data.errors.subactivity_id[0]);
            } 
            if(data.errors.expense_account_id){
              $('#expense_account_id').addClass('is-invalid');
              $('#expense-error').html(data.errors.expense_account_id[0]);
            }
            if(data.errors.object_expenditure_id){
              $('#object_expenditure_id').addClass('is-invalid');
              $('#expenditure-error').html(data.errors.object_expenditure_id[0]);
            }
          }
          if(data.success) {
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Quarterly obligation program item has been successfully added.',
              showConfirmButton: false,
              timer: 1500
            })   
            window.location.reload();
            $('#qop_modal').modal('toggle');
          }
        },
      });
    })   
  {{-- add end    --}}     

  {{-- update start --}}
    function init_edit_qop(){      
      init_view_qop();
      $('.qop-field')
        .attr('disabled', false);

      $('.update_qop.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);
    }

    $('.btn_edit').on('click', function(e){  
      $('#qop_modal_header').html("Edit Quarterly Obligation Program Item");        
      init_edit_qop();
      id = $(this).data('id')
      $(".modal-body #id").val(id);
      $.getJSON( '{{ url('programming_allocation/nep/quarterly_obligation_program/division/show') }}/'+id, function( data ) {
      })
      .done(function(data) {    
        $('#pap_id').val(data['quarterly_obligation_program']['pap_id']).change()
        view_subactivity_by_activity_id(
          data['quarterly_obligation_program']['activity_id'],
          data['quarterly_obligation_program']['subactivity_id'],
        )
        view_object_expenditure_by_expense_account_id(
          data['quarterly_obligation_program']['expense_account_id'],
          data['quarterly_obligation_program']['object_expenditure_id'],
        )
        view_object_specific_by_object_expenditure_id(
          data['quarterly_obligation_program']['object_expenditure_id'],
          data['quarterly_obligation_program']['object_specific_id'],
        )
        $('#pooled_at_division_id').val(data['quarterly_obligation_program']['pooled_at_division_id']).change()
        $('#q1_amount').val(data['quarterly_obligation_program']['q1_amount']).change()
        $('#q2_amount').val(data['quarterly_obligation_program']['q2_amount']).change()
        $('#q3_amount').val(data['quarterly_obligation_program']['q3_amount']).change()
        $('#q4_amount').val(data['quarterly_obligation_program']['q4_amount']).change()     
      })
      .fail(function() {
      });  
      $('#qop_modal').modal('toggle')            
    })

    $('.update_qop').on('click', function(e){   
      e.preventDefault();
      Swal.fire({
        title: 'Are you sure you want to save changes?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      })
      .then((result) => {        
        if (result.value) {          
          var request = $.ajax({
            method: "PATCH",            
            url: "{{ route('quarterly_obligation_program.update') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'edit_qop' : 1,
              'id' : $('#id').val(),
              'division_id' : $('#division_id').val(),
              'year' : $('#year').val(),
              'pap_id' : $('#pap_id').val(),
              'activity_id' : $('#activity_id').val(),
              'subactivity_id' : $('#subactivity_id').val(),
              'expense_account_id' : $('#expense_account_id').val(),
              'object_expenditure_id' : $('#object_expenditure_id').val(),
              'object_specific_id' : $('#object_specific_id').val(),
              'q1_amount' : $('#q1_amount').val(),
              'q2_amount' : $('#q2_amount').val(),
              'q3_amount' : $('#q3_amount').val(),
              'q4_amount' : $('#q4_amount').val(),
            },
            success:function(data) {
              console.log(data);
              if(data.errors) {         
                if(data.errors.pap_id){
                  $('#pap_id').addClass('is-invalid');
                  $('#pap-error').html(data.errors.pap_id[0]);
                } 
                if(data.errors.activity_id){
                  $('#activity_id').addClass('is-invalid');
                  $('#activity-error').html(data.errors.activity_id[0]);
                } 
                if(data.errors.subactivity_id){
                  $('#subactivity_id').addClass('is-invalid');
                  $('#subactivity-error').html(data.errors.subactivity_id[0]);
                } 
                if(data.errors.expense_account_id){
                  $('#expense_account_id').addClass('is-invalid');
                  $('#expense-error').html(data.errors.expense_account_id[0]);
                }
                if(data.errors.object_expenditure_id){
                  $('#object_expenditure_id').addClass('is-invalid');
                  $('#expenditure-error').html(data.errors.object_expenditure_id[0]);
                }                                              
              }
              if(data.success) {            
                Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: 'Quarterly obligation program item has been successfully updated.',
                  showConfirmButton: false,
                  timer: 1500
                }) 
                $('#qop_modal').modal('toggle')
                window.location.reload();
              }                      
            }                             
          });                                
        }       
      })            
    })    
  {{-- update end --}}

  {{-- delete start --}}
    $('#quarterly_obligation_program_table').on('click', '.btn_delete', function(){
      id = $(this).data('id')
      Swal.fire({
        title: 'Are you sure you want to delete?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      })
      .then((result) => {
        if (result.value) {
        $.ajax({
            method: "PATCH",
            url: "{{ route('quarterly_obligation_program.delete') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'id' : id,
              'delete_qop' : 1,
            },
            success: function(data) {      
              Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Quarterly obligation program item has been successfully deleted.',
                showConfirmButton: false,
                timer: 1500
              }) 
              window.location.reload();
            }             
        })    
        }       
      })
    })   
  {{-- delete end --}} 

  {{-- forward start --}}    
    $('#forward_modal').on('hide.bs.modal', function(){
      var msg = "";
      var notif_msg = "";
      clear_attributes();
      clear_fields();      
    }); 

    $('.btn_forward').on('click', function(){      
      var msg = "";
      var notif_msg = "";
      var division_id = $(this).data('division-id');
      var year = $(this).data('year');
      var division_acronym = $(this).data('division-acronym');
      var active_status_id = $(this).data('active-status-id');
      var user_parent_division_id = $(this).data('parent-division-id')     
      var user_role_id = $(".modal-body #forward_user_role_id_from").val();   
      $(".modal-body #forward_division_id").val(division_id);
      $(".modal-body #forward_year").val(year); 
      if(user_role_id == 7 && division_acronym!='COA'){ 
        if(user_parent_division_id!=0){        
          alert_msg = "Are you sure you want to forward the quarterly obligation program to your section head?";
          notif_msg = "Section budget controller forwarded the quarterly obligation program for your approval or comment/s";
        }
        else{        
          alert_msg = "Are you sure you want to forward the quarterly obligation program to your division director?";
          notif_msg = "Division budget controller forwarded the quarterly obligation program for your approval or comment/s";
        }
        $(".modal-body #forward_status_id").val('2');
      }
else if(user_role_id == 7 && division_acronym=='COA'){        
        alert_msg = "Are you sure you want to forward the quarterly obligation program to FAD-Budget?";
        notif_msg = "COA budget controller forwarded the quarterly obligation program for your approval or comment/s";
        $(".modal-body #forward_status_id").val('6');
      }
      else if(user_role_id == 6 || user_role_id == 11){
        if(active_status_id == 3){
          if(user_role_id == 6){
            notif_msg = division_acronym + " division director forwarded their division's quarterly obligation program to FAD-Budget for approval or comment/s."; 
            alert_msg = "Are you sure you want to forward your divisions's quarterly obligation program to FAD-Budget?";     
          }
          else if(user_role_id == 11){
            notif_msg = division_acronym + " section head forwarded their sections's quarterly obligation program to FAD-Budget for approval or comment/s."; 
            alert_msg = "Are you sure you want to forward your sections's quarterly obligation program to FAD-Budget?";     
          }          
          $(".modal-body #forward_status_id").val('6');          
        }
        else if(active_status_id == 18){
          alert_msg = "Are you sure you want to forward the quarterly obligation program to your section head?";
          notif_msg = "Section budget controller forwarded the quarterly obligation program for your approval or comment/s";
          $(".modal-body #forward_status_id").val('2');
        }
      } 
      else if(user_role_id == 3 && division_acronym!='FAD-Budget'){ 
        alert_msg = "Are you sure you want to forward " + division_acronym + "'s monthly cash program to BPAC?";
        notif_msg = "FAD-Budget forwarded " + division_acronym + "'s monthly cash program to BPAC.";    
        $(".modal-body #forward_status_id").val('10');     
      }     
      else if(user_role_id == 3 && division_acronym=='FAD-Budget'){ 
        alert_msg = "Are you sure you want to forward the monthly cash program to your section head?";
        notif_msg = "Section budget controller forwarded the monthly cash program for your approval or comment/s";
        $(".modal-body #forward_status_id").val('2');     
      }       
      else if(user_role_id == 9){
        alert_msg = "Are you sure you want to approve " + division_acronym + "'s quarterly obligation program?";
        notif_msg = "BPAC Chair has approved " + division_acronym + "'s quarterly obligation program.";  
        $(".modal-body #forward_status_id").val('14');                     
      }       
      document.getElementById("forward_alert_msg").innerHTML = alert_msg; 
      $(".modal-body #forward_notif_msg").val(notif_msg);   
      $('#forward_modal').modal('toggle')            
    })

    $('.forward_qop').on('click', function(e){
      e.prevenDefault;  
      $.ajax({
        method: "POST",
        url: "{{ route('quarterly_obligation_program.postAction') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'message' : $('#forward_notif_msg').val(),      
          'division_id' : $('#forward_division_id').val(),
          'year' : $('#forward_year').val(),
          'status_id' : $('#forward_status_id').val(),
          'user_role_id_from' : $('#forward_user_role_id_from').val(),
        },
        success:function(data) {
          console.log(data);
          if(data.success) {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Quarterly obligation program has been successfully forwarded.',
                showConfirmButton: false,
                timer: 1500
            })             
            $('#forward_modal').modal('toggle') 
            window.location.reload();    
          }
        },
      });
    })
  {{-- forward end    --}}

  {{-- receive start --}}    
    $('#receive_modal').on('hide.bs.modal', function () {
      var msg = "";
      var notif_msg = "";
    }) 

    $('.btn_receive').on('click', function(){   
      var msg = "";
      var notif_msg = "";      
      var division_id = $(this).data('division-id')
      var division_acronym = $(this).data('division-acronym');
      var active_status_id = $(this).data('active-status-id');
      var year = $(this).data('year')      
      var user_role_id = $(".modal-body #receive_user_role_id_from").val();          
      var user_parent_division_id = $(this).data('parent-division-id')      
      $(".modal-body #receive_division_id").val(division_id);
      $(".modal-body #receive_division_acronym").val(division_acronym);
      $(".modal-body #receive_year").val(year);                 
      if(user_role_id == 7){
        if(active_status_id == 4){     
          if(user_parent_division_id!=0){        
            alert_msg = "Receive comment/s from section head?";
            notif_msg = division_acronym + "'s budget controller has received the comments.";
          }
          else{        
            alert_msg = "Receive comment/s from division director?";
            notif_msg = division_acronym + "'s budget controller has received the comments.";
          }
          $(".modal-body #receive_status_id").val('18');
        }  
        else if(active_status_id == 8){             
          alert_msg = "Receive comment/s from FAD-Budget?";      
          notif_msg = division_acronym + "'s budget controller has received the comments."; 
          $(".modal-body #receive_status_id").val('9');
        } 
        else if(active_status_id == 12){             
          alert_msg = "Receive comment/s from BPAC Chair?";      
          notif_msg = division_acronym + "'s budget controller has received the comments."; 
          $(".modal-body #receive_status_id").val('13');
        } 
      } 
      else if(user_role_id == 6 || user_role_id == 11){
        if(active_status_id == 2){ 
          if(user_role_id == 6){
            alert_msg = "Receive your division's quarterly obligation program?";
            notif_msg = "Division director has received the quarterly obligation program.";
          }
          else if(user_role_id == 11){
            alert_msg = "Receive your section's quarterly obligation program?";
            notif_msg = "Section head has received the quarterly obligation program.";
          }
          $(".modal-body #receive_status_id").val('3');
        }     
      } 
      else if(user_role_id == 3){        
        alert_msg = "Receive " + division_acronym + "'s quarterly obligation program?";
        notif_msg = "FAD-Budget has received " + division_acronym + "'s quarterly obligation program."; 
        if(active_status_id == 6){ 
          $(".modal-body #receive_status_id").val('7');
        }
        else if(active_status_id == 14){ 
          $(".modal-body #receive_status_id").val('15');
        }
      }   
      else if(user_role_id == 9){
        alert_msg = "Receive " + division_acronym + "'s quarterly obligation program?";
        notif_msg = "BPAC Chair has received " + division_acronym + "'s quarterly obligation program.";    
        $(".modal-body #receive_status_id").val('11');              
      }      
      document.getElementById("receive_alert_msg").innerHTML = alert_msg;
      $(".modal-body #receive_notif_msg").val(notif_msg);   
      $('#receive_modal').modal('toggle')            
    })

    $('.receive_qop').on('click', function(e){ 
      e.prevenDefault;  
      $.ajax({
        method: "POST",
        url: "{{ route('quarterly_obligation_program.postAction') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'message' : $('#receive_notif_msg').val(),
          'division_id' : $('#receive_division_id').val(),
          'year' : $('#receive_year').val(),
          'status_id' : $('#receive_status_id').val(),
          'user_role_id_from' : $('#receive_user_role_id_from').val(),
        },
        success:function(data) {
          console.log(data);
          if(data.success) {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Quarterly obligation program has been successfully received.',
                showConfirmButton: false,
                timer: 1500
            })             
            $('#receive_modal').modal('toggle')   
            window.location.reload();
          }
        },
      });
    })
  {{-- receive end    --}}  

  {{-- comment start --}}    
    $('.btn_comment').on('click', function(e){     
      e.preventDefault();
      var id = $(this).data('id');      
      var year = $(this).data('year');      
      var division_id = $(this).data('division-id');      
      var parent_division_id = $(this).data('parent-division-id');      
      var active_status_id = $(this).data('active-status-id');    
      var user_role_id = $(this).data('user-role-id');    
      $('#comment_division_id').val(division_id);             
      $('#comment_year').val(year);   
      $('#qop_id').val(id);   
      $('#comment_active_status_id').val(active_status_id);       
      if(active_status_id==3){        
        $('.add-row-director')
          .addClass('btn-sm')
          .removeClass('d-none');
      }  
      else{
        $('.add-row-director')
          .removeClass('btn-sm')
          .addClass('d-none');
      }
      if(active_status_id==7){        
        $('.add-row-budget')
          .addClass('btn-sm')
          .removeClass('d-none');
      }  
      else{
        $('.add-row-budget')
          .removeClass('btn-sm')
          .addClass('d-none');
      }
      if(active_status_id==11){        
        $('.add-row-bpac')
          .addClass('btn-sm')
          .removeClass('d-none');
      }  
      else{
        $('.add-row-bpac')
          .removeClass('btn-sm')
          .addClass('d-none');
      }
      $.getJSON( '{{ url('programming_allocation/nep/quarterly_obligation_program/division/show_comment') }}/'+id, function( data ) {
      })
      .done(function(data) {    
        var i = 0;        
        var rowCount = (data['rowCount'])  
        while (i < rowCount) {  
          comment_by = (data.comment[i].comment_by);
          comment = (data.comment[i].comment);  
          comment_id = (data.comment[i].id);
          is_resolved = (data.comment[i].is_resolved);
          if(comment_by=='6' || comment_by=='11'){  
            if(is_resolved==1){
              var tdata = '<tr><td><input type="text" name="comment_by_division_director[]" class="form-control by-director-field" style="background-color: #85cd85" value="' + comment + '" disabled></td>';
              tdata += '<td><input type="hidden" name="by_director_is_resolved[]" id="by_director_is_resolved" value="' + is_resolved + '"></td>';
              $(".director_comments_table").append(tdata);
              i++;
            } 
            else{
              var tdata = '<tr><td><input type="text" name="comment_by_division_director[]" class="form-control by-director-field" style="background-color: #e49c9c" value="' + comment + '" @if(($user_role_id!=6) && ($user_role_id!=11)) readonly @endif></td>';
              tdata += '<td><input type="hidden" name="by_director_is_resolved[]" id="by_director_is_resolved" value="' + is_resolved + '"></td>';
              tdata += '<td><input type="hidden" name="comment_id[]" id="comment_id" value="' + comment_id + '" class="form-control"><td>';     
              tdata += '<td><button type="button" data-toggle="tooltip" data-id="' + comment_id + '" data-placement="auto" title="Delete Comment" @if(($user_role_id==6 || $user_role_id==11) && $active_status_id==3) class="delete-row btn btn-danger btn-sm" @else class="d-none" @endif><i class="fa-solid fa-xmark"></i></button></td></tr>';       
              $('.director_comments_table').append(tdata); 
              i++;
            }
          }
          if(comment_by=='3'){
            if(is_resolved==1){
              var tdata = '<tr><td><input type="text" name="comment_by_budget_officer[]" class="form-control by-budget-field" style="background-color: #85cd85" value="' + comment + '" disabled></td>';
              tdata += '<td><input type="hidden" name="by_budget_is_resolved[]" id="by_budget_is_resolved" value="' + is_resolved + '"></td>';
              $(".budget_officer_comments_table").append(tdata);
              i++;
            } 
            else if(is_resolved==0 && user_role_id==3){
              if(active_status_id==7){
                var tdata = '<tr><td><input type="text" name="comment_by_budget_officer[]" class="form-control by-budget-field" style="background-color: #e49c9c" value="' + comment + '" readonly></td>';
                tdata += '<td><input type="hidden" name="by_budget_is_resolved[]" id="by_budget_is_resolved" value="' + is_resolved + '"></td>';
                tdata += '<td><button type="button" data-toggle="tooltip" data-id="' + comment_id + '" data-placement="auto" title="Delete Comment" class="delete-row btn btn-danger btn-sm"><i class="fa-solid fa-xmark"></i></button></td></tr>';       
                $(".budget_officer_comments_table").append(tdata);
                i++;
              }
              else{
                var tdata = '<tr><td><input type="text" name="comment_by_budget_officer[]" class="form-control by-budget-field" style="background-color: #e49c9c" value="' + comment + '"></td>';
                tdata += '<td><input type="hidden" name="by_budget_is_resolved[]" id="by_budget_is_resolved" value="' + is_resolved + '"></td>';
                $(".budget_officer_comments_table").append(tdata);
                i++;
              }
            }
            else if(is_resolved==0 && user_role_id!=3){
              var tdata = '<tr><td><input type="text" name="comment_by_budget_officer[]" class="form-control by-budget-field" style="background-color: #e49c9c" value="' + comment + '" disabled></td>';
              tdata += '<td><input type="hidden" name="by_budget_is_resolved[]" id="by_budget_is_resolved" value="' + is_resolved + '"></td>';
              $(".budget_officer_comments_table").append(tdata);
              i++;
            }
          }  
          if(comment_by=='9'){   
            if(is_resolved==1){
              var tdata = '<tr><td><input type="text" name="comment_by_bpac[]" class="form-control by-bpac-field" style="background-color: #85cd85" value="' + comment + '" disabled></td>';
              tdata += '<td><input type="hidden" name="by_bpac_is_resolved[]" id="by_bpac_is_resolved" value="' + is_resolved + '"></td>';
              $(".bpac_comments_table").append(tdata);
              i++;
            } 
            else if(is_resolved==0 && user_role_id==9){
              if(active_status_id==11){              
                var tdata = '<tr><td><input type="text" name="comment_by_bpac[]" class="form-control by-bpac-field" style="background-color: #e49c9c" value="' + comment + '"></td>';
                tdata += '<td><input type="hidden" name="by_bpac_is_resolved[]" id="by_bpac_is_resolved" value="' + is_resolved + '"></td>';
                tdata += '<td><input type="hidden" name="comment_id[]" id="comment_id" value="' + comment_id + '" class="form-control"></td>'; 
                tdata += '<td><button type="button" data-toggle="tooltip" data-id="' + comment_id + '" data-placement="auto" title="Delete Comment" class="delete-row btn btn-danger btn-sm"><i class="fa-solid fa-xmark"></i></button></td></tr>';
                $(".bpac_comments_table").append(tdata);
                i++;
              }
              else{
                var tdata = '<tr><td><input type="text" name="comment_by_bpac[]" class="form-control by-bpac-field" style="background-color: #e49c9c" value="' + comment + '" readonly></td>';
                tdata += '<td><input type="hidden" name="by_bpac_is_resolved[]" id="by_bpac_is_resolved" value="' + is_resolved + '"></td>';
                tdata += '<td><input type="hidden" name="comment_id[]" id="comment_id" value="' + comment_id + '" class="form-control"></td>'; 
                $(".bpac_comments_table").append(tdata);
                i++;
              }
            }
            else if(is_resolved==0 && user_role_id!=9){
              var tdata = '<tr><td><input type="text" name="comment_by_budget_officer[]" class="form-control by-budget-field" style="background-color: #e49c9c" value="' + comment + '" disabled></td>';
              tdata += '<td><input type="hidden" name="by_budget_is_resolved[]" id="by_budget_is_resolved" value="' + is_resolved + '"></td>';
              $(".budget_officer_comments_table").append(tdata);
              i++;
            }
          }            
        }  
      })
      .fail(function() {
      });
    });

    $('.save_comment').on('click', function(e){      
      e.preventDefault();
      Swal.fire({
        title: 'Are you sure you want to save changes?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      })
      .then((result) => {        
        if (result.value) {          
          var request = $.ajax({
            method: "POST",   
            dataType: 'json',         
            url: "{{ route('quarterly_obligation_program.postAction') }}",
            data:  $('#comment_form').serialize(),
            success:function(data) {
              console.log(data);
              if(data.errors) {    
                if(data.errors.comment_by_division_director){
                  $('#comment_by_division_director').addClass('is-invalid');
                  $('#director-comment-error').html(data.errors.comment_by_division_director[0]);
                }     
                if(data.errors.comment_by_budget_officer){
                  $('#comment_by_budget_officer').addClass('is-invalid');
                  $('#budget-comment-error').html(data.errors.comment_by_budget_officer[0]);
                }  
                if(data.errors.comment_by_bpac){
                  $('#comment_by_bpac').addClass('is-invalid');
                  $('#bpac-comment-error').html(data.errors.comment_by_bpac[0]);
                }
              }              
              if(data.success) {    
                Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: 'Comment has been successfully updated.',
                  showConfirmButton: false,
                  timer: 1500
                }) 
                window.location.reload();                
              }                      
            }                             
          });                                
        }       
      })            
    })   
    
    var rowIdx = 0;
    function init_comment(){
      $('.save_comment')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);
    }
    $('.add-row-director').click(function(e){
      e.preventDefault(); 
      init_comment(); 
      $('.director_comments_table').append(`
        <tr id="R${++rowIdx}">
          <td class="row-index text-center">
            <input type="text" name="comment_by_division_director[]" id="comment_by_division_director" class="form-control by-director-field is-invalid toresolved">
          </td>
          <td><input type="hidden" name="by_director_is_resolved[]" id="by_director_is_resolved" value="0"></td>
          <td class="text-center">
            <button type="text" data-toggle="tooltip" data-id="' + comment_id + '" data-placement="auto" title="Delete Comment" 
              class="remove-row btn btn-danger btn-sm"><i class="fa-solid fa-xmark"></i></button>
          </td>
        </tr>`);
      {{-- $.ajax({
        method: "POST",
        url: "{{ route('quarterly_obligation_program.postAction') }}",
        data:  $('#comment_form').serialize(),
        success:function(data) {
          console.log(data);
          var comment_id = data.comment_id; 
          if(data.success) {  
            var i = 0; 
            while(i < 1){  
              var tdata = '<tr><td><input type="text" name="comment_by_division_director[]" id="comment_by_division_director" class="form-control by-director-field is-invalid toresolved" @if(($user_role_id!=6) && ($user_role_id!=11)) readonly @endif></td>';
              tdata += '<td><input type="text" name="by_director_is_resolved[]" id="by_director_is_resolved" value="0"></td>';
              tdata += '<td><input type="text" name="comment_id[]" id="comment_id" value="' + comment_id + '" class="form-control"></td>';
              tdata += '<td><button type="button" data-toggle="tooltip" data-id="' + comment_id + '" data-placement="auto" title="Delete Comment" @if(($user_role_id==6 || $user_role_id==11) && $active_status_id==18) class="delete-row btn btn-danger btn-sm" @else class="d-none" @endif><i class="fa-solid fa-xmark"></i></button></td></tr>';             
              $('.director_comments_table').append(tdata);
              i++;                   
            }       
          }   
        },
      }); --}}      
    })
    $('.director_comments_table').on('click', '.delete-row', function () {  
      id = $(this).data('id');
      obj = $(this);
      Swal.fire({
        title: 'Are you sure you want to delete?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      })
      .then((result) => {
        if (result.value) {
        $.ajax({
            method: "PATCH",
            url: "{{ route('quarterly_obligation_program.delete') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'id' : id,
              'delete_comment' : 1,
            },
            success: function(data) {      
              Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Comment has been successfully deleted.',
                showConfirmButton: false,
                timer: 1500
              }) 
              $(obj).closest("tr").remove();
            }             
        })    
        }       
      })
      {{-- $(this).parent().parent().remove(); --}}
    });  
    $('.director_comments_table').on('click', '.remove-row', function () {
      var child = $(this).closest('tr').nextAll();
        child.each(function () {
        var id = $(this).attr('id');
        var idx = $(this).children('.row-index').children('p');
        var dig = parseInt(id.substring(1));
        idx.html(`Row ${dig - 1}`);
        $(this).attr('id', `R${dig - 1}`);
      });
      $(this).closest('tr').remove();
      rowIdx--;
    });

    $('.add-row-budget').click(function(e){
      e.preventDefault(); 
      init_comment(); 
      $('.budget_officer_comments_table').append(`
        <tr id="R${++rowIdx}">
          <td class="row-index text-center">
            <input type="text" name="comment_by_budget_officer[]" id="comment_by_budget_officer" class="form-control by-director-field is-invalid toresolved">
          </td>
          <td><input type="hidden" name="by_budget_is_resolved[]" id="by_budget_is_resolved" value="0"></td>
          <td class="text-center">
            <button type="text" data-toggle="tooltip" data-id="' + comment_id + '" data-placement="auto" title="Delete Comment" 
              class="remove-row btn btn-danger btn-sm"><i class="fa-solid fa-xmark"></i></button>
          </td>
        </tr>`);
    })
    $('.budget_officer_comments_table').on('click', '.delete-row', function () {  
      id = $(this).data('id');
      obj = $(this);
      Swal.fire({
        title: 'Are you sure you want to delete?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      })
      .then((result) => {
        if (result.value) {
        $.ajax({
            method: "PATCH",
            url: "{{ route('quarterly_obligation_program.delete') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'id' : id,
              'delete_comment' : 1,
            },
            success: function(data) {      
              Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Comment has been successfully deleted.',
                showConfirmButton: false,
                timer: 1500
              }) 
              $(obj).closest("tr").remove();
            }             
        })    
        }       
      })
    }); 
    $('.budget_officer_comments_table').on('click', '.remove-row', function () {
      var child = $(this).closest('tr').nextAll();
        child.each(function () {
        var id = $(this).attr('id');
        var idx = $(this).children('.row-index').children('p');
        var dig = parseInt(id.substring(1));
        idx.html(`Row ${dig - 1}`);
        $(this).attr('id', `R${dig - 1}`);
      });
      $(this).closest('tr').remove();
      rowIdx--;
    });
    
    $('.add-row-bpac').click(function(e){
      e.preventDefault(); 
      init_comment(); 
      $('.bpac_comments_table').append(`
        <tr id="R${++rowIdx}">
          <td class="row-index text-center">
            <input type="text" name="comment_by_bpac[]" id="comment_by_bpac" class="form-control by-director-field is-invalid toresolved">
          </td>
          <td><input type="hidden" name="by_bpac_is_resolved[]" id="by_bpac_is_resolved" value="0"></td>
          <td class="text-center">
            <button type="text" data-toggle="tooltip" data-id="' + comment_id + '" data-placement="auto" title="Delete Comment" 
              class="remove-row btn btn-danger btn-sm"><i class="fa-solid fa-xmark"></i></button>
          </td>
        </tr>`);
    })
    $('.bpac_comments_table').on('click', '.delete-row', function () {  
      id = $(this).data('id');
      obj = $(this);
      Swal.fire({
        title: 'Are you sure you want to delete?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      })
      .then((result) => {
        if (result.value) {
        $.ajax({
            method: "PATCH",
            url: "{{ route('quarterly_obligation_program.delete') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'id' : id,
              'delete_comment' : 1,
            },
            success: function(data) {      
              Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Comment has been successfully deleted.',
                showConfirmButton: false,
                timer: 1500
              }) 
              $(obj).closest("tr").remove();
            }             
        })    
        }       
      })
    }); 
    $('.bpac_comments_table').on('click', '.remove-row', function () {
      var child = $(this).closest('tr').nextAll();
        child.each(function () {
        var id = $(this).attr('id');
        var idx = $(this).children('.row-index').children('p');
        var dig = parseInt(id.substring(1));
        idx.html(`Row ${dig - 1}`);
        $(this).attr('id', `R${dig - 1}`);
      });
      $(this).closest('tr').remove();
      rowIdx--;
    });

    
  {{-- comment end    --}}
  
  {{-- forward comment start --}}    
    $('.btn_forward_comment').on('click', function(){  
      var msg = "";
      var notif_msg = "";
      var division_id=$(this).data('division-id');     
      var year=$(this).data('year');        
      var division_acronym = $(this).data('division-acronym');
      var active_status_id = $(this).data('active-status-id');
      var user_parent_division_id = $(this).data('parent-division-id')   
      var user_role_id = $(".modal-body #forward_comment_user_role_id_from").val();  
      $(".modal-body #forward_comment_division_id").val(division_id);
      $(".modal-body #forward_comment_year").val(year);  
      if(user_role_id == 6 || user_role_id == 11){
        if(active_status_id == 3){
          if(user_role_id == 6){
            notif_msg = division_acronym + " division director has forwarded comments for your revision."; 
            alert_msg = "Are you sure you want to forward comments to your division's budget controller?";     
          }
          else if(user_role_id == 11){
            notif_msg = division_acronym + " section head has forwarded comments for your revision."; 
            alert_msg = "Are you sure you want to forward comment to your sections's budget controller?";     
          }          
          $(".modal-body #forward_comment_status_id").val('4');          
        }
      } 
      else if(user_role_id == 3){ 
        alert_msg = "Are you sure you want to forward comments to " + division_acronym + " budget controller?";
        notif_msg = "FAD-Budget forwarded comments to " + division_acronym + "'s budget controller.";    
        $(".modal-body #forward_comment_status_id").val('8');                
      }     
      else if(user_role_id == 9){
        alert_msg = "Are you sure you want to forward comments to " + division_acronym + " budget controller?";
        notif_msg = "BPAC Chair forwarded comments to " + division_acronym + "'s budget controller.";    
        $(".modal-body #forward_comment_status_id").val('12');            
      }       
      document.getElementById("forward_comment_alert_msg").innerHTML = alert_msg; 
      $(".modal-body #forward_comment_notif_msg").val(notif_msg);   
      $('#forward_comment_modal').modal('toggle')            
    })

    $('.forward_comment').on('click', function(e){  
      e.prevenDefault;  
      $.ajax({
        method: "POST",
        url: "{{ route('quarterly_obligation_program.postAction') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'message' : $('#forward_comment_notif_msg').val(),
          'division_id' : $('#forward_comment_division_id').val(),
          'year' : $('#forward_comment_year').val(),
          'user_role_id_from' : $('#forward_comment_user_role_id_from').val(),
          'status_id' : $('#forward_comment_status_id').val(),
        },
        success:function(data) {
          console.log(data);
          if(data.success) {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Comment/s has been successfully forwarded.',
                showConfirmButton: false,
                timer: 1500
            })             
            $('#forward_comment_modal').modal('toggle')
            window.location.reload();          
          }
        },
      });
    })
  {{-- forward comment end    --}}

  {{-- reverse start --}}  
    $('.btn_reverse').on('click', function(){    
      var msg = "";
      var notif_msg = "";
      var division_id = $(this).data('division-id');
      var year = $(this).data('year');
      var division_acronym = $(this).data('division-acronym');
      var active_status_id = $(this).data('active-status-id');
      var user_parent_division_id = $(this).data('parent-division-id') 
      var user_role_id = $(".modal-body #reverse_user_role_id_from").val();       
      $(".modal-body #reverse_division_id").val(division_id);
      $(".modal-body #reverse_year").val(year);     
      alert(user_role_id);
      if(user_role_id == 3){         
        alert_msg = "Are you sure you want to reverse the forwarding of " + division_acronym + "'s quarterly obligation program from BPAC?";
        notif_msg = "FAD-Budget reverse the forwarding of " + division_acronym + "'s quarterly obligation program from BPAC.";
        $(".modal-body #reverse_status_id").val('7');                
      }  
      document.getElementById("reverse_alert_msg").innerHTML = alert_msg; 
      $(".modal-body #reverse_notif_msg").val(notif_msg);   
      $('#reverse_modal').modal('toggle')            
    })
    
    $('.reverse_qop').on('click', function(e){
      e.prevenDefault;  
      $.ajax({
        method: "POST",
        url: "{{ route('quarterly_obligation_program.postAction') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'message' : $('#reverse_notif_msg').val(),
          'division_id' : $('#reverse_division_id').val(),
          'year' : $('#reverse_year').val(),          
          'status_id' : $('#reverse_status_id').val(),
          'user_role_id_from' : $('#reverse_user_role_id_from').val(),
        },
        success:function(data) {
          console.log(data);
          if(data.success) {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Quarterly obligation program has been successfully reversed.',
                showConfirmButton: false,
                timer: 1500
            })             
            $('#reverse_modal').modal('toggle') 
            window.location.reload();    
          }
        },
      });
    })
  {{-- reverse end    --}}
{{-- END --}}