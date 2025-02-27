
{{-- START --}}
  {{-- modal start --}}
    $('#allotment_modal').on('hide.bs.modal', function(){
      init_view_allotment();
      clear_attributes();
      clearFields      
    });    

    $('#allotment_modal').on('show.bs.modal', function () {
      $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    })  
    
    $('#allotment_modal').on('shown.bs.modal', function () {
      $('#pap_id').focus();
    })  

    $("#adjustment_modal").on("hide.bs.modal", function(){ 
      $('.edit_adjustment.save-buttons')
        .removeClass('d-inline')
        .addClass('d-none')
        .attr('disabled', true);

      $('.hide_adjustment_container')
        .removeClass('d-inline')
        .addClass('d-none')
        .attr('disabled', true);

      window.location.reload();          
    });   

    $("#adjustment_modal").on("hidden.bs.modal", function(){ 
      $('#adjustment_container').collapse('hide');  
      $('#allotment_adjustment_table').dataTable().fnDestroy();
      $('#adjustment_table').dataTable().fnDestroy();
    });      

    
    $(".select2bs4").select2({
      theme: 'bootstrap4',
      dropdownParent: $('#allotment_modal .modal-content')
    });
    
    {{-- $("#allotment_fund_id").select2({
      dropdownParent: $('#allotment_modal .modal-content')
    }); --}}
  {{-- modal end --}}

  {{-- view start --}}   
    function init_view_allotment(){
      $('.allotment-field')
        .val('')
        .attr('disabled', true);

      $('.save-buttons')
        .removeClass('d-inline')
        .addClass('d-none')
        .attr('disabled', true);
    }

    $('.btn_view').on('click', function(e){
      $('#allotment_modal_header').html("View Allotment");        
      init_edit_allotment();
      id = $(this).data('id')
      $(".modal-body #id").val(id);
      $.getJSON( '{{ url('programming_allocation/allotment/show') }}/'+id, function( data ) {
      })
      .done(function(data) {    
        $('#allotment_fund_id').val(data['allotment']['allotment_fund_id']).change()
        $('#pap_id').val(data['allotment']['pap_id']).change()        
        view_subactivity_by_activity_id(
          data['allotment']['activity_id'],
          data['allotment']['subactivity_id'],
        )
        view_object_expenditure_by_expense_account_id(
          data['allotment']['expense_account_id'],
          data['allotment']['object_expenditure_id'],
        )
        view_object_specific_by_object_expenditure_id(
          data['allotment']['object_expenditure_id'],
          data['allotment']['object_specific_id'],
        )
        $('#pooled_at_division_id').val(data['allotment']['pooled_at_division_id']).change()
        $('#q1_allotment').val(data['allotment']['q1_allotment']).change()
        $('#q2_allotment').val(data['allotment']['q2_allotment']).change()
        $('#q3_allotment').val(data['allotment']['q3_allotment']).change()
        $('#q4_allotment').val(data['allotment']['q4_allotment']).change()        
        $('#q1_obligation').val(data['allotment']['q1_obligation']).change()        
        $('#q2_obligation').val(data['allotment']['q2_obligation']).change()        
        $('#q3_obligation').val(data['allotment']['q3_obligation']).change()        
        $('#q4_obligation').val(data['allotment']['q4_obligation']).change()  
      })
      .fail(function() {
      });        
      $('#allotment_modal').modal('toggle')            
    })
  {{-- view end --}}

  {{-- add start --}}
    function init_add_allotment(){
      $('.allotment-field')
        .attr('disabled', false);
        
      $('.add_allotment.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);   
    }
     
    $('.btn_add').on('click', function(e){      
      init_add_allotment();   
      var division_id = $(this).data('division-id');
      var year = $(this).data('year');
      var rs_type_id = $(this).data('rstype-id');
      $(".modal-body #division_id").val(division_id);
      $(".modal-body #year").val(year);
      $(".modal-body #rs_type_id").val(rs_type_id);
      $('#allotment_modal_header').html("Add Allotment");        
      $('#allotment_modal').modal('toggle')       
    })

    $('.add_allotment').on('click', function(e){     
      e.prevenDefault;  
      clear_attributes();      
      $.ajax({
        method: "POST",
        url: "{{ route('allotment.store') }}",
        data: {
          '_token': '{{ csrf_token() }}',      
          'add_allotment' : 1,
          'division_id' : $('#division_id').val(),
          'year' : $('#year').val(),
          'rs_type_id' : $('#rs_type_id').val(),
          'allotment_fund_id' : $('#allotment_fund_id').val(),
          'pap_id' : $('#pap_id').val(),
          'activity_id' : $('#activity_id').val(),
          'subactivity_id' : $('#subactivity_id').val(),
          'expense_account_id' : $('#expense_account_id').val(),
          'object_expenditure_id' : $('#object_expenditure_id').val(),
          'object_specific_id' : $('#object_specific_id').val(),
          'pooled_at_division_id' : $('#pooled_at_division_id').val(),
          'q1_allotment' : $('#q1_allotment').val(),
          'q2_allotment' : $('#q2_allotment').val(),
          'q3_allotment' : $('#q3_allotment').val(),
          'q4_allotment' : $('#q4_allotment').val(),
        },
        success:function(data) {
          console.log(data);
          if(data.errors) {    
            if(data.errors.allotment_fund_id){
              $('#allotment_fund_id').addClass('is-invalid');
              $('#fund-error').html(data.errors.allotment_fund_id[0]);
            }      
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
              title: 'Allotment has been successfully added.',
              showConfirmButton: false,
              timer: 1500
            })   
            $('#allotment_modal').modal('toggle');
            window.location.reload();        
          }
        },
      });
    })      
  {{-- add end    --}}

  {{-- edit start --}}
    function init_edit_allotment(){      
      init_view_allotment();
      $('.allotment-field')
        .attr('disabled', false);

      $('.edit_allotment.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);
    }

    $('.btn_edit').on('click', function(e){
      $('#allotment_modal_header').html("Edit Allotment");        
      init_edit_allotment();
      id = $(this).data('id')
      $(".modal-body #id").val(id);
      $.getJSON( '{{ url('programming_allocation/allotment/show') }}/'+id, function( data ) {
        $('#allotment_fund_id').val(data['allotment']['allotment_fund_id']).change()
        $('#pap_id').val(data['allotment']['pap_id']).change()
        view_subactivity_by_activity_id(
          data['allotment']['activity_id'],
          data['allotment']['subactivity_id'],
        )
        view_object_expenditure_by_expense_account_id(
          data['allotment']['expense_account_id'],
          data['allotment']['object_expenditure_id'],
        )
        view_object_specific_by_object_expenditure_id(
          data['allotment']['object_expenditure_id'],
          data['allotment']['object_specific_id'],
        )
        $('#pooled_at_division_id').val(data['allotment']['pooled_at_division_id']).change()
        $('#q1_allotment').val(data['allotment']['q1_allotment']).change()
        $('#q2_allotment').val(data['allotment']['q2_allotment']).change()
        $('#q3_allotment').val(data['allotment']['q3_allotment']).change()
        $('#q4_allotment').val(data['allotment']['q4_allotment']).change()        
        $('#total_allotment').val(data['allotment']['total_allotment']).change()        
        $('#q1_obligation').val(data['allotment']['q1_obligation']).change()        
        $('#q2_obligation').val(data['allotment']['q2_obligation']).change()        
        $('#q3_obligation').val(data['allotment']['q3_obligation']).change()        
        $('#q4_obligation').val(data['allotment']['q4_obligation']).change() 
        $('#total_obligation').val(data['allotment']['total_obligation']).change() 
      })
      .done(function(data) {                  
      })
      .fail(function() {
      });        
      $('#allotment_modal').modal('toggle')            
    })

    $('.edit_allotment').on('click', function(e){        
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
            url: "{{ route('allotment.update') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'edit_allotment' : 1,              
              'id' : $('#id').val(),
              'rs_type_id' : $('#rs_type_id').val(),
              'allotment_fund_id' : $('#allotment_fund_id').val(),
              'pap_id' : $('#pap_id').val(),
              'activity_id' : $('#activity_id').val(),
              'subactivity_id' : $('#subactivity_id').val(),
              'expense_account_id' : $('#expense_account_id').val(),
              'object_expenditure_id' : $('#object_expenditure_id').val(),
              'object_specific_id' : $('#object_specific_id').val(),
              'pooled_at_division_id' : $('#pooled_at_division_id').val(),
              'q1_allotment' : $('#q1_allotment').val(),
              'q2_allotment' : $('#q2_allotment').val(),
              'q3_allotment' : $('#q3_allotment').val(),
              'q4_allotment' : $('#q4_allotment').val(),
            },
            success:function(data) {
              console.log(data);
              if(data.errors) {     
                if(data.errors.allotment_fund_id){
                  $('#allotment_fund_id').addClass('is-invalid');
                  $('#fund-error').html(data.errors.allotment_fund_id[0]);
                }     
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
                window.location.reload();      
                Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: 'Allotment has been successfully edited.',
                  showConfirmButton: false,
                  timer: 2000
                }) 
                $('#allotment_modal').modal('toggle')                               
              }                      
            }                             
          });                                
        }       
      })            
    })    
  {{-- edit end --}}

  {{-- delete start --}}
    $('.btn_delete').on('click', function(){
      id = $(this).data('id')
      delete_allotment(id);
    })
    function delete_allotment(id){
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
            url: "{{ route('allotment.delete') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'id' : id,
              'delete_allotment' : 1,
            },
            success: function(data) {      
              Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Allotment has been successfully deleted.',
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

  {{-- table adjustment start --}}
    $('.btn_adjustment').on('click', function(e){
      id = $(this).data('id')
      $(".modal-body #allotment_id").val(id);
      $.getJSON( '{{ url('programming_allocation/allotment/show') }}/'+id, function( data ) {
        {{-- alert(data['allotment']['pap_activity']); --}}
        {{-- $('#pap_to_adjust').val(data['allotment']['pap_activity_subactivity']).change()    --}}
        let activity = data['allotment']['pap_activity'];
        let subactivity = data['allotment']['subactivity'];
        let expenseAccount = data['allotment']['expense_account'];
        let objectExpenditure = data['allotment']['object_expenditure'];

        let actSubact = '';
        let combinedValue = '';

        if (activity) {
          actSubact += activity;
        }

        if (subactivity) {
          if (actSubact) {
            actSubact += ' - ';
          }
          actSubact += subactivity;
        }

        if (expenseAccount) {
            combinedValue += expenseAccount;
        }

        if (objectExpenditure) {
            if (combinedValue) {
                combinedValue += ' - ';
            }
            combinedValue += objectExpenditure;
        }

        $('#pap_act_subact_to_adjust').val(actSubact).change();
        $('#exp_to_adjust').val(combinedValue).change();
      })

      .done(function(data) {                  
      })
      .fail(function() {
      });  

      allotment_adjustment_table = $('#allotment_adjustment_table').DataTable({
        paging : false,
        info: false,
        searching: false,
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('show_adjustments_by_allotment_id') }}",
          method: "GET",
          data : {
            '_token': '{{ csrf_token() }}',
            'allotment_id' : $('#allotment_id').val(),
            'allotment_adjustment_table' : 1,
          }      
        },
        columns: [
            {data: 'annual_allotment', name: 'annual_allotment'},
            {data: 'annual_adjustment', name: 'annual_adjustment'},
            {data: 'annual_total', name: 'annual_total'},
            {data: 'q1_allotment', name: 'q1_allotment'},
            {data: 'q1_adjustment', name: 'q1_adjustment'},
            {data: 'q1_total', name: 'q1_total'},
            {data: 'q2_allotment', name: 'q2_allotment'},
            {data: 'q2_adjustment', name: 'q2_adjustment'},
            {data: 'q2_total', name: 'q2_total'},
            {data: 'q3_allotment', name: 'q3_allotment'},
            {data: 'q3_adjustment', name: 'q3_adjustment'},
            {data: 'q3_total', name: 'q3_total'},
            {data: 'q4_allotment', name: 'q4_allotment'},
            {data: 'q4_adjustment', name: 'q4_adjustment'},
            {data: 'q4_total', name: 'q4_total'},
        ]
      });

      adjustment_table = $('#adjustment_table').DataTable({
        paging : false,
        info: false,
        searching: false,
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('show_adjustments_by_allotment_id') }}",
          method: "GET",
          data : {
            '_token': '{{ csrf_token() }}',
            'allotment_id' : $('#allotment_id').val(),
            'adjustment_table' : 1,
          }
      
        },
        columns: [
            {data: 'date', name: 'date'},
            {data: 'adjustment_type', name: 'adjustment_type'},
            {data: 'reference_no', name: 'reference_no'},
            {data: 'q1_adjustment', name: 'q1_adjustment'},
            {data: 'q2_adjustment', name: 'q2_adjustment'},
            {data: 'q3_adjustment', name: 'q3_adjustment'},
            {data: 'q4_adjustment', name: 'q4_adjustment'},
            {data: 'action', orderable: false, searchable: false} 
        ]
      }); 
      
      $('#adjustment_modal').modal('toggle');  
    })  
    
    $('.hide_adjustment_container').on('click', function(e){
      $('#adjustment_container').collapse('hide'); 

      $('.edit_adjustment.save-buttons')
        .removeClass('d-inline')
        .addClass('d-none')
        .attr('disabled', true);
    });
  {{-- table adjustment end --}}

  {{-- add adjustment start --}}  
    function init_add_adjustment(){
      $('.adjustment-field')
        .attr('disabled', false);
        
      $('.add_adjustment.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);  
        
      $('.edit_adjustment.save-buttons')
        .removeClass('d-inline')
        .addClass('d-none')
        .attr('disabled', true);

      $('.hide_adjustment_container')
        .addClass('d-inline')
        .removeClass('d-none');

      clear_attributes();
      clearFields  
    }

    $('.btn_add_adjustment').on('click', function(e){
      init_add_adjustment();         

      $('#adjustment_container').collapse('show');  
    })  

    $('.add_adjustment').on('click', function(e){     
      e.prevenDefault;  
      clear_attributes();      
      $.ajax({
        method: "POST",
        url: "{{ route('allotment.store') }}",
        data: {
          '_token': '{{ csrf_token() }}',      
          'add_adjustment' : 1,
          'allotment_id' : $('#allotment_id').val(),
          'date' : $('#adjustment_date').val(),
          'adjustment_type_id' : $('#adjustment_type_id').val(),
          'reference_no' : $('#reference_no').val(),
          'q1_adjustment' : $('#q1_adjustment').val(),
          'q2_adjustment' : $('#q2_adjustment').val(),
          'q3_adjustment' : $('#q3_adjustment').val(),
          'q4_adjustment' : $('#q4_adjustment').val(),
          'remarks' : $('#remarks').val(),
        },
        success:function(data) {
          console.log(data);
          if(data.errors) {    
            if(data.errors.date){
              $('#adjustment_date').addClass('is-invalid');
              $('#date-error').html(data.errors.date[0]);
            }  
            if(data.errors.adjustment_type_id){
              $('#adjustment_type_id').addClass('is-invalid');
              $('#adjustment-type-error').html(data.errors.adjustment_type_id[0]);
            }   
          }
          if(data.success) {
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Adjustment has been successfully added.',
              showConfirmButton: false,
              timer: 1500
            })   
            $('.add_adjustment.save-buttons')
              .removeClass('d-inline')
              .addClass('d-none')
              .attr('disabled', true); 
            $('#adjustment_container').collapse('hide');  
            $('.hide_adjustment_container')
              .removeClass('d-inline')
              .addClass('d-none');
            $('#allotment_adjustment_table').DataTable().ajax.reload();
            $('#adjustment_table').DataTable().ajax.reload();            
          }
        },
      });
    }) 
  {{-- add adjustment end --}}

  {{-- edit adjustment start --}}
    function init_edit_adjustment(){      
      $('.adjustment-field')
        .attr('disabled', false);

      $('.edit_adjustment.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);

      $('.add_adjustment.save-buttons')
        .removeClass('d-inline')
        .addClass('d-none')
        .attr('disabled', true);

      $('.hide_adjustment_container')
        .addClass('d-inline')
        .removeClass('d-none');
    }

    $('#adjustment_table').on('click', '.btn_edit_adjustment', function(e){
      init_edit_adjustment();
      id = $(this).data('id')
      $(".modal-body #adjustment_id").val(id);
      $.getJSON( '{{ url('programming_allocation/allotment/show_adjustment') }}/'+id, function( data ) {
      })
      .done(function(data) {    
        $('#adjustment_date').val(data['adjustment']['date']).change()
        $('#adjustment_type_id').val(data['adjustment']['adjustment_type_id']).change()     
        $('#reference_no').val(data['adjustment']['reference_no']).change()     
        $('#q1_adjustment').val(data['adjustment']['q1_adjustment']).change()     
        $('#q2_adjustment').val(data['adjustment']['q2_adjustment']).change()     
        $('#q3_adjustment').val(data['adjustment']['q3_adjustment']).change()     
        $('#q4_adjustment').val(data['adjustment']['q4_adjustment']).change()  
        $('#remarks').val(data['adjustment']['remarks']).change()    
      })
      .fail(function() {
      });        
      $('#adjustment_container').collapse('show');            
    })

    $('.edit_adjustment').on('click', function(e){     
      e.prevenDefault;  
      clear_attributes();      
      $.ajax({
        method: "PATCH",
        url: "{{ route('allotment.update') }}",
        data: {
          '_token': '{{ csrf_token() }}',      
          'edit_adjustment' : 1,
          'id' : $('#adjustment_id').val(),
          'date' : $('#adjustment_date').val(),
          'adjustment_type_id' : $('#adjustment_type_id').val(),
          'reference_no' : $('#reference_no').val(),
          'q1_adjustment' : $('#q1_adjustment').val(),
          'q2_adjustment' : $('#q2_adjustment').val(),
          'q3_adjustment' : $('#q3_adjustment').val(),
          'q4_adjustment' : $('#q4_adjustment').val(),
          'remarks' : $('#remarks').val(),
        },
        success:function(data) {
          console.log(data);
          if(data.errors) {    
            if(data.errors.date){
              $('#adjustment_date').addClass('is-invalid');
              $('#date-error').html(data.errors.date[0]);
            }  
            if(data.errors.adjustment_type_id){
              $('#adjustment_type_id').addClass('is-invalid');
              $('#adjustment-type-error').html(data.errors.adjustment_type_id[0]);
            }   
          }
          if(data.success) {
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Adjustment has been successfully edited.',
              showConfirmButton: false,
              timer: 1500
            })   
            $('#adjustment_container').collapse('hide');  
            $('.hide_adjustment_container')
              .removeClass('d-inline')
              .addClass('d-none');
            $('#allotment_adjustment_table').DataTable().ajax.reload();
            $('#adjustment_table').DataTable().ajax.reload();    
          }
        },
      });
    }) 
  {{-- edit adjustment end --}}

  {{-- delete adjustment start --}}
    $('#adjustment_table').on('click', '.btn_delete_adjustment', function(e){   
      id = $(this).data('id');
      delete_adjustment(id);
    })
    function delete_adjustment(id){
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
            url: "{{ route('allotment.delete') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'id' : id,
              'delete_adjustment' : 1,
            },
            success: function(data) {      
              Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Adjustment has been successfully deleted.',
              showConfirmButton: false,
              timer: 1500
              }) 
              $('#allotment_adjustment_table').DataTable().ajax.reload();
              $('#adjustment_table').DataTable().ajax.reload();    
            }             
        })    
        }       
      })
    }
  {{-- delete adjustment end --}} 

  {{-- btn_forward start --}}
    $('#forward_modal').on('hide.bs.modal', function(){
      var msg = "";
      var notif_msg = "";
      clear_attributes();
      clearFields      
    }); 

    $('.forward').on('click', function(e){
      e.prevenDefault;  
      $.ajax({
        method: "POST",
        url: "{{ route('allotment.store') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'forward' : 1,
          'message' : $('#forward_notif_msg').val(),
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
                title: 'Activities/Object has been successfully forwarded.',
                showConfirmButton: false,
                timer: 1500
            })             
            $('#forward_modal').modal('toggle')  
          }
        },
      });
    })
  {{-- btn_forward end --}}
  
{{-- END --}}