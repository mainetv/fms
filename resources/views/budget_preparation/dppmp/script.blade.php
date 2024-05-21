
{{-- START --}}
  {{-- modal start --}}
    $('#bp_modal').on('hide.bs.modal', function(){
      init_view_bp();
      clear_attributes();
      clear_fields();      
    });    

    $('#bp_modal').on('shown.bs.modal', function () {
      $('#pap_id').focus();
    })  

    $("#comment_modal").on("hidden.bs.modal", function(){ 
      $('.director_comments_tbody tr').remove();
      $('.fad_budget_comments_tbody tr').remove();
    });
  {{-- modal end --}}

  {{-- view start --}}   
    function init_view_bp(){
      $('.bp-field')
        .val('')
        .attr('disabled', true);

      $('.save-buttons')
        .removeClass('d-inline')
        .addClass('d-none')
        .attr('disabled', true);
    }
    function view_bp(id){
      var request = $.ajax({
        method: "GET",
        url: "{{ route('division_proposals.show') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'id' : id,
        }
      });
      return request;
    }   
  {{-- view end --}}

  {{-- add start --}}
    function init_add_budget_proposal(){
      $('.bp-field')
        .attr('disabled', false);
        
      $('.add_budget_proposal.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);      
    }
    
    $('#budget_proposal_table').on('click', '.btn_add', function(){  
      init_add_budget_proposal();   
      var division_id = $(this).data('division-id');
      var year = $(this).data('year');
      $(".modal-body #division_id").val(division_id);
      $(".modal-body #year").val(year);
      $('#bp_modal_header').html("Add New Budget Proposal Item");        
      $('#bp_modal').modal('toggle')       
    })

    $('.add_budget_proposal').on('click', function(e){     
      e.prevenDefault;  
      clear_attributes();      
      $.ajax({
        method: "POST",
        url: "{{ route('division_proposals.postAction') }}",
        data: {
          '_token': '{{ csrf_token() }}',      
          'add_budget_proposal' : 1,
          'division_id' : $('#division_id').val(),
          'year' : $('#year').val(),
          'pap_id' : $('#pap_id').val(),
          'activity_id' : $('#activity_id').val(),
          'subactivity_id' : $('#subactivity_id').val(),
          'expense_account_id' : $('#expense_account_id').val(),
          'object_expenditure_id' : $('#object_expenditure_id').val(),
          'object_specific_id' : $('#object_specific_id').val(),
          'pooled_at_division_id' : $('#pooled_at_division_id').val(),
          'fy1_amount' : $('#fy1_amount').val(),
          'fy2_amount' : $('#fy2_amount').val(),
          'fy3_amount' : $('#fy3_amount').val(),   
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
              title: 'Record has been successfully added.',
              showConfirmButton: false,
              timer: 1500
            })   
            $('#bp_modal').modal('toggle');
            window.location=window.location;
          }
        },
      });
    })      
  {{-- add end    --}}

  {{-- edit start --}}
    function init_edit_budget_proposal(){      
      init_view_bp();
      $('.bp-field')
        .attr('disabled', false);

      $('.edit_budget_proposal.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);
    }

    $('#budget_proposal_table').on('click', '.btn_edit', function(){
      $('#bp_modal_header').html("Edit Budget Proposal Item");        
      init_edit_budget_proposal();
      id = $(this).data('id')
      $(".modal-body #id").val(id);
      var request = view_bp(id);
      request.then(function(data) {
        if(data['status'] == 1){   
          $('#pap_id').val(data['budget_proposal']['pap_id']).change()
          view_activity_subactivity(
            data['budget_proposal']['activity_id'],
            data['budget_proposal']['subactivity_id'],
          )
          $('#expense_account_id').val(data['budget_proposal']['expense_account_id']).change()          
          view_object(
            data['budget_proposal']['object_expenditure_id'],
            data['budget_proposal']['object_specific_id'],
          )
          $('#pooled_at_division_id').val(data['budget_proposal']['pooled_at_division_id']).change()
          $('#fy1_amount').val(data['budget_proposal']['fy1_amount']).change()
          $('#fy2_amount').val(data['budget_proposal']['fy2_amount']).change()
          $('#fy3_amount').val(data['budget_proposal']['fy3_amount']).change()
        }           
      })
      $('#bp_modal').modal('toggle')            
    })

    $('.edit_budget_proposal').on('click', function(e){        
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
            url: "{{ route('division_proposals.update') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'edit_budget_proposal' : 1,
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
              'fy1_amount' : $('#fy1_amount').val(),
              'fy2_amount' : $('#fy2_amount').val(),
              'fy3_amount' : $('#fy3_amount').val(), 
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
                  title: 'Record has been successfully edited.',
                  showConfirmButton: false,
                  timer: 1500
                }) 
                $('#bp_modal').modal('toggle')
                window.location=window.location;
              }                      
            }                             
          });                                
        }       
      })            
    })    
  {{-- edit end --}}

  {{-- delete start --}}
    $('#budget_proposal_table').on('click', '.btn_delete', function(){
      id = $(this).data('id')
      delete_budget_proposal(id);
    })
    function delete_budget_proposal(id){
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
            url: "{{ route('division_proposals.delete') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'id' : id,
              'delete_budget_proposal' : 1,
            },
            success: function(data) {      
              Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Record has been successfully deleted.',
              showConfirmButton: false,
              timer: 1500
              }) 
              window.location=window.location;
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
        url: "{{ route('division_proposals.show_comment') }}",
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
      $('#budget_proposal_id').val(id);
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
            url: "{{ route('division_proposals.postAction') }}",
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
                  window.location=window.location;

                }                      
            }                             
          });                                
        }       
      })   
    })     

    $('.add-row-director').click(function(e){
      e.preventDefault();      
      var tdata = '<tr><td><input type="text" name="comment_by_division_director[]" id="comment_by_division_director" class="form-control by-director-field is-invalid toresolved" @if($user_role_id!=6) readonly @endif></td>';
      tdata += '<td><input type="hidden" name="by_director_is_resolved[]" id="by_director_is_resolved" value="0"></td>';
      tdata += '<td><button type="button" data-toggle="tooltip" data-placement="auto" title="Delete Comment" @if($user_role_id==6) class="remove-row btn btn-danger btn-sm" @else class="d-none" @endif><i class="fa-solid fa-xmark"></i></button></td></tr>';
        $('.director_comments_table').append(tdata); 
    });
    $('.director_comments_table').on('click', '.remove-row', function () {  
      $(this).parent().parent().remove();
    });   

    $('.add-row-budget').click(function(e){
      e.preventDefault();
      var tdata = '<tr><td><input type="text" name="comment_by_fad_budget[]" id="comment_by_fad_budget" class="form-control by-fad-budget-field toresolved" @if($user_role_id!=3) readonly @endif></td>';
      tdata += '<td><input type="hidden" name="by_fad_budget_is_resolved[]" id="by_fad_budget_is_resolved" value="0"></td>';
      tdata += '<td><button type="button" data-toggle="tooltip" data-placement="auto" title="Delete Comment" @if($user_role_id==3) class="remove-row btn btn-danger btn-sm" @else class="d-none" @endif><i class="fa-solid fa-xmark"></i></button></td></tr>';
      $('.fad_budget_comments_table').append(tdata); 
    });
    $('.fad_budget_comments_table').on('click', '.remove-row', function () {  
      $(this).parent().parent().remove();
    });
  {{-- comment end    --}} 

  {{-- forward comment start --}}  
    $('#forward_comment_modal').on('hide.bs.modal', function () {
      var msg = "";
      var notif_msg = "";
    }) 

    function init_forward_comment(division_id, year){
      var request = $.ajax({
        method: "GET",
        url: "{{ route('division_proposals.show') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'division_id' : division_id,
          'year' : year,
          'forward' : 1,
        }
      });
      return request;
    }

    $('.btn_forward_comment').on('click', function(){ 
      var msg = "";
      var notif_msg = "";      
      division_id = $(this).data('division-id')
      year = $(this).data('year')
      $(".modal-body #forward_comment_division_id").val(division_id);
      $(".modal-body #forward_comment_year").val(year);
      var request = init_forward_comment(division_id, year);
      request.then(function(data) {
        if(data['status'] == 1){  
          var division_acro = data['budget_proposal']['division_acronym'];       
          var division_id = data['budget_proposal']['division_id'];       
          document.getElementById("forward_comment_division_acronym").innerHTML = division_acro;
          $(".modal-body #forward_comment_division_id_to").val(division_id);
        }           
      })
      $('#forward_comment_modal').modal('toggle')            
    })

    $('.forward_comment').on('click', function(e){  
      e.prevenDefault;  
      $.ajax({
        method: "POST",
        url: "{{ route('division_proposals.postAction') }}",
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
            window.location=window.location;
       
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

    function init_forward(division_id, year){
      var request = $.ajax({
        method: "GET",
        url: "{{ route('division_proposals.show') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'division_id' : division_id,
          'year' : year,
          'forward' : 1,
        }
      });
      return request;
    }

    $('.btn_forward').on('click', function(){
      var msg = "";
      var notif_msg = "";
      division_id = $(this).data('division-id');
      year = $(this).data('year');
      $(".modal-body #forward_division_id").val(division_id);
      $(".modal-body #forward_year").val(year);
      var user_role_id = $(".modal-body #forward_user_role_id").val();      
      var request = init_forward(division_id, year);
      request.then(function(data) {
        if(data['status'] == 1){   
          var division_acro = data['budget_proposal']['division_acronym'];        
          var division_id = data['budget_proposal']['division_id'];        
          var active_status_id = data['budget_proposal']['status_id'];       
          if(user_role_id == 3){            
            if(active_status_id == 7){
              notif_msg = "FAD-Budget forwarded " + division_acro + "'s budget proposal to BPAC Chair.";
              msg = "Are you sure you want to forward  " + division_acro + "'s budget proposal to BPAC Chair?";
              $(".modal-body #forward_division_id_to").val('9');
              $(".modal-body #forward_user_role_id_to").val('8');
              $(".modal-body #forward_status_id").val('8');
            }
            else if(active_status_id == 14){
              notif_msg = "FAD-Budget forwarded " + division_acro + "'s budget proposal to monthly cash program (NEP).";
              msg = "Are you sure you want to forward  " + division_acro + "'s budget proposal to monthly cash program (NEP)?";
              $(".modal-body #forward_user_role_id_to").val('7');
              $(".modal-body #forward_status_id").val('15');
              $(".modal-body #forward_division_id_to").val(division_id);
            }       
            document.getElementById("forward_msg_alert").innerHTML = msg; 
            $(".modal-body #forward_notif_message").val(notif_msg);
          }       
          {{-- else if(user_role_id == 8){
            notif_msg = "FAD Director forwarded " + division_acro + "'s budget proposal to BPAC Chair.";                  
          }  --}}
          else if(user_role_id == 9){
            notif_msg = "BPAC Chair forwarded " + division_acro + "'s budget proposal to Executive Director.";                  
          }
          else if(user_role_id == 10){
            notif_msg = "Executive Director has approved " + division_acro + "'s budget proposal.";                  
          }          
          document.getElementById("forward_division_acronym").innerHTML = division_acro; 
          $(".modal-body #forward_notif_message").val(notif_msg); 
        }           
      })
      $('#forward_modal').modal('toggle')            
    })

    $('.forward_budget_proposal').on('click', function(e){
      e.prevenDefault;  
      $.ajax({
        method: "POST",
        url: "{{ route('division_proposals.postAction') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'message' : $('#forward_notif_message').val(),
          'division_id' : $('#forward_division_id').val(),
          'year' : $('#forward_year').val(),
          'division_id_from' : $('#forward_division_id_from').val(),
          'division_id_to' : $('#forward_division_id_to').val(),
          'user_role_id_to' : $('#forward_user_role_id_to').val(),
          'status_id' : $('#forward_status_id').val(),
        },
        success:function(data) {
          console.log(data);
          if(data.success) {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Division budget proposal has been successfully forwarded.',
                showConfirmButton: false,
                timer: 1500
            })             
            $('#forward_modal').modal('toggle') 
            window.location=window.location;    
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

    function init_receive(division_id, year){
      var request = $.ajax({
        method: "GET",
        url: "{{ route('division_proposals.show') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'division_id' : division_id,
          'year' : year,
          'receive' : 1,
        }
      });
      return request;
    }

    $('.btn_receive').on('click', function(){ 
      var msg = "";
      var notif_msg = "";      
      division_id = $(this).data('division-id')
      year = $(this).data('year')
      $(".modal-body #receive_division_id").val(division_id);
      $(".modal-body #receive_year").val(year);
      var user_role_id = $(".modal-body #receive_user_role_id").val();
      var request = init_receive(division_id, year);
      request.then(function(data) {
        if(data['status'] == 1){  
          var division_acro = data['budget_proposal']['division_acronym'];         
          var division_id = data['budget_proposal']['division_id'];         
          document.getElementById("receive_division_acronym").innerHTML = division_acro;
          if(user_role_id == 3){
            notif_msg = "FAD-Budget has received " + division_acro + "'s budget proposal."; 
          }        
          {{-- else if(user_role_id == 8){
            notif_msg = "FAD Director has received " + division_acro + "'s budget proposal.";                  
          }  --}}
          else if(user_role_id == 9){
            notif_msg = "BPAC Chair has received " + division_acro + "'s budget proposal.";                  
          }
          else if(user_role_id == 10){
            notif_msg = "Executive Director has received " + division_acro + "'s budget proposal.";                  
          }           
          $(".modal-body #receive_notif_message").val(notif_msg);   
          $(".modal-body #receive_division_id_to").val(division_id); 
        }           
      })
      $('#receive_modal').modal('toggle')            
    })

    $('.receive_budget_proposal').on('click', function(e){ 
      e.prevenDefault;  
      $.ajax({
        method: "POST",
        url: "{{ route('division_proposals.postAction') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'message' : $('#receive_notif_message').val(),
          'division_id' : $('#receive_division_id').val(),
          'year' : $('#receive_year').val(),
          'division_id_from' : $('#receive_division_id_from').val(),
          'division_id_to' : $('#receive_division_id_to').val(),
          'user_role_id_to' : $('#receive_user_role_id_to').val(),
          'status_id' : $('#receive_status_id').val(),
        },
        success:function(data) {
          console.log(data);
          if(data.success) {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Division budget proposal has been successfully received.',
                showConfirmButton: false,
                timer: 1500
            })             
            $('#receive_modal').modal('toggle')
            window.location=window.location;         
          }
        },
      });
    })
  {{-- receive end    --}}

  {{-- expenditure specific dropdown --}}
    $('#object_specific_id').on('select2:opening', function(e){
      if($('#object_expenditure_id').val() == '' || $('#object_expenditure_id').val() == null){
        display_notification_content('Please select object expenditure first!')
        return false;
      }
    })
    function view_object(object_expenditure, object_specific){
      $('#object_specific_id > option:not(:first-child):not(:nth-child(1))')
        .remove()
    
      var request_object_specific = view_specific_by_expenditure(object_expenditure);
      request_object_specific.then(function (data) {
        jQuery.each(data['object_specifics'], function() {
          $('#object_specific_id').append('<option value="'+this.id+'">'+this.object_specific+'</option>')
        })      
        $('#object_expenditure_id').val(object_expenditure).change();
        $('#object_specific_id').val(object_specific).change();
      })
    }

    function view_specific_by_expenditure(object_expenditure_id){
      var request = $.ajax({
        method: "GET",
        url: "{{ route('global.show_object_specific_by_object_expenditure') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'object_expenditure_id' : object_expenditure_id
        }
      });
      return request;
    }

    $('#object_expenditure_id').on('select2:select', function(e){      
      $('#object_specific_id')
        .val('')
        .change()
      $('#object_specific_id > option:not(:first-child):not(:nth-child(1))')
        .remove()
        object_expenditure_id = $('#object_expenditure_id').val();
        
      var request = view_specific_by_expenditure(object_expenditure_id);
      request.then(function(data) {
        jQuery.each(data['object_specifics'], function() {
          $('#object_specific_id').append('<option value="'+this.id+'">'+this.object_specific+'</option>')
        })
        object_expenditure_id = '';
      })
    })
  {{-- expenditure specific dropdown end--}}

  {{-- activity subactivity dropdown --}}
    {{-- error checking for null values in filtering --}}
    $('#subactivity_id').on('select2:opening', function(e){
      if($('#activity_id').val() == '' || $('#activity_id').val() == null){
        display_notification_content('Please select activity first!')
        return false;
      }
    })
    function view_activity_subactivity(activity, subactivity){
      $('#subactivity_id > option:not(:first-child):not(:nth-child(1))')
        .remove()
    
      var request_subactivity = view_subactivity_by_activity(activity);
      request_subactivity.then(function (data) {
        jQuery.each(data['subactivities'], function() {
          $('#subactivity_id').append('<option value="'+this.id+'">'+this.subactivity+'</option>')
        })      
        $('#activity_id').val(activity).change();
        $('#subactivity_id').val(subactivity).change();
      })
    }

    function view_subactivity_by_activity(activity_id){
      var request = $.ajax({
        method: "GET",
        url: "{{ route('global.show_subactivity_by_activity') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'activity_id' : activity_id
        }
      });
      return request;
    }

    $('#activity_id').on('select2:select', function(e){
      $('#subactivity_id')
        .val('')
        .change()
      $('#subactivity_id > option:not(:first-child):not(:nth-child(1))')
        .remove()
        activity_id = $('#activity_id').val();
        
      var request = view_subactivity_by_activity(activity_id);
      request.then(function(data) {
        jQuery.each(data['subactivities'], function() {
          $('#subactivity_id').append('<option value="'+this.id+'">'+this.subactivity+'</option>')
        })
        activity_id = '';
      })
    })
  {{-- activity subactivity dropdown end--}}
{{-- END --}}