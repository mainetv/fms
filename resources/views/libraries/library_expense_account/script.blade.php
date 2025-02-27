{{-- table start --}}
  var library_expense_account_table = $('#library_expense_account_table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    lengthChange: false,
    autoWidth: false,
    dom: 'Bfrtip',
    ajax: {
      url: "{{ route('library_expense_account.table') }}",
      method: "GET",
      data : {
      '_token': '{{ csrf_token() }}'
      }
    },    
    columns: [      
      {data: 'expense_account', name: 'expense_account'},
      {data: 'expense_account_code', name: 'expense_account_code'},
      {data: 'request_status_type', name: 'request_status_type'},
      {data: 'allotment_class', name: 'allotment_class'},
      {data: 'is_active', name: 'is_active',
        render: function (data, type, row) {
        if (type === 'display' || type === 'filter' ) {
          return data=='1' ? 'Yes' : 'No';
        }
          return data;
        }
      },
      {data: 'action', orderable: false, searchable: false}          
    ],
    buttons: [
      "copy", "excel", "pdf", "print", "colvis"
    ],
  });

{{-- table end --}}

{{-- START --}}
  {{-- modal start --}}
    $('#library_expenditure_modal').on('hide.bs.modal', function(){       
      init_view_library_expenditure();
      clear_attributes();
      clearFields
    });  

    $('#library_expenditure_modal').on('shown.bs.modal', function () {
      $('#library_expenditure_code').focus();
    })  
  {{-- modal end --}}

  {{-- view start --}}
    function init_view_library_expenditure(){
      $('.library-expenditure-field')
        .val('')
        .attr('disabled', true);

      $('.save-buttons')
        .removeClass('d-inline')
        .addClass('d-none')
        .attr('disabled', true);
    }

    function view_library_expenditure(library_expenditure_id){
      var request = $.ajax({
        method: "GET",
        url: "{{ route('library_object_expenditure.show') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'id' : library_expenditure_id
        }
      });
      return request;
    }

    $('#expenditure_library_table').on('click', '.view-library-expenditure', function(e){   
      $('#library_expenditure_modal_header').html("View expenditure Code");     
      library_expenditure_id = $(this).parents('tr').data('id');
      init_view_library_expenditure();   
      var request = view_library_expenditure(library_expenditure_id);   
      request.then(function(data) {
        if(data['status'] == 1){          
          $('#library_expenditure_code').val(data['library_object_expenditure']['expenditure_code'])   
          $('#library_expenditure_description').val(data['library_object_expenditure']['description'])   
          $('#library_expenditure_obligation_type').val(data['library_object_expenditure']['obligation_type'])   
          $('#library_expenditure_remarks').val(data['library_object_expenditure']['remarks'])   
          if(data['library_object_expenditure']['is_active'] == 1) {
            $('#library_expenditure_is_active').iCheck('check'); 
          } 
        }                      
      })
      $('#library_expenditure_modal').modal('toggle');
    })
  {{-- view end --}}

  {{-- add start --}}
    function init_add_library_expenditure(){
      $('.library-expenditure-field')
        .attr('disabled', false);
        
      $('#add_library_expenditure.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);      
    }

    $('#add_new_library_expenditure').on('click', function(){ 
      init_add_library_expenditure( );         
      $('#library_expenditure_modal_header').html("Add expenditure Code");
      $('#library_expenditure_modal').modal('toggle');    
    })

    $('#add_library_expenditure').on('click', function(e){
      e.prevenDefault;  
      clear_attributes();  
      $.ajax({
        method: "POST",
        url: "{{ route('library_object_expenditure.store') }}",
        data: {
        '_token': '{{ csrf_token() }}',
        'expenditure_code' : $('#library_expenditure_code').val(),
        'description' : $('#library_expenditure_description').val(),
        'obligation_type' : $('#library_expenditure_obligation_type').val(),
        'remarks' : $('#library_expenditure_remarks').val(),
        'is_active' :  ($('#library_expenditure_is_active').iCheck('update')[0].checked ? 1  : 0)
        },
        success:function(data) {
          console.log(data);
          if(data.errors) {         
              if(data.errors.expenditure_code){
                $('#library_expenditure_code').addClass('is-invalid');
                $('#expenditure-code-error').html(data.errors.expenditure_code[0]);
              }   
              if(data.errors.description){
                $('#library_expenditure_description').addClass('is-invalid');
                $('#description-error').html(data.errors.description[0]);
              } 
              if(data.errors.obligation_type){
                $('#library_expenditure_obligation_type').addClass('is-invalid');
                $('#obligation-type-error').html(data.errors.obligation_type[0]);
              }                       
          }
          if(data.success) {
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'User has been successfully added.',
              showConfirmButton: false,
              timer: 1500
            }) 
            $('#library_expenditure_modal').modal('toggle');
            $('#library_expenditure_table').DataTable().ajax.reload();
          }
        },
      });
    })
  {{-- add end    --}}
  
  {{-- update start --}}
    function init_update_library_expenditure(){
      init_view_library_expenditure()
      $('.library-expenditure-field')
        .attr('disabled', false);

      $('#update_library_expenditure.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);
    }

    $('#update_library_expenditure').on('click', function(e){
      e.preventDefault();
      clear_attributes()
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
            url: "{{ route('library_object_expenditure.update') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'emp_code' : $('#users_employee_code').val(),
              'user_role_id' : $('#users_library_expenditure_role_id').val(),
              'username' : $('#user_library_expenditurename').val(),              
              'password' : $('#users_password').val(),              
              'is_active' :  ($('#users_is_active').iCheck('update')[0].checked ? 1  : 0)
            },
            success:function(data) {
              console.log(data);
              if(data.success) {
                Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: 'User has been successfully updated.',
                  showConfirmButton: false,
                  timer: 1500
                })                        
                $('#library_expenditure_modal').modal('toggle')  
                $('#expenditure_library_table').DataTable().ajax.reload();
              }                      
            }                             
          });                                
        }       
      })   
    })

    $('#expenditure_library_table').on('click', '.update-user', function(e){
      $('#library_expenditure_modal_header').html("Update User");         
      init_update_library_expenditure();
      user_id = $(this).parents('tr').data('id');
      var request = view_library_expenditure(user_id);
      request.then(function(data) {
        if(data['status'] == 1){            
          $('#users_employee_code').val(data['library_object_expenditure']['emp_code'])   
          $('#users_library_expenditure_role_id').val(data['library_object_expenditure']['user_role_id'])   
          $('#users_library_expenditurename').val(data['library_object_expenditure']['username'])  
          if(data['library_object_expenditure']['is_active'] == 1) {
            $('#users_is_active').iCheck('check'); 
          }  
        }                      
      })    
      $('#library_expenditure_modal').modal('toggle')       
    })
  {{-- update end --}}

{{-- END --}}