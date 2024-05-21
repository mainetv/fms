{{-- table start --}}
  var library_subactivity_table = $('#library_subactivity_table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    lengthChange: false,
    autoWidth: false,
    dom: 'Bfrtip',
    ajax: {
      url: "{{ route('library_subactivity.table') }}",
      method: "GET",
      data : {
      '_token': '{{ csrf_token() }}'
      }
    },    
    columns: [      
      {data: 'subactivity', name: 'subactivity'},
      {data: 'description', name: 'description'},
      {{-- {data: 'request_status_type', name: 'request_status_type'}, --}}
      {{-- {data: 'is_continuing', name: 'is_continuing',
        render: function (data, type, row) {
        if (type === 'display' || type === 'filter' ) {
          return data=='1' ? 'Yes' : 'No';
        }
          return data;
        }
      }, --}}
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
    {{-- $('#library_subactivity_modal').on('hide.bs.modal', function(){       
      init_view_library_subactivity();
      clear_attributes();
      clear_fields();
    });  

    $('#library_subactivity_modal').on('shown.bs.modal', function () {
      $('#library_subactivity').focus();
    })   --}}
  {{-- modal end --}}

  {{-- view start --}}
    {{-- function init_view_library_subactivity(){
      $('.library-subactivity-field')
        .val('')
        .attr('disabled', true);

      $('.save-buttons')
        .removeClass('d-inline')
        .addClass('d-none')
        .attr('disabled', true);
    }

    function view_library_subactivity(library_subactivity_id){
      var request = $.ajax({
        method: "GET",
        url: "{{ route('library_subactivity.show') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'id' : library_subactivity_id
        }
      });
      return request;
    }

    $('#library_subactivity_table').on('click', '.view-library-subactivity', function(e){   
      $('#library_subactivity_modal_header').html("View Activity");     
      library_subactivity_id = $(this).parents('tr').data('id');
      init_view_library_subactivity();   
      var request = view_library_subactivity(library_subactivity_id);   
      request.then(function(data) {
        if(data['status'] == 1){          
          $('#library_subactivity').val(data['library_subactivity']['subactivity'])   
          $('#library_subactivity_description').val(data['library_subactivity']['description'])   
          $('#library_subactivity_request_status_type_id').val(data['library_subactivity']['request_status_type_id'])   
          $('#library_subactivity_remarks').val(data['library_subactivity']['remarks'])  
          if(data['library_subactivity']['is_continuing'] == 1) {
            $('#library_subactivity_is_is_continuing').iCheck('check'); 
          }  
          if(data['library_subactivity']['is_active'] == 1) {
            $('#library_subactivity_is_active').iCheck('check'); 
          } 
        }                      
      })
      $('#library_subactivity_modal').modal('toggle');
    }) --}}
  {{-- view end --}}

  {{-- add start --}}
    {{-- function init_add_library_subactivity(){
      $('.library-subactivity-field')
        .attr('disabled', false);
        
      $('#add_library_subactivity.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);      
    }

    $('#add_new_library_subactivity').on('click', function(){ 
      init_add_library_subactivity( );         
      $('#library_subactivity_modal_header').html("Add Activity");
      $('#library_subactivity_modal').modal('toggle');    
    })

    $('#add_library_subactivity').on('click', function(e){
      e.prevenDefault;  
      clear_attributes();  
      $.ajax({
        method: "POST",
        url: "{{ route('library_subactivity.store') }}",
        data: {
        '_token': '{{ csrf_token() }}',
        'subactivity' : $('#library_subactivity').val(),
        'description' : $('#library_subactivity_description').val(),
        'request_status_type_id' : $('#library_subactivity_request_status_type_id').val(),
        'remarks' : $('#library_subactivity_remarks').val(),
        'is_continuing' :  ($('#library_subactivity_is_continuing').iCheck('update')[0].checked ? 1  : 0),
        'is_active' :  ($('#library_subactivity_is_active').iCheck('update')[0].checked ? 1  : 0)
        },
        success:function(data) {
          console.log(data);
          if(data.errors) {         
              if(data.errors.subactivity){
                $('#library_subactivity').addClass('is-invalid');
                $('#subactivity-error').html(data.errors.subactivity[0]);
              }   
              if(data.errors.description){
                $('#library_subactivity_description').addClass('is-invalid');
                $('#description-error').html(data.errors.description[0]);
              } 
              if(data.errors.request_status_type_id){
                $('#library_subactivity_request_status_type_id').addClass('is-invalid');
                $('#request-status-type-error').html(data.errors.request_status_type_id[0]);
              }                       
          }
          if(data.success) {
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Subactivity has been successfully added.',
              showConfirmButton: false,
              timer: 1500
            }) 
            $('#library_subactivity_modal').modal('toggle');
            $('#library_subactivity_table').DataTable().ajax.reload();
          }
        },
      });
    }) --}}
  {{-- add end    --}}

  {{-- update start --}}
    {{-- function init_update_library_subactivity(){
      init_view_library_subactivity()
      $('.library-subactivity-field')
        .attr('disabled', false);

      $('#update_library_subactivity.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);
    }

    $('#update_library_subactivity').on('click', function(e){
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
            url: "{{ route('library_subactivity.update') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'subactivity' : $('#library_subactivity').val(),
              'description' : $('#library_subactivity_description').val(),
              'request_status_type_id' : $('#library_subactivity_request_status_type_id').val(),
              'remarks' : $('#library_subactivity_remarks').val(),
              'is_continuing' :  ($('#library_subactivity_is_continuing').iCheck('update')[0].checked ? 1  : 0),
              'is_active' :  ($('#library_subactivity_is_active').iCheck('update')[0].checked ? 1  : 0)
            },
            success:function(data) {
              console.log(data);
              if(data.success) {
                Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: 'Subactivity has been successfully updated.',
                  showConfirmButton: false,
                  timer: 1500
                })                        
                $('#library_subactivity_modal').modal('toggle')  
                $('#library_subactivity_table').DataTable().ajax.reload();
              }                      
            }                             
          });                                
        }       
      })   
    })

    $('#library_subactivity_table').on('click', '.update-library-subactivity', function(e){
      $('#library_subactivity_modal_header').html("Update Subactivity");         
      init_update_library_subactivity();
      library_subactivity_id = $(this).parents('tr').data('id');
      var request = view_library_subactivity(library_subactivity_id);
      request.then(function(data) {
        if(data['status'] == 1){            
          $('#library_subactivity').val(data['library_subactivity']['subactivity'])    
          $('#library_subactivity_description').val(data['library_subactivity']['description'])   
          $('#library_subactivity_request_status_type_id').val(data['library_subactivity']['request_status_type_id'])   
          $('#library_subactivity_remarks').val(data['library_subactivity']['remarks'])   
          if(data['library_subactivity']['is_continuing'] == 1) {
            $('#library_subactivity_is_continuing').iCheck('check'); 
          } 
          if(data['library_subactivity']['is_active'] == 1) {
            $('#library_subactivity_is_active').iCheck('check'); 
          } 
        }                      
      })    
      $('#library_subactivity_modal').modal('toggle')       
    }) --}}
  {{-- update end --}}
{{-- END --}}