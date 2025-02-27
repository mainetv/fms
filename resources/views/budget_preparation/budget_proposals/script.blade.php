
{{-- START --}}
  {{-- modal start --}}
    $('#bp_modal').on('hide.bs.modal', function(){
      init_view_bp();
      clear_attributes();
      clearFields      
    });    

    $('#bp_modal').on('shown.bs.modal', function () {
      $('#pap_id').focus();
    }) 
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
    
    $('.btn_add').on('click', function(e){ 
      e.prevenDefault;  
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

    $('.btn_edit').on('click', function(e){
      $('#bp_modal_header').html("Edit Budget Proposal Item");        
      init_edit_budget_proposal();
      id = $(this).data('id')
      $(".modal-body #id").val(id);
      $.getJSON( '{{ url('budget_preparation/budget_proposal/division/show') }}/'+id, function( data ) {
      })
      .done(function(data) {    
        $('#pap_id').val(data['budget_proposals']['pap_id']).change()
        view_subactivity_by_activity_id(
          data['budget_proposals']['activity_id'],
          data['budget_proposals']['subactivity_id'],
        )
        view_object_expenditure_by_expense_account_id(
          data['budget_proposals']['expense_account_id'],
          data['budget_proposals']['object_expenditure_id'],
        )
        view_object_specific_by_object_expenditure_id(
          data['budget_proposals']['object_expenditure_id'],
          data['budget_proposals']['object_specific_id'],
        )
        $('#pooled_at_division_id').val(data['budget_proposals']['pooled_at_division_id']).change()
        $('#fy1_amount').val(data['budget_proposals']['fy1_amount']).change()
        $('#fy2_amount').val(data['budget_proposals']['fy2_amount']).change()
        $('#fy3_amount').val(data['budget_proposals']['fy3_amount']).change()
      })
      .fail(function() {
      });        
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
    $('.btn_comment').on('click', function(e){  
      e.preventDefault();
      var id = $(this).data('id');      
      var year = $(this).data('year');      
      var division_id = $(this).data('division-id');      
      var parent_division_id = $(this).data('parent-division-id');      
      var active_status_id = $(this).data('active-status-id');      
      var user_role_id = $('#comment_by_user_role_id').val();   
      $('#comment_division_id').val(division_id);             
      $('#comment_year').val(year);   
      $('#budget_proposal_id').val(id);   
      $('#comment_active_status_id').val(active_status_id); 
      {{-- alert(active_status_id);
      alert(user_role_id); --}}
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
      if(parent_division_id==0){        
        document.getElementById("is_comment_by").innerHTML = "Division Director";
      } 
      else{
        document.getElementById("is_comment_by").innerHTML = "Section Head";
      }  
      $.getJSON( '{{ url('budget_preparation/budget_proposal/division/show_comment') }}/'+id, function( data ) {
      })
      .done(function(data) {    
        var i = 0;
        var rowCount = (data['rowCount'])  
        while (i < rowCount) {  
          comment_by = (data.comment[i].comment_by);
          comment = (data.comment[i].comment);  
          comment_id = (data.comment[i].id);
          is_resolved = (data.comment[i].is_resolved);  
          if(comment_by=='Division Director' || comment_by=='Section Head'){  
            if(is_resolved==1){
              var tdata = '<tr><td><input type="text" name="comment_by_division_director[]" class="form-control by-director-field" style="background-color: #85cd85"  value="' + comment + '" disabled></td>';
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
          if(comment_by=='FAD-Budget'){
            if(is_resolved==1){
              var tdata = '<tr><td><input type="text" name="comment_by_fad_budget[]" class="form-control by-budget-field" style="background-color: #85cd85"  value="' + comment + '" disabled></td>';
              tdata += '<td><input type="hidden" name="by_budget_is_resolved[]" id="by_budget_is_resolved" value="' + is_resolved + '"></td>';
              $(".fad_budget_comments_table").append(tdata);
              i++;
            } 
            else{
              var tdata = '<tr><td><input type="text" name="comment_by_fad_budget[]" class="form-control by-budget-field" style="background-color: #e49c9c" value="' + comment + '" @if($user_role_id!=3) readonly @endif></td>';
              tdata += '<td><input type="hidden" name="by_budget_is_resolved[]" id="by_budget_is_resolved" value="' + is_resolved + '"></td>';
              tdata += '<td><input type="hidden" name="comment_id[]" id="comment_id" value="' + comment_id + '" class="form-control"></td>'; 
              tdata += '<td><button type="button" data-toggle="tooltip" data-id="' + comment_id + '" data-placement="auto" title="Delete Comment" @if(($user_role_id==3 && $active_status_id==7)) class="delete-row btn btn-danger btn-sm" @else class="d-none" @endif><i class="fa-solid fa-xmark"></i></button></td></tr>';
              $(".fad_budget_comments_table").append(tdata);
              i++;
            }
          }  
          if(comment_by=='BPAC'){   
            if(is_resolved==1){
              var tdata = '<tr><td><input type="text" name="comment_by_bpac[]" class="form-control by-bpac-field" style="background-color: #85cd85"  value="' + comment + '" disabled></td>';
              tdata += '<td><input type="hidden" name="by_bpac_is_resolved[]" id="by_bpac_is_resolved" value="' + is_resolved + '"></td>';
              $(".bpac_comments_table").append(tdata);
              i++;
            } 
            else{              
              var tdata = '<tr><td><input type="text" name="comment_by_bpac[]" class="form-control by-bpac-field" style="background-color: #e49c9c" value="' + comment + '" @if($user_role_id!=9) readonly @endif></td>';
              tdata += '<td><input type="hidden" name="by_bpac_is_resolved[]" id="by_bpac_is_resolved" value="' + is_resolved + '"></td>';
              tdata += '<td><input type="hidden" name="comment_id[]" id="comment_id" value="' + comment_id + '" class="form-control"></td>'; 
              tdata += '<td><button type="button" data-toggle="tooltip" data-id="' + comment_id + '" data-placement="auto" title="Delete Comment" @if(($user_role_id==9 && $active_status_id==11)) class="delete-row btn btn-danger btn-sm" @else class="d-none" @endif><i class="fa-solid fa-xmark"></i></button></td></tr>';
              $(".bpac_comments_table").append(tdata);
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
            method: "PATCH",   
            dataType: 'json',         
            url: "{{ route('division_proposals.update') }}",
            data:  $('#comment_form').serialize(),
            success:function(data) {
              console.log(data);
              if(data.errors) {    
                if(data.errors.comment_by_division_director){
                  $('#comment_by_division_director').addClass('is-invalid');
                  $('#director-comment-error').html(data.errors.comment_by_division_director[0]);
                }     
                if(data.errors.comment_by_fad_budget){
                  $('#comment_by_fad_budget').addClass('is-invalid');
                  $('#budget-comment-error').html(data.errors.comment_by_fad_budget[0]);
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
    
    $('.add-row-director').click(function(e){
      e.preventDefault(); 
      $.ajax({
        method: "POST",
        url: "{{ route('division_proposals.postAction') }}",
        data:  $('#comment_form').serialize(),
        success:function(data) {
          console.log(data);
          var comment_id = data.comment_id; 
          if(data.success) {  
            var i = 0;     
            while(i < 1){              
              var tdata = '<tr><td><input type="text" name="comment_by_division_director[]" id="comment_by_division_director" class="form-control by-director-field is-invalid toresolved" @if(($user_role_id!=6) && ($user_role_id!=11)) readonly @endif></td>';
              tdata += '<td><input type="hidden" name="by_director_is_resolved[]" id="by_director_is_resolved" value="0"></td>';
              tdata += '<td><input type="hidden" name="comment_id[]" id="comment_id" value="' + comment_id + '" class="form-control"></td>';
              tdata += '<td><button type="button" data-toggle="tooltip" data-id="' + comment_id + '" data-placement="auto" title="Delete Comment" @if(($user_role_id==6 || $user_role_id==11) && $active_status_id==3) class="delete-row btn btn-danger btn-sm" @else class="d-none" @endif><i class="fa-solid fa-xmark"></i></button></td></tr>';             
              $('.director_comments_table').append(tdata); 
              var rowCount = $('.director_comments_table tr').length;
              $('#director_comment_num_rows').val(rowCount);               
              i++;                   
            }       
          }   
        },
      });
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
            url: "{{ route('division_proposals.delete') }}",
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
              {{-- window.location.reload();    --}}
              {{-- $(this).parent().parent().remove(); --}}
              $(obj).closest("tr").remove();
            }             
        })    
        }       
      })
      {{-- $(this).parent().parent().remove(); --}}
    });  

    $('.add-row-budget').click(function(e){
      e.preventDefault(); 
      $.ajax({
        method: "POST",
        url: "{{ route('division_proposals.postAction') }}",
        data:  $('#comment_form').serialize(),
        success:function(data) {
          console.log(data);
          var comment_id = data.comment_id; 
          if(data.success) {  
            var i = 0;     
            while(i < 1){              
              var tdata = '<tr><td><input type="text" name="comment_by_fad_budget[]" id="comment_by_fad_budget" class="form-control by-budget-field is-invalid toresolved" @if($user_role_id!=3) readonly @endif></td>';
              tdata += '<input type="hidden" name="by_budget_is_resolved[]" id="by_budget_is_resolved" value="0"></td>';
              tdata += '<td><input type="hidden" name="comment_id[]" id="comment_id" value="' + comment_id + '" class="form-control"></td>';
              tdata += '<td><button type="button" data-toggle="tooltip" data-id="' + comment_id + '" data-placement="auto" title="Delete Comment" @if($user_role_id==3) class="delete-row btn btn-danger btn-sm" @else class="d-none" @endif><i class="fa-solid fa-xmark"></i></button></td></tr>';  
              $('.fad_budget_comments_table').append(tdata); 
              var rowCount = $('.fad_budget_comments_table tr').length;
              $('#budget_comment_num_rows').val(rowCount);               
              i++;                   
            }       
          }   
        },
      });
    })
    $('.fad_budget_comments_table').on('click', '.delete-row', function () {  
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
            url: "{{ route('division_proposals.delete') }}",
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

    $('.add-row-bpac').click(function(e){
      e.preventDefault(); 
      $.ajax({
        method: "POST",
        url: "{{ route('division_proposals.postAction') }}",
        data:  $('#comment_form').serialize(),
        success:function(data) {
          console.log(data);
          var comment_id = data.comment_id; 
          if(data.success) {  
            var i = 0;     
            while(i < 1){              
              var tdata = '<tr><td><input type="text" name="comment_by_bpac[]" id="comment_by_bpac" class="form-control by-bpac-field is-invalid toresolved" @if($user_role_id!=9) readonly @endif></td>';
              tdata += '<input type="hidden" name="by_bpac_is_resolved[]" id="by_bpac_is_resolved" value="0"></td>';
              tdata += '<td><input type="hidden" name="comment_id[]" id="comment_id" value="' + comment_id + '" class="form-control"></td>';
              tdata += '<td><button type="button" data-toggle="tooltip" data-id="' + comment_id + '" data-placement="auto" title="Delete Comment" @if($user_role_id==9) class="delete-row btn btn-danger btn-sm" @else class="d-none" @endif><i class="fa-solid fa-xmark"></i></button></td></tr>';  
              $('.bpac_comments_table').append(tdata); 
              var rowCount = $('.bpac_comments_table tr').length;
              $('#bpac_comment_num_rows').val(rowCount); 
              i++;                   
            }       
          }   
        },
      });
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
            url: "{{ route('division_proposals.delete') }}",
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
  {{-- comment end    --}} 

  {{-- forward comment start --}}  
    $('#forward_comment_modal').on('hide.bs.modal', function () {
      var msg = "";
      var notif_msg = "";
    }) 

    $('.btn_forward_comment').on('click', function(){      
      var msg = "";
      var notif_msg = "";      
      division_id = $(this).data('division-id');      
      division_acronym = $(this).data('division-acronym');
      year = $(this).data('year');
      $(".modal-body #forward_comment_division_id").val(division_id);
      $(".modal-body #forward_comment_year").val(year);
      var user_role_id = $(".modal-body #forward_comment_user_role_id").val(); 
      {{-- alert(user_role_id); --}}
      if(user_role_id == 6 || user_role_id==11){
        alert_msg = "Are you sure you want to forward the comment/s to your division budget controller?";  
        if(user_role_id==11){
          notif_msg = "Section head forwarded the budget proposal with comment/s for your revision";
        }
        else if(user_role_id==6){
          notif_msg = "Division director forwarded the budget proposal with comment/s for your revision";
        }
        $(".modal-body #forward_comment_status_id").val('4');
      }
      else if(user_role_id == 3){
        alert_msg = "Are you sure you want to forward the comment/s to " + division_acronym + "'s budget controller?";  
        notif_msg = "FAD-Budget forwarded the budget proposal with comment/s for " + division_acronym + "'s budget controller revision.";
        $(".modal-body #forward_comment_status_id").val('8');
      }
      else if(user_role_id == 9){
        alert_msg = "Are you sure you want to forward the comment/s to " + division_acronym + "'s budget controller?";  
        notif_msg = "BPAC Chair forwarded the budget proposal with comment/s for " + division_acronym + "'s budget controller revision.";
        $(".modal-body #forward_comment_status_id").val('12');
      }
      $(".modal-body #forward_comment_notif_msg").val(notif_msg);
      document.getElementById("forward_comment_alert_msg").innerHTML = alert_msg;
      $('#forward_comment_modal').modal('toggle')            
    })

    $('.forward_comment').on('click', function(e){  
      e.prevenDefault;  
      $.ajax({
        method: "POST",
        url: "{{ route('division_proposals.postAction') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'message' : $('#forward_comment_notif_msg').val(),
          'division_id' : $('#forward_comment_division_id').val(),
          'year' : $('#forward_comment_year').val(),
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
      clearFields      
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
      {{-- alert(active_status_id);
      alert(user_role_id); --}}
      if(user_role_id == 7){ 
        if(active_status_id==1 || active_status_id==5 || active_status_id==9 || active_status_id==12){
          if(user_parent_division_id!=0 && division_id!=3){        
            alert_msg = "Are you sure you want to forward the budget proposal to your section head?";
            notif_msg = "Section budget controller forwarded the budget proposal for your approval or comment/s";
            $(".modal-body #forward_status_id").val('2');
          }
          else if(division_id==3){        
            alert_msg = "Are you sure you want to forward the budget proposal to FAD-Budget?";
            notif_msg = division_acronym + "budget controller forwarded their division's budget proposal to FAD-Budget for approval or comment/s.";
            $(".modal-body #forward_status_id").val('6');
          }
          else{        
            alert_msg = "Are you sure you want to forward the budget proposal to your division director?";
            notif_msg = "Division budget controller forwarded the budget proposal for your approval or comment/s";
            $(".modal-body #forward_status_id").val('2');
          }          
        }
        else if(active_status_id == 3){
          notif_msg = division_acronym + " section head forwarded their sections's budget proposal to FAD-Budget for approval or comment/s."; 
          alert_msg = "Are you sure you want to forward your sections's budget proposal to FAD-Budget?";     
          $(".modal-body #forward_status_id").val('8');      
        }        
      }
      else if(user_role_id == 6 || user_role_id == 11){
        if(active_status_id == 3){
          if(user_role_id == 6){
            notif_msg = division_acronym + " division director forwarded their division's budget proposal to FAD-Budget for approval or comment/s."; 
          }
          else if(user_role_id == 11){
            notif_msg = division_acronym + " section head forwarded their sections's budget proposal to FAD-Budget for approval or comment/s."; 
          }
          alert_msg = "Are you sure you want to forward your sections's budget proposal to FAD-Budget?";     
          $(".modal-body #forward_status_id").val('6');          
        }
      } 
      else if(user_role_id == 3){ 
        if(active_status_id == 7 || division_id==3){
          alert_msg = "Are you sure you want to forward " + division_acronym + "'s budget proposal to BPAC?";
          notif_msg = "FAD-Budget forwarded " + division_acronym + "'s budget proposal to BPAC.";    
          $(".modal-body #forward_status_id").val('10');            
        }
        else if(active_status_id == 15){
          alert_msg = "Are you sure you want to forward " + division_acronym + "'s budget proposal to allotment status?";
          notif_msg = "FAD-Budget forwarded " + division_acronym + "'s budget proposal to llotment status.";  
          $(".modal-body #forward_status_id").val('21');        
        }       
      }     
      else if(user_role_id == 9){
        if(active_status_id == 11){
          alert_msg = "Are you sure you want to approve " + division_acronym + "'s budget proposal?";   
          notif_msg = "BPAC Chair approved " + division_acronym + "'s budget proposal.";   
          $(".modal-body #forward_status_id").val('14');     
        }               
      }
      else if(user_role_id == 10){
        alert_msg = "Are you sure you want to approve " + division_acronym + "'s budget proposal?";
        notif_msg = "Executive Director has approved " + division_acronym + "'s budget proposal.";  
        $(".modal-body #forward_status_id").val('14');                     
      }       
      document.getElementById("forward_alert_msg").innerHTML = alert_msg; 
      $(".modal-body #forward_notif_msg").val(notif_msg);   
      $('#forward_modal').modal('toggle')            
    })

    $('.forward_budget_proposal').on('click', function(e){
      e.prevenDefault;  
      $.ajax({
        method: "POST",
        url: "{{ route('division_proposals.postAction') }}",
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
                title: 'Division budget proposal has been successfully forwarded.',
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
        else{
          alert_msg = "Receive your section's budget proposal?";
          notif_msg = "Section head has received the budget proposal.";
          $(".modal-body #receive_status_id").val('3');
        } 
      } 
      else if(user_role_id == 6 || user_role_id == 11){
        if(active_status_id == 2){ 
          if(user_role_id == 6){
            alert_msg = "Receive your division's budget proposal?";
            notif_msg = "Division director has received the budget proposal.";
          }
          else if(user_role_id == 11){
            alert_msg = "Receive your section's budget proposal?";
            notif_msg = "Section head has received the budget proposal.";
          }
          $(".modal-body #receive_status_id").val('3');
        }     
      } 
      else if(user_role_id == 3){
        if(active_status_id == 6){ 
          alert_msg = "Receive " + division_acronym + "'s budget proposal?";
          notif_msg = "FAD-Budget has received " + division_acronym + "'s budget proposal."; 
          $(".modal-body #receive_status_id").val('7');
        }   
        else if(active_status_id == 14){ 
          alert_msg = "Receive " + division_acronym + "'s budget proposal?";
          notif_msg = "FAD-Budget has received " + division_acronym + "'s budget proposal."; 
          $(".modal-body #receive_status_id").val('15');
        }
      }
      else if(user_role_id == 9){
        alert_msg = "Receive " + division_acronym + "'s budget proposal?";
        notif_msg = "BPAC Chair has received " + division_acronym + "'s budget proposal.";    
        $(".modal-body #receive_status_id").val('11');              
      }
      {{-- else if(user_role_id == 10){
        alert_msg = "Receive " + division_acronym + "'s budget proposal?";
        notif_msg = "Executive Director has received " + division_acronym + "'s budget proposal.";         
        $(".modal-body #receive_status_id").val('13');           
      }         --}}
      document.getElementById("receive_alert_msg").innerHTML = alert_msg;
      $(".modal-body #receive_notif_msg").val(notif_msg);   
      $('#receive_modal').modal('toggle')            
    })

    $('.receive_budget_proposal').on('click', function(e){ 
      e.prevenDefault;  
      $.ajax({
        method: "POST",
        url: "{{ route('division_proposals.postAction') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'message' : $('#receive_notif_msg').val(),
          'division_id' : $('#receive_division_id').val(),
          'year' : $('#receive_year').val(),
          'status_id' : $('#receive_status_id').val(),
          'user_role_id' : $('#receive_user_role_id').val(),

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
            window.location.reload();
          }
        },
      });
    })
  {{-- receive end    --}}

  {{-- reverse start --}}  
    $('#reverse_modal').on('hide.bs.modal', function(){
      var msg = "";
      var notif_msg = "";
      clear_attributes();
      clearFields      
    }); 

    $('.btn_reverse').on('click', function(){      
      var msg = "";
      var notif_msg = "";
      division_id = $(this).data('division-id');
      year = $(this).data('year');
      division_acronym = $(this).data('division-acronym');
      active_status_id = $(this).data('active-status-id');
      user_parent_division_id = $(this).data('parent-division-id')     
      $(".modal-body #reverse_division_id").val(division_id);
      $(".modal-body #reverse_year").val(year);            
      var user_role_id = $(".modal-body #reverse_user_role_id").val();   
      {{-- alert(active_status_id); --}}
      if(user_role_id == 3){ 
        if(active_status_id==10){         
            alert_msg = "Are you sure you want to reverse the forwarding of " + division_acronym + "'s budget proposal from BPAC?";
            notif_msg = "FAD-Budget reverse the forwarding of " + division_acronym + "'s budget proposal from BPAC.";
          }
          $(".modal-body #reverse_status_id").val('7');                
      }  
      document.getElementById("reverse_alert_msg").innerHTML = alert_msg; 
      $(".modal-body #reverse_notif_msg").val(notif_msg);   
      $('#reverse_modal').modal('toggle')            
    })

    $('.reverse_budget_proposal').on('click', function(e){
      e.prevenDefault;  
      $.ajax({
        method: "POST",
        url: "{{ route('division_proposals.postAction') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'message' : $('#reverse_notif_msg').val(),
          'division_id' : $('#reverse_division_id').val(),
          'year' : $('#reverse_year').val(),          
          'status_id' : $('#reverse_status_id').val(),
          'user_role_id' : $('#reverse_user_role_id').val(),
        },
        success:function(data) {
          console.log(data);
          if(data.success) {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Division budget proposal has been successfully reversed.',
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

  {{-- send email start --}}  
    $('.btn_send_email').on('click', function(){ 
      var msg = "";
      var notif_msg = "";     
      year = $(this).data('year');               
      $('#send_email_modal').modal('toggle')            
    })

    $('.send_email_budget_proposal').on('click', function(e){
      e.prevenDefault;  
      $.ajax({
        method: "POST",
        url: "{{ route('division_proposals.postAction') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'message' : $('#send_notif_msg').val(),
          'year' : year,          
          'status_id' : $('#send_status_id').val(),
          'user_role_id' : $('#send_user_role_id').val(),
        },
        success:function(data) {
          console.log(data);
          if(data.success) {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Email was successfully sent to BPAC Chair.',
                showConfirmButton: false,
                timer: 1500
            })             
            $('#send_email_modal').modal('toggle') 
            window.location.reload();    
          }
        },
      });
    })
  {{-- send email end    --}}  
{{-- END --}}