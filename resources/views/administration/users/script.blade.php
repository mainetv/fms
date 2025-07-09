const requiredFields = [
  { id: 'users_employee_code', event: 'change', isSelect: true },
  { id: 'users_user_role_id', event: 'change', isSelect: true },
];

requiredFields.forEach(field => {
  const element = $(`#${field.id}`);
  if (element.length > 0) {
    element.on(field.event, function() {
      validateField($(this), field.isSelect);
    });
  }
});

@include('scripts.validation');

function actionButtons($id) {
  return `<center style="white-space:nowrap">              
            <button class="btn_edit_user btn btn-xs btn-outline-info tippy-btn"  
              data-id="${$id}"><i class="fa-solid fa-edit"></i>
            </button>
              </center>`;
} 

var tbl_users = $('#tbl_users').DataTable({
  processing: true,
  serverSide: true,
  destroy: true,
  ajax: {
    url: "{{ route('listUserAccounts') }}",
    method: "GET",
    dataSrc: function (json) {
      console.log('DataTables Ajax Response:', json); // check this in browser console
      return json.data;
    }
  },
  rowId: 'id',
  order: [[1, 'asc']],
  columns: [
    { data: 'emp_code' },
    { data: 'full_name' },
    { data: 'division' },
    { data: 'user_roles' },
    { data: 'username' },
    { data: 'email' },
    { 
      data: 'is_active',
      render: function(data) {
        return data ? 'Yes' : 'No';
      }
    },    
    { 
      data: "id",
      orderable: false,
      render: function(data, type, row) {
        return actionButtons(data);
      }
    },
  ]
});

function init_add_user(){
  $('.users-field')
    .attr('disabled', false);
    
  $('#add_user.save-buttons')
    .addClass('d-inline')
    .removeClass('d-none')
    .attr('disabled', false);  
    
  $('.update_user').addClass('d-none');
}

$('#btn_add_user').click(function (e) {  
  e.preventDefault();          
  init_add_user();     
  clearFields();
  $('#user_modal_header').html("Add User");
  $('#user_modal').modal('toggle');              
});

$('.add_user').click(function (e) {
  $.ajax({
    method: 'POST',
    url: '{{ route('administration.user.store') }}',       
    data: $('#frm_user').serializeArray().concat(),           
    success:function(response) {
      $('#user_modal').modal('toggle');                     
      Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'User account added successfully.',
        showConfirmButton: false,
        timer: 1500
      })  
    },            
    error: function (xhr) {
      var response = JSON.parse(xhr.responseText);  
      var $firstErrorField = null;
      var firstErrorTop = Number.MAX_VALUE; 

      requiredFields.forEach(field => {
        const element = $('#' + field.id);
        const feedbackElement = $('#' + field.id + '-feedback');
        if (field.isTinyMCE) {
          const editor = tinymce.get(field.id);
          if (response.errors[field.id]) {
            editor.getContainer().classList.add('is-invalid');
            feedbackElement.html(response.errors[field.id][0]).show();
          } else {
            editor.getContainer().classList.remove('is-invalid');
            feedbackElement.html('').hide();
          }
        } else {
          if (response.errors[field.id]) {
            if (element.is(':visible') && element.offset()) {
              const fieldTop = element.offset().top;
              if (fieldTop < firstErrorTop) {
                  firstErrorField = element;
                  firstErrorTop = fieldTop;
              }
            }
            if (element.is('select')) {
              element.next('span').addClass('is-invalid'); 
            } else {
              element.addClass('is-invalid');  
            }
            feedbackElement.html(response.errors[field.id][0]).show();
          } else {
            if (element.is('select')) {
              element.next('span').removeClass('is-invalid');
            } else {
              element.removeClass('is-invalid');
            }
            feedbackElement.html('').hide();
          }
        }
      });           

      if ($firstErrorField && $firstErrorField.length > 0) {
          $('html, body').animate({ scrollTop: $firstErrorField.offset().top - 100 }, 'slow');
      }
    }
  }); 
});   

function init_edit_user(){
  $('.users-field')
    .attr('disabled', false);
    
  $('#update_user.save-buttons')
    .addClass('d-inline')
    .removeClass('d-none')
    .attr('disabled', false);         
}

 $('#tbl_users').on('click', '.btn_edit_user', function (e) {
  e.preventDefault(); 
  init_edit_user();
  var id = $(this).data('id'); 
  $('#user_modal_header').html("Edit User");
  $.ajax({
    method: "GET",
    url: '{{ route('administration.user.show', ':id') }}'.replace(':id', id),    
    success: function(response) { 
      $('#users_employee_code')
        .val(response.emp_code)
        .trigger('change');

      $('#users_user_role_id')
        .val(response.user_role_ids)
        .trigger('change');
    },       
  });   
  $('#user_modal').modal('toggle')   
});

{{--$('.update_user').click(function (e) {    
  e.preventDefault();    
  var id = $('#frm_cooperating_agency #id').val();
  Swal.fire({
    title: 'Are you sure you want to save changes?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes'
  })
  .then((result) => {        
    if (result.value) {          
      $.ajax({
        method: 'PATCH',
        url: '{{ route('administration.user.update', ':id') }}'.replace(':id', id),
        data: $('#frm_cooperating_agency').serializeArray(),
        success:function(response) {      
          tbl_cooperating_agencies.ajax.reload();    
          $('#cooperating_agency_modal').modal('toggle');                                     
          Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Cooperating agency edited successfully.',
            showConfirmButton: false,
            timer: 1500
          })  
        },
        error: function (xhr) {
          var response = JSON.parse(xhr.responseText);  
          var $firstErrorField = null;
          var firstErrorTop = Number.MAX_VALUE; 

          cooperatingRequiredFields.forEach(field => {
            const element = $('#' + field.id);
            const feedbackElement = $('#' + field.id + '-feedback');
            if (field.isTinyMCE) {
              const editor = tinymce.get(field.id);
              if (response.errors[field.id]) {
                editor.getContainer().classList.add('is-invalid');
                feedbackElement.html(response.errors[field.id][0]).show();
              } else {
                editor.getContainer().classList.remove('is-invalid');
                feedbackElement.html('').hide();
              }
            } else {
              if (response.errors[field.id]) {
                if (element.is(':visible') && element.offset()) {
                  const fieldTop = element.offset().top;
                  if (fieldTop < firstErrorTop) {
                      firstErrorField = element;
                      firstErrorTop = fieldTop;
                  }
                }
                if (element.is('select')) {
                  element.next('span').addClass('is-invalid'); 
                } else {
                  element.addClass('is-invalid');  
                }
                feedbackElement.html(response.errors[field.id][0]).show();
              } else {
                if (element.is('select')) {
                  element.next('span').removeClass('is-invalid');
                } else {
                  element.removeClass('is-invalid');
                }
                feedbackElement.html('').hide();
              }
            }
          });           

          if ($firstErrorField && $firstErrorField.length > 0) {
              $('html, body').animate({ scrollTop: $firstErrorField.offset().top - 100 }, 'slow');
          }
        }   
      });                                      
    }       
  })    
}); 

$('#tbl_users').on('click', '.btn_delete_user', function (e) {
  e.preventDefault(); 
  var id = $(this).data('id'); 
  Swal.fire({
    title: 'Are you sure you want to delete this cooperating agency?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes'
  })
  .then((result) => {        
    if (result.value) {          
      $.ajax({
        method: 'DELETE', 
        url: '{{ route('administration.user.destroy', ':id') }}'.replace(':id', id),
        data: { id:id },
        success:function(response) {      
          tbl_cooperating_agencies.ajax.reload();                                   
          Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: response.message,
            showConfirmButton: false,
            timer: 1500
          })  
        },  
        error: function (xhr, status, error) {
          Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: response.message,
            showConfirmButton: false,
            timer: 1500
          });
        }  
      });                                      
    }       
  })  
});   --}}