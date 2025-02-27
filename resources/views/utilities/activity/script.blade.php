{{-- table start --}}
  var library_activity_table = $('#library_activity_table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    lengthChange: false,
    autoWidth: false,
    dom: 'Bfrtip',
    ajax: {
      url: "{{ route('library_activity.table') }}",
      method: "GET",
      data : {
      '_token': '{{ csrf_token() }}'
      }
    },    
    columns: [      
      {data: 'activity', name: 'activity'},
      {data: 'activity_code', name: 'activity_code'},
      {data: 'request_status_type', name: 'request_status_type'},
      {data: 'division_acronym', name: 'division_acronym'},
      {data: 'is_program', name: 'is_program',
        render: function (data, type, row) {
        if (type === 'display' || type === 'filter' ) {
          return data=='1' ? 'Yes' : 'No';
        }
          return data;
        }
      },
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
    $('#library_activity_modal').on('hide.bs.modal', function(){       
      init_view_library_activity();
      clear_attributes();
      clearFields
    });  

    $('#library_activity_modal').on('shown.bs.modal', function () {
      $('#library_activity_name').focus();
    })  
  {{-- modal end --}}

  {{-- view start --}}
    function init_view_library_activity(){
      $('.library-activity-field')
        .val('')
        .attr('disabled', true);

      $('.save-buttons')
        .removeClass('d-inline')
        .addClass('d-none')
        .attr('disabled', true);
    }

    function view_library_activity(library_activity_id){
      var request = $.ajax({
        method: "GET",
        url: "{{ route('library_activity.show') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'id' : library_activity_id
        }
      });
      return request;
    }

    $('#library_activity_table').on('click', '.view-library-activity', function(e){   
      $('#library_activity_modal_header').html("View Activity");     
      library_activity_id = $(this).parents('tr').data('id');
      init_view_library_activity();   
      var request = view_library_activity(library_activity_id);   
      request.then(function(data) {
        if(data['status'] == 1){          
          $('#library_activity_name').val(data['library_activity']['activity'])   
          $('#library_activity_code').val(data['library_activity']['activity_code'])   
          $('#library_activity_request_status_type_id').val(data['library_activity']['request_status_type_id'])   
          $('#library_activity_division_id').val(data['library_activity']['division_id'])   
          $('#library_activity_remarks').val(data['library_activity']['tags'])   
          if(data['library_activity']['is_program'] == 1) {
            $('#library_activity_is_program').iCheck('check'); 
          } 
          if(data['library_activity']['is_active'] == 1) {
            $('#library_activity_is_active').iCheck('check'); 
          } 
        }                      
      })
      $('#library_activity_modal').modal('toggle');
    })
  {{-- view end --}}

  {{-- add start --}}
    function init_add_library_activity(){
      $('.library-activity-field')
        .attr('disabled', false);
        
      $('#add_library_activity.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);      
    }

    $('#add_new_library_activity').on('click', function(){ 
      init_add_library_activity( );         
      $('#library_activity_modal_header').html("Add Activity");
      $('#library_activity_modal').modal('toggle');    
    })

    $('#add_library_activity').on('click', function(e){
      e.prevenDefault;  
      clear_attributes();  
      $.ajax({
        method: "POST",
        url: "{{ route('library_activity.store') }}",
        data: {
        '_token': '{{ csrf_token() }}',
        'activity' : $('#library_activity_name').val(),
        'activity_code' : $('#library_activity_code').val(),
        'request_status_type_id' : $('#library_activity_request_status_type_id').val(),
        'division_id' : $('#library_activity_division_id').val(),
        'tags' : $('#library_activity_remarks').val(),
        'is_rogram' :  ($('#library_activity_is_program').iCheck('update')[0].checked ? 1  : 0),
        'is_active' :  ($('#library_activity_is_active').iCheck('update')[0].checked ? 1  : 0)
        },
        success:function(data) {
          console.log(data);
          if(data.errors) {  
              if(data.errors.activity){
                $('#library_activity_name').addClass('is-invalid');
                $('#activity-error').html(data.errors.activity[0]);
              }        
              if(data.errors.activity_code){
                $('#library_activity_code').addClass('is-invalid');
                $('#activity-code-error').html(data.errors.activity_code[0]);
              }   
              if(data.errors.description){
                $('#library_activity_description').addClass('is-invalid');
                $('#description-error').html(data.errors.description[0]);
              } 
              if(data.errors.request_status_type_id){
                $('#library_activity_request_status_type_id').addClass('is-invalid');
                $('#request_status-type-error').html(data.errors.request_status_type_id[0]);
              }                       
          }
          if(data.success) {
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Activity has been successfully added.',
              showConfirmButton: false,
              timer: 1500
            }) 
            $('#library_activity_modal').modal('toggle');
            $('#library_activity_table').DataTable().ajax.reload();
          }
        },
      });
    })
  {{-- add end    --}}

  {{-- update start --}}
    function init_update_library_activity(){
      init_view_library_activity()
      $('.library-activity-field')
        .attr('disabled', false);

      $('#update_library_activity.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);
    }

    $('#update_library_activity').on('click', function(e){
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
            url: "{{ route('library_activity.update') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'activity' : $('#library_activity_name').val(),
              'activity_code' : $('#library_activity_code').val(),
              'request_status_type_id' : $('#library_activity_request_status_type_id').val(),
              'division_id' : $('#library_activity_division_id').val(),
              'tags' : $('#library_activity_remarks').val(),
              'is_program' :  ($('#library_activity_is_program').iCheck('update')[0].checked ? 1  : 0),
              'is_active' :  ($('#library_activity_is_active').iCheck('update')[0].checked ? 1  : 0)
            },
            success:function(data) {
              console.log(data);
              if(data.success) {
                Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: 'Activity has been successfully updated.',
                  showConfirmButton: false,
                  timer: 1500
                })                        
                $('#library_activity_modal').modal('toggle')  
                $('#library_activity_table').DataTable().ajax.reload();
              }                      
            }                             
          });                                
        }       
      })   
    })

    $('#library_activity_table').on('click', '.update-library-activity', function(e){
      $('#library_activity_modal_header').html("Update Activity");         
      init_update_library_activity();
      activity_id = $(this).parents('tr').data('id');
      var request = view_library_activity(activity_id);
      request.then(function(data) {
        if(data['status'] == 1){
          $('#library_activity_name').val(data['library_activity']['activity'])   
          $('#library_activity_code').val(data['library_activity']['activity_code'])    
          $('#library_activity_request_status_type_id').val(data['library_activity']['request_status_type_id'])   
          $('#library_activity_division_id').val(data['library_activity']['division_id'])   
          $('#library_activity_remarks').val(data['library_activity']['tags'])   
          if(data['library_activity']['is_program'] == 1) {
            $('#library_activity_is_program').iCheck('check'); 
          }
          if(data['library_activity']['is_active'] == 1) {
            $('#library_activity_is_active').iCheck('check'); 
          } 
        }                      
      })    
      $('#library_activity_modal').modal('toggle')       
    })
  {{-- update end --}}

{{-- END --}}

