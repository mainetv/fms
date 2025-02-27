{{-- table start --}}
  var library_specific_table = $('#library_specific_table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    lengthChange: false,
    autoWidth: false,
    dom: 'Bfrtip',
    ajax: {
      url: "{{ route('library_object_specific.table') }}",
      method: "GET",
      data : {
      '_token': '{{ csrf_token() }}'
      }
    },    
    columns: [      
      {data: 'object_specific', name: 'object_specific'},
      {data: 'object_expenditure', name: 'object_expenditure'},
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
    $('#library_specific_modal').on('hide.bs.modal', function(){       
      init_view_library_specific();
      clear_attributes();
      clearFields
    });  

    $('#library_specific_modal').on('shown.bs.modal', function () {
      $('#library_specific_code').focus();
    })  
  {{-- modal end --}}

  {{-- view start --}}
    function init_view_library_specific(){
      $('.library-specific-field')
        .val('')
        .attr('disabled', true);

      $('.save-buttons')
        .removeClass('d-inline')
        .addClass('d-none')
        .attr('disabled', true);
    }

    function view_library_specific(library_specific_id){
      var request = $.ajax({
        method: "GET",
        url: "{{ route('library_object_specific.show') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'id' : library_specific_id
        }
      });
      return request;
    }

    $('#specific_library_table').on('click', '.view-library-specific', function(e){   
      $('#library_specific_modal_header').html("View specific Code");     
      library_specific_id = $(this).parents('tr').data('id');
      init_view_library_specific();   
      var request = view_library_specific(library_specific_id);   
      request.then(function(data) {
        if(data['status'] == 1){          
          $('#library_specific_code').val(data['library_object_specific']['specific_code'])   
          $('#library_specific_description').val(data['library_object_specific']['description'])   
          $('#library_specific_obligation_type').val(data['library_object_specific']['obligation_type'])   
          $('#library_specific_remarks').val(data['library_object_specific']['remarks'])   
          if(data['library_object_specific']['is_active'] == 1) {
            $('#library_specific_is_active').iCheck('check'); 
          } 
        }                      
      })
      $('#library_specific_modal').modal('toggle');
    })
  {{-- view end --}}

  {{-- add start --}}
    function init_add_library_specific(){
      $('.library-specific-field')
        .attr('disabled', false);
        
      $('#add_library_specific.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);      
    }

    $('#add_new_library_specific').on('click', function(){ 
      init_add_library_specific( );         
      $('#library_specific_modal_header').html("Add specific Code");
      $('#library_specific_modal').modal('toggle');    
    })

    $('#add_library_specific').on('click', function(e){
      e.prevenDefault;  
      clear_attributes();  
      $.ajax({
        method: "POST",
        url: "{{ route('library_object_specific.store') }}",
        data: {
        '_token': '{{ csrf_token() }}',
        'specific_code' : $('#library_specific_code').val(),
        'description' : $('#library_specific_description').val(),
        'obligation_type' : $('#library_specific_obligation_type').val(),
        'remarks' : $('#library_specific_remarks').val(),
        'is_active' :  ($('#library_specific_is_active').iCheck('update')[0].checked ? 1  : 0)
        },
        success:function(data) {
          console.log(data);
          if(data.errors) {         
              if(data.errors.specific_code){
                $('#library_specific_code').addClass('is-invalid');
                $('#specific-code-error').html(data.errors.specific_code[0]);
              }   
              if(data.errors.description){
                $('#library_specific_description').addClass('is-invalid');
                $('#description-error').html(data.errors.description[0]);
              } 
              if(data.errors.obligation_type){
                $('#library_specific_obligation_type').addClass('is-invalid');
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
            $('#library_specific_modal').modal('toggle');
            $('#library_specific_table').DataTable().ajax.reload();
          }
        },
      });
    })
  {{-- add end    --}}
  
  {{-- update start --}}
    function init_update_library_specific(){
      init_view_library_specific()
      $('.library-specific-field')
        .attr('disabled', false);

      $('#update_library_specific.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);
    }

    $('#update_library_specific').on('click', function(e){
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
            url: "{{ route('library_object_specific.update') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'emp_code' : $('#users_employee_code').val(),
              'user_role_id' : $('#users_library_specific_role_id').val(),
              'username' : $('#user_library_specificname').val(),              
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
                $('#library_specific_modal').modal('toggle')  
                $('#specific_library_table').DataTable().ajax.reload();
              }                      
            }                             
          });                                
        }       
      })   
    })

    $('#specific_library_table').on('click', '.update-user', function(e){
      $('#library_specific_modal_header').html("Update User");         
      init_update_library_specific();
      user_id = $(this).parents('tr').data('id');
      var request = view_library_specific(user_id);
      request.then(function(data) {
        if(data['status'] == 1){            
          $('#users_employee_code').val(data['library_object_specific']['emp_code'])   
          $('#users_library_specific_role_id').val(data['library_object_specific']['user_role_id'])   
          $('#users_library_specificname').val(data['library_object_specific']['username'])  
          if(data['library_object_specific']['is_active'] == 1) {
            $('#users_is_active').iCheck('check'); 
          }  
        }                      
      })    
      $('#library_specific_modal').modal('toggle')       
    })
  {{-- update end --}}

{{-- END --}}