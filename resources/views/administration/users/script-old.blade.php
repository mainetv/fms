{{-- table start --}}
  var users_table = $('#users_table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    lengthChange: false,
    autoWidth: false,
    stateSave: true,
    dom: 'Bfrtip',
    ajax: {
      url: "{{ route('administration.users.table') }}",
      method: "GET",
      data : {
      '_token': '{{ csrf_token() }}'
      }
    },    
    columns: [      
      {data: 'emp_code', name: 'emp_code'},
      {data: 'lname', name: 'lname'},
      {data: 'fname', name: 'fname'},
      {data: 'mname', name: 'mname'},
      {data: 'division_acronym', name: 'division_acronym'},
      {data: 'user_role', name: 'user_role'},
      {data: 'username', name: 'username'},
      {data: 'email', name: 'email'},      
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
    $('#user_modal').on('hide.bs.modal', function(){       
      init_view_user();
      clear_attributes();
      clearFields
    });  

    $('#user_modal').on('shown.bs.modal', function () {
      $('#users_employee_code').focus();
    })     
  {{-- modal end --}}

  {{-- view start --}}
    function init_view_user(){
      $('.users-field')
        .val('')
        .attr('disabled', true);

      $('.save-buttons')
        .removeClass('d-inline')
        .addClass('d-none')
        .attr('disabled', true);
    }

    function view_user(user_id){
      var request = $.ajax({
        method: "GET",
        url: "{{ route('administration.users.show') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'id' : user_id
        }
      });
      return request;
    }

    $('#users_table').on('click', '.view-user', function(e){   
      $('#user_modal_header').html("View User");     
      user_id = $(this).parents('tr').data('id');
      init_view_user();   
      var request = view_user(user_id);   
      request.then(function(data) {
        if(data['status'] == 1){          
          $('#users_employee_code').val(data['user']['emp_code'])   
          $('#users_user_role_id').val(data['user']['user_role_id'])   
          $('#users_username').val(data['user']['username'])   
          if(data['user']['is_active'] == 1) {
            $('#users_is_active').iCheck('check'); 
          } 
        }
                      
      })
      $('#user_modal').modal('toggle');
    })
  {{-- view end --}}

  {{-- add start --}}
    function init_add_user(){
      $('.users-field')
        .attr('disabled', false);
        
      $('#add_user.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);     
        
      $('#users_is_active').prop('checked', true);
    }

    $('#add_new_user').on('click', function(){ 
      init_add_user( );         
      $('#user_modal_header').html("Add User");
      $('#user_modal').modal('toggle');    
    })

    $('#add_user').on('click', function(e){
      e.prevenDefault;  
      clear_attributes();  
      $.ajax({
        method: "POST",
        url: "{{ route('administration.users.store') }}",
        data: {
        '_token': '{{ csrf_token() }}',
        'emp_code' : $('#users_employee_code').val(),
        'user_role_id' : $('#users_user_role_id').val(),
        {{-- 'username' : $('#users_username').val(),
        'password' : $('#users_password').val(), --}}
        'is_active' :  ($('#users_is_active').iCheck('update')[0].checked ? 1  : 0)
        },
        success:function(data) {
          console.log(data);
          if(data.errors) {         
              {{-- if(data.errors.emp_code){
                $('#users_employee_code').addClass('is-invalid');
                $('#employee-code-error').html(data.errors.emp_code[0]);
              }   
              if(data.errors.user_role_id){
                $('#users_user_role_id').addClass('is-invalid');
                $('#user-role-error').html(data.errors.user_role_id[0]);
              } 
              if(data.errors.username){
                $('#users_username').addClass('is-invalid');
                $('#username-error').html(data.errors.username[0]);
              } 
              if(data.errors.password){
                $('#users_password').addClass('is-invalid');
                $('#password-error').html(data.errors.password[0]);
              }                          --}}
          }
          if(data.success) {
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'User has been successfully added.',
              showConfirmButton: false,
              timer: 1500
            }) 
            $('#user_modal').modal('toggle');
            $('#users_table').DataTable().ajax.reload();
          }
        },
      });
    })
  {{-- add end    --}}
  
  {{-- update start --}}
    function init_update_user(){
      init_view_user()
      $('.users-field')
        .attr('disabled', false);

      $('#update_user.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);
    }

    $('#update_user').on('click', function(e){
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
            url: "{{ route('administration.users.update') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'emp_code' : $('#users_employee_code').val(),
              'user_role_id' : $('#users_user_role_id').val(),
              'username' : $('#user_username').val(),              
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
                $('#user_modal').modal('toggle')  
                $('#users_table').DataTable().ajax.reload();
              }                      
            }                             
          });                                
        }       
      })   
    })

    $('#users_table').on('click', '.update-user', function(e){
      $('#user_modal_header').html("Update User");         
      init_update_user();
      user_id = $(this).parents('tr').data('id');
      var request = view_user(user_id);
      request.then(function(data) {
        if(data['status'] == 1){            
          $('#users_employee_code').val(data['user']['emp_code'])   
          $('#users_user_role_id').val(data['user']['user_role_id'])   
          $('#users_username').val(data['user']['username'])  
          if(data['user']['is_active'] == 1) {
            $('#users_is_active').iCheck('check'); 
          }  
        }                      
      })    
      $('#user_modal').modal('toggle')       
    })
  {{-- update end --}}

{{-- END --}}