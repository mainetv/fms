
{{-- START --}}
  {{-- modal start --}}
    $('#cp_modal').on('hide.bs.modal', function(){
      init_view_cp();
      clear_attributes();
      clear_fields();      
    }); 
    
    $('#cp_modal').on('shown.bs.modal', function () {
      $('#pap_id').focus();
    })  

    $("#comment_modal").on("hidden.bs.modal", function(){ 
      $('.director_comments_tbody tr').remove();
      $('.fad_budget_comments_tbody tr').remove();
    });
  {{-- modal end --}}

  {{-- view start --}}   
    function init_view_cp(){
      $('.cp-field')
        .val('')
        .attr('disabled', true);

      $('.save-buttons')
        .removeClass('d-inline')
        .addClass('d-none')
        .attr('disabled', true);
    }
  {{-- view end --}}

  {{-- add start --}}     
    function init_add_cash_program(){
      $('.cp-field')
        .attr('disabled', false);
        
      $('.add_cash_program.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);      
    }
    
    $('#monthly_cash_program_table').on('click', '.btn_add', function(){          
      init_add_cash_program();   
      var division_id = $(this).data('division-id');
      var year = $(this).data('year');
      $(".modal-body #division_id").val(division_id);
      $(".modal-body #year").val(year);
      $('#cp_modal_header').html("Add New Cash Program Item");        
      $('#cp_modal').modal('toggle')       
    })

    $('.add_cash_program').on('click', function(e){     
      e.prevenDefault;  
      clear_attributes();      
      $.ajax({
        method: "POST",
        url: "{{ route('monthly_cash_programs.postAction') }}",
        data: {
          '_token': '{{ csrf_token() }}',      
          'add_cash_program' : 1,
          'division_id' : $('#division_id').val(),
          'year' : $('#year').val(),
          'pap_id' : $('#pap_id').val(),
          'activity_id' : $('#activity_id').val(),
          'subactivity_id' : $('#subactivity_id').val(),
          'expense_account_id' : $('#expense_account_id').val(),
          'object_expenditure_id' : $('#object_expenditure_id').val(),
          'object_specific_id' : $('#object_specific_id').val(),
          'pooled_at_division_id' : $('#pooled_at_division_id').val(),
          'jan_amount' : $('#jan_amount').val(),
          'feb_amount' : $('#feb_amount').val(),
          'mar_amount' : $('#mar_amount').val(),
          'apr_amount' : $('#apr_amount').val(),
          'may_amount' : $('#may_amount').val(),
          'jun_amount' : $('#jun_amount').val(),
          'jul_amount' : $('#jul_amount').val(),
          'aug_amount' : $('#aug_amount').val(),
          'sep_amount' : $('#sep_amount').val(),
          'oct_amount' : $('#oct_amount').val(),
          'nov_amount' : $('#nov_amount').val(),
          'dec_amount' : $('#dec_amount').val(),
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
              title: 'Monthly cash program item has been successfully added.',
              showConfirmButton: false,
              timer: 1500
            })   
            $('#cp_modal').modal('toggle');

            window.location.reload();
            $('#vert-tabs-tab a').click(function(e) {
              e.preventDefault();
              $(this).tab('show');
            });
  
            {{-- // store the currently selected tab in the hash value --}}
            $("div.nav-tabs > a").on("shown.bs.tab", function(e) {
                var id = $(e.target).attr("href").substr(1);
                window.location.hash = id;
            });
  
            {{-- // on load of the page: switch to the currently selected tab --}}
            var hash = window.location.hash;
            $('#vert-tabs-tab a[href="' + hash + '"]').tab('show');                    
          }
        },
      });
    })   
  {{-- add end    --}}

  {{-- update start --}}
    function init_edit_cash_program(){      
      init_view_cp();
      $('.cp-field')
        .attr('disabled', false);

      $('.edit_cash_program.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);
    }

    $('#monthly_cash_program_table').on('click', '.btn_edit', function(){
      $('#cp_modal_header').html("Edit Cash Program Item");        
      init_edit_cash_program();
      id = $(this).data('id')
      $(".modal-body #id").val(id);
      $.getJSON( '{{ url('programming_allocation/nep/monthly_cash_programs/division/show') }}/'+id, function( data ) {
      })
      .done(function(data) {    
        $('#pap_id').val(data['cash_program']['pap_id']).change()
        view_subactivity_by_activity_id(
          data['cash_program']['activity_id'],
          data['cash_program']['subactivity_id'],
        )
        view_object_expenditure_by_expense_account_id(
          data['cash_program']['expense_account_id'],
          data['cash_program']['object_expenditure_id'],
        )
        view_object_specific_by_object_expenditure_id(
          data['cash_program']['object_expenditure_id'],
          data['cash_program']['object_specific_id'],
        )
        $('#pooled_at_division_id').val(data['cash_program']['pooled_at_division_id']).change()
        $('#jan_amount').val(data['cash_program']['jan_amount']).change()
        $('#feb_amount').val(data['cash_program']['feb_amount']).change()
        $('#mar_amount').val(data['cash_program']['mar_amount']).change()
        $('#apr_amount').val(data['cash_program']['apr_amount']).change()
        $('#may_amount').val(data['cash_program']['may_amount']).change()
        $('#jun_amount').val(data['cash_program']['jun_amount']).change()
        $('#jul_amount').val(data['cash_program']['jul_amount']).change()
        $('#aug_amount').val(data['cash_program']['aug_amount']).change()
        $('#sep_amount').val(data['cash_program']['sep_amount']).change()
        $('#oct_amount').val(data['cash_program']['oct_amount']).change()
        $('#nov_amount').val(data['cash_program']['nov_amount']).change()
        $('#dec_amount').val(data['cash_program']['dec_amount']).change()       
      })
      .fail(function() {
      });  
      $('#cp_modal').modal('toggle')            
    })

    $('.edit_cash_program').on('click', function(e){   
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
            url: "{{ route('monthly_cash_programs.update') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'edit_cash_program' : 1,
              'id' : $('#id').val(),
              'division_id' : $('#division_id').val(),
              'year' : $('#year').val(),
              'pap_id' : $('#pap_id').val(),
              'activity_id' : $('#activity_id').val(),
              'subactivity_id' : $('#subactivity_id').val(),
              'expense_account_id' : $('#expense_account_id').val(),
              'object_expenditure_id' : $('#object_expenditure_id').val(),
              'object_specific_id' : $('#object_specific_id').val(),
              'pooled_at_division_id' : $('#pooled_at_division_id').val(),
              'jan_amount' : $('#jan_amount').val(),
              'feb_amount' : $('#feb_amount').val(),
              'mar_amount' : $('#mar_amount').val(),
              'apr_amount' : $('#apr_amount').val(),
              'may_amount' : $('#may_amount').val(),
              'jun_amount' : $('#jun_amount').val(),
              'jul_amount' : $('#jul_amount').val(),
              'aug_amount' : $('#aug_amount').val(),
              'sep_amount' : $('#sep_amount').val(),
              'oct_amount' : $('#oct_amount').val(),
              'nov_amount' : $('#nov_amount').val(),
              'dec_amount' : $('#dec_amount').val(),
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
                  title: 'Monthly cash program item has been successfully updated.',
                  showConfirmButton: false,
                  timer: 1500
                }) 
                $('#cp_modal').modal('toggle')
                window.location.reload();
              }                      
            }                             
          });                                
        }       
      })            
    })    
  {{-- update end --}}

  {{-- delete start --}}
    $('#monthly_cash_program_table').on('click', '.btn_delete', function(){
      id = $(this).data('id')
      delete_cash_program(id);
    })
    function delete_cash_program(id){
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
            url: "{{ route('monthly_cash_programs.delete') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'id' : id,
              'delete_cash_program' : 1,
            },
            success: function(data) {      
              Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Monthly cash program item has been successfully deleted.',
              showConfirmButton: false,
              timer: 1500
              }) 
              window.location.reload();
            }             
        })    
        }       
      })
    }    
  {{-- delete end --}} 

  {{-- comment start --}}
    function view_comment(id){
      var request = $.ajax({
        method: "GET",
        dataType: "json",
        url: "{{ route('monthly_cash_programs.show_comment') }}",
        data: {
        '_token': '{{ csrf_token() }}',
        'id' : id
        }
      });
      return request;
    }  
    
    $('.btn_comment').on('click', function(){ 
      var id = $(this).data('id');
      var user_role_id = $('#comment_by_user_role_id').val();
      $('#cash_program_id').val(id);
      var request = view_comment(id);   
      request.then(function(data) {        
        if(data['status'] == 1){  
          var i = 0;
          var rowCount = (data['rowCount'])  
          while (i < rowCount) {  
            comment_by = (data.comment[i].comment_by);
            comment = (data.comment[i].comment);  
            comment_id = (data.comment[i].id);
            is_resolved = (data.comment[i].is_resolved);            
            if(comment_by=='Division Director'){  
              if(is_resolved==1){
                var tdata = '<tr><td><input type="text" name="comment_by_division_director[]" class="form-control by-director-field" style="background-color: #85cd85"  value=' + comment + ' disabled></td>';
                tdata += '<td><input type="hidden" name="by_director_is_resolved[]" id="by_director_is_resolved" value="' + is_resolved + '"></td>';
                $(".director_comments_table").append(tdata);
                i++;
              } 
              else{
                var tdata = '<tr><td><input type="text" name="comment_by_division_director[]" class="form-control by-director-field" style="background-color: #e49c9c" value=' + comment + ' @if($user_role_id!=6) readonly @endif></td>';
                tdata += '<td><input type="hidden" name="by_director_is_resolved[]" id="by_director_is_resolved" value="' + is_resolved + '"></td>';
                tdata += '<td><button type="button" data-toggle="tooltip" data-placement="auto" title="Delete Comment" @if($user_role_id==6) class="remove-row btn btn-danger btn-sm" @else class="d-none" @endif><i class="fa-solid fa-xmark"></i></button></td></tr>';
                $(".director_comments_table").append(tdata);
                i++;
              }
            }
            if(comment_by=='FAD-Budget'){
              if(is_resolved==1){
                var tdata = '<tr><td><input type="text" name="comment_by_fad_budget[]" class="form-control by-budget-field" style="background-color: #85cd85"  value=' + comment + ' disabled></td>';
                tdata += '<td><input type="hidden" name="by_fad_budget_is_resolved[]" id="by_fad_budget_is_resolved" value="' + is_resolved + '"></td>';
                $(".fad_budget_comments_table").append(tdata);
                i++;
              } 
              else{
                var tdata = '<tr><td><input type="text" name="comment_by_fad_budget[]" class="form-control by-budget-field" style="background-color: #e49c9c" value=' + comment + ' @if($user_role_id!=3) readonly @endif></td>';
                tdata += '<td><input type="hidden" name="by_fad_budget_is_resolved[]" id="by_fad_budget_is_resolved" value="' + is_resolved + '"></td>';
                tdata += '<td><button type="button" data-toggle="tooltip" data-placement="auto" title="Delete Comment" @if($user_role_id==3) class="remove-row btn btn-danger btn-sm" @else class="d-none" @endif><i class="fa-solid fa-xmark"></i></button></td></tr>';
                $(".fad_budget_comments_table").append(tdata);
                i++;
              }
            }             
          }              
        }        
      })            
    });


    $('.save_comment').on('click', function(){ 
      comment_by_user_role_id = $('#comment_by_user_role_id').val();
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
            url: "{{ route('monthly_cash_programs.postAction') }}",
            data:  $('#save_comment_form').serialize(),
            dataType: 'json',
            success:function(data) {
                console.log(data);
                if(data.errors) {         
                  if(comment_by_user_role_id == '6'){
                    if(data.errors.comment_by_division_director){                      
                      $('#comment-director-error').html(data.errors.comment_by_division_director[0]);
                    }     
                  }   
                  else if(comment_by_user_role_id == '3'){
                    if(data.errors.comment_by_fad_budget){
                      $('#comment-budget-error').html(data.errors.comment_by_fad_budget[0]);
                    }
                  } 
                }
                if(data.success) {            
                  Swal.fire({
                      position: 'top-end',
                      icon: 'success',
                      title: 'Comment has been successfully saved.',
                      showConfirmButton: false,
                      timer: 1500
                  }) 
                  $('#comment_modal').modal('toggle')
                  window.location.reload();
                }                      
            }                             
          });                                
        }       
      })   
    })  

    $('.add-row-director').click(function(e){
      e.preventDefault();      
      var tdata = '<tr><td><input type="text" name="comment_by_division_director[]" id="comment_by_division_director" class="form-control by-director-field is-invalid toresolved" @if($user_role_id!=6) readonly @endif></td>';
      {{-- tdata += '<td><input type="checkbox" name="by_director_is_resolved[]" id="by_director_is_resolved" @if($user_role_id!=6) disabled @endif></td>'; --}}
      tdata += '<td><input type="hidden" name="by_director_is_resolved[]" id="by_director_is_resolved" value="0"></td>';
     tdata += '<td><button type="button" data-toggle="tooltip" data-placement="auto" title="Delete Comment" @if($user_role_id==6) class="remove-row btn btn-danger btn-sm" @else class="d-none" @endif><i class="fa-solid fa-xmark"></i></button></td></tr>';
      $('.director_comments_table').append(tdata); 
    });
    $('.director_comments_table').on('click', '.remove-row', function () {  
      $(this).parent().parent().remove();
    });   

    $('.add-row-budget').click(function(e){
      e.preventDefault();
      var tdata = '<tr><td><input type="text" class="form-control by-fad-budget-field" name="comment_by_fad_budget[]" id="comment_by_fad_budget" @if($user_role_id!=6) readonly @endif></td>';
      {{-- tdata += '<td><input type="checkbox" name="by_fad_budget_is_resolved[]" id="by_director_is_resolved" @if($user_role_id!=3) disabled @endif></td>'; --}}
      tdata += '<td><button type="button" data-toggle="tooltip" data-placement="auto" title="Delete Comment" @if($user_role_id==3) class="remove-row btn btn-danger btn-sm" @else class="d-none" @endif><i class="fa-solid fa-xmark"></i></button></td></tr>';
      $('.fad_budget_comments_table').append(tdata); 
    });
    $('.fad_budget_comments_table').on('click', '.remove-row', function () {  
      $(this).parent().parent().remove();
    });
  {{-- comment end    --}} 

  {{-- forward comment start --}}    
    $('.btn_forward_comment').on('click', function(){  
      var division_id=$(this).data('division-id');     
      var year=$(this).data('year');   
      $('#forward_comment_division_id').val(division_id);
      $('#forward_comment_year').val(year);
      $('#forward_comment_modal').modal('toggle')       
    })

    $('.forward_comment').on('click', function(e){  
      e.prevenDefault;  
      $.ajax({
        method: "POST",
        url: "{{ route('monthly_cash_programs.postAction') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'message' : $('#forward_comment_notif_message').val(),
          'division_id' : $('#forward_comment_division_id').val(),
          'year' : $('#forward_comment_year').val(),
          'division_id_from' : $('#forward_comment_division_id_from').val(),
          'division_id_to' : $('#forward_comment_division_id_to').val(),
          'user_role_id_to' : $('#forward_comment_user_role_id_to').val(),
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
      division_id = $(this).data('division-id');
      year = $(this).data('year');
      division_acronym = $(this).data('division-acronym');
      active_status_id = $(this).data('active-status-id');
      user_parent_division_id = $(this).data('parent-division-id')     
      $(".modal-body #forward_division_id").val(division_id);
      $(".modal-body #forward_year").val(year);            
      var user_role_id = $(".modal-body #forward_user_role_id").val();   
      alert(user_role_id);
      if(user_role_id == 7){ 
        if(active_status_id==16){
          if(user_parent_division_id!=0){        
            alert_msg = "Are you sure you want to forward the monthly cash program to your section head?";
            notif_msg = "Section budget controller forwarded the monthly cash program for your approval or comment/s";
          }
          else{        
            alert_msg = "Are you sure you want to forward the monthly cash program to your division director?";
            notif_msg = "Division budget controller forwarded the monthly cash program for your approval or comment/s";
          }
          $(".modal-body #forward_status_id").val('17');
        }
        else if(active_status_id == 3){ 
          notif_msg = division_acronym + " section head forwarded their sections's monthly cash program to FAD-Budget for approval or comment/s."; 
          alert_msg = "Are you sure you want to forward your sections's monthly cash program to FAD-Budget?";     
          $(".modal-body #forward_status_id").val('8');      
        }        
      }
      else if(user_role_id == 6 || user_role_id == 11){
        if(active_status_id == 18){
          if(user_role_id == 6){
            notif_msg = division_acronym + " division director forwarded their division's monthly cash program to FAD-Budget for approval or comment/s."; 
          }
          else if(user_role_id == 11){
            notif_msg = division_acronym + " section head forwarded their sections's monthly cash program to FAD-Budget for approval or comment/s."; 
          }
          alert_msg = "Are you sure you want to forward your sections's monthly cash program to FAD-Budget?";     
          $(".modal-body #forward_status_id").val('8');          
        }
      } 
      else if(user_role_id == 3){ 
        if(active_status_id == 24 || division_id==3){
          alert_msg = "Are you sure you want to forward " + division_acronym + "'s monthly cash program to BPAC?";
          notif_msg = "FAD-Budget forwarded " + division_acronym + "'s monthly cash program to BPAC.";    
          $(".modal-body #forward_status_id").val('25');            
        }
        else if(active_status_id == 35){
          alert_msg = "Are you sure you want to forward " + division_acronym + "'s monthly cash program to quarterly obligation program (NEP)?";
          notif_msg = "FAD-Budget forwarded " + division_acronym + "'s monthly cash program to quarterly obligation program (NEP).";  
          $(".modal-body #forward_status_id").val('36');        
        }       
      }     
      else if(user_role_id == 9){
        if(active_status_id == 26){
          alert_msg = "Are you sure you want to forward " + division_acronym + "'s monthly cash program to Executive Director?";   
          notif_msg = "BPAC Chair forwarded " + division_acronym + "'s monthly cash program to Executive Director.";   
          $(".modal-body #forward_status_id").val('31');     
        }               
      }
      else if(user_role_id == 10){
        alert_msg = "Are you sure you want to approve " + division_acronym + "'s monthly cash program?";
        notif_msg = "Executive Director has approved " + division_acronym + "'s monthly cash program.";  
        $(".modal-body #forward_status_id").val('14');                     
      }       
      document.getElementById("forward_alert_msg").innerHTML = alert_msg; 
      $(".modal-body #forward_notif_msg").val(notif_msg);   
      $('#forward_modal').modal('toggle')            
    })

    $('.forward_monthly_cash_program').on('click', function(e){
      e.prevenDefault;  
      $.ajax({
        method: "POST",
        url: "{{ route('monthly_cash_programs.postAction') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'message' : $('#forward_notif_msg').val(),
          'division_id' : $('#forward_division_id').val(),
          'year' : $('#forward_year').val(),          
          'status_id' : $('#forward_status_id').val(),
          'user_role_id' : $('#forward_user_role_id').val(),
        },
        success:function(data) {
          console.log(data);
          if(data.success) {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Division monthly cash program has been successfully forwarded.',
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
      division_id = $(this).data('division-id')
      division_acronym = $(this).data('division-acronym');
      active_status_id = $(this).data('active-status-id');
      year = $(this).data('year')      
      user_parent_division_id = $(this).data('parent-division-id')      
      $(".modal-body #receive_division_id").val(division_id);
      $(".modal-body #receive_division_acronym").val(division_acronym);
      $(".modal-body #receive_year").val(year);      
      var user_role_id = $(".modal-body #receive_user_role_id").val();    
      {{-- alert(active_status_id); --}}
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
          $(".modal-body #receive_status_id").val('5');
        }  
        else if(active_status_id == 6){             
          alert_msg = "Receive comment/s from FAD-Budget?";      
          notif_msg = division_acronym + "'s budget controller has received the comments."; 
          $(".modal-body #receive_status_id").val('7');
        } 
        else if(active_status_id == 28){             
          alert_msg = "Receive comment/s from BPAC Chair?";      
          notif_msg = division_acronym + "'s budget controller has received the comments."; 
          $(".modal-body #receive_status_id").val('29');
        } 
        else{
          alert_msg = "Receive your section's monthly cash program?";
          notif_msg = "Section head has received the monthly cash program.";
          $(".modal-body #receive_status_id").val('3');
        } 
      } 
      else if(user_role_id == 6 || user_role_id == 11){
        if(active_status_id == 2){ 
          if(user_role_id == 6){
            alert_msg = "Receive your division's monthly cash program?";
            notif_msg = "Division director has received the monthly cash program.";
          }
          else if(user_role_id == 11){
            alert_msg = "Receive your section's monthly cash program?";
            notif_msg = "Section head has received the monthly cash program.";
          }
          $(".modal-body #receive_status_id").val('3');
        }     
      } 
      else if(user_role_id == 3){
        alert_msg = "Receive " + division_acronym + "'s monthly cash program?";
        notif_msg = "FAD-Budget has received " + division_acronym + "'s monthly cash program."; 
        $(".modal-body #receive_status_id").val('9');
      }   
      else if(user_role_id == 9){
        alert_msg = "Receive " + division_acronym + "'s monthly cash program?";
        notif_msg = "BPAC Chair has received " + division_acronym + "'s monthly cash program.";    
        $(".modal-body #receive_status_id").val('11');              
      }
      else if(user_role_id == 10){
        alert_msg = "Receive " + division_acronym + "'s monthly cash program?";
        notif_msg = "Executive Director has received " + division_acronym + "'s monthly cash program.";         
        $(".modal-body #receive_status_id").val('13');           
      }        
      document.getElementById("receive_alert_msg").innerHTML = alert_msg;
      $(".modal-body #receive_notif_msg").val(notif_msg);   
      $('#receive_modal').modal('toggle')            
    })

    $('.receive_monthly_cash_program').on('click', function(e){ 
      e.prevenDefault;  
      $.ajax({
        method: "POST",
        url: "{{ route('monthly_cash_programs.postAction') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'message' : $('#receive_notif_msg').val(),
          'division_id' : $('#receive_division_id').val(),
          'year' : $('#receive_year').val(),
          'status_id' : $('#receive_status_id').val(),
        },
        success:function(data) {
          console.log(data);
          if(data.success) {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Division monthly cash program has been successfully received.',
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
{{-- END --}}