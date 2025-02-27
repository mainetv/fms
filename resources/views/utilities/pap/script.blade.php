{{-- table start --}}
  var library_pap_table = $('#library_pap_table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    lengthChange: false,
    autoWidth: false,
    dom: 'Bfrtip',
    ajax: {
      url: "{{ route('library_pap.table') }}",
      method: "GET",
      data : {
      '_token': '{{ csrf_token() }}'
      }
    },    
    columns: [      
      {data: 'pap_code', name: 'pap_code'},
      {data: 'pap', name: 'pap'},
      {data: 'request_status_type', name: 'request_status_type'},
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
    $('#library_pap_modal').on('hide.bs.modal', function(){       
      init_view_library_pap();
      clear_attributes();
      clearFields
    });  

    $('#library_pap_modal').on('shown.bs.modal', function () {
      $('#library_pap_code').focus();
    })  
  {{-- modal end --}}

  {{-- view start --}}
    function init_view_library_pap(){
      $('.library-pap-field')
        .val('')
        .attr('disabled', true);

      $('.save-buttons')
        .removeClass('d-inline')
        .addClass('d-none')
        .attr('disabled', true);
    }

    function view_library_pap(library_pap_id){
      var request = $.ajax({
        method: "GET",
        url: "{{ route('library_pap.show') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'id' : library_pap_id
        }
      });
      return request;
    }

    $('#library_pap_table').on('click', '.view-library-pap', function(e){   
      $('#library_pap_modal_header').html("View PAP Code");     
      library_pap_id = $(this).parents('tr').data('id');
      init_view_library_pap();   
      var request = view_library_pap(library_pap_id);   
      request.then(function(data) {
        if(data['status'] == 1){          
          $('#library_pap_code').val(data['library_pap']['pap_code'])   
          $('#library_pap_pap').val(data['library_pap']['pap'])   
          $('#library_pap_description').val(data['library_pap']['description'])   
          $('#library_pap_request_status_type_id').val(data['library_pap']['request_status_type_id'])   
          $('#library_pap_remarks').val(data['library_pap']['remarks'])   
          if(data['library_pap']['is_active'] == 1) {
            $('#library_pap_is_active').iCheck('check'); 
          } 
        }                      
      })
      $('#library_pap_modal').modal('toggle');
    })
  {{-- view end --}}

  {{-- add start --}}
    function init_add_library_pap(){
      $('.library-pap-field')
        .attr('disabled', false);
        
      $('#add_library_pap.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);      
    }

    $('#add_new_library_pap').on('click', function(){ 
      init_add_library_pap( );         
      $('#library_pap_modal_header').html("Add PAP Code");
      $('#library_pap_modal').modal('toggle');    
    })

    $('#add_library_pap').on('click', function(e){
      e.prevenDefault;  
      clear_attributes();  
      $.ajax({
        method: "POST",
        url: "{{ route('library_pap.store') }}",
        data: {
        '_token': '{{ csrf_token() }}',
        'pap_code' : $('#library_pap_code').val(),
        'pap' : $('#library_pap_pap').val(),
        'description' : $('#library_pap_description').val(),
        'request_status_type_id' : $('#library_pap_request_status_type_id').val(),
        'remarks' : $('#library_pap_remarks').val(),
        'is_active' :  ($('#library_pap_is_active').iCheck('update')[0].checked ? 1  : 0)
        },
        success:function(data) {
          console.log(data);
          if(data.errors) {         
              if(data.errors.pap_code){
                $('#library_pap_code').addClass('is-invalid');
                $('#pap-code-error').html(data.errors.pap_code[0]);
              }   
              if(data.errors.pap){
                $('#library_pap_pap').addClass('is-invalid');
                $('#pap-error').html(data.errors.pap[0]);
              } 
              if(data.errors.request_status_type_id){
                $('#library_pap_request_status_type_id').addClass('is-invalid');
                $('#rs-type-error').html(data.errors.request_status_type_id[0]);
              }                       
          }
          if(data.success) {
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'PAP has been successfully added.',
              showConfirmButton: false,
              timer: 1500
            }) 
            $('#library_pap_modal').modal('toggle');
            $('#library_pap_table').DataTable().ajax.reload();
          }
        },
      });
    })
  {{-- add end    --}}
  
  {{-- update start --}}
    function init_update_library_pap(){
      init_view_library_pap()
      $('.library-pap-field')
        .attr('disabled', false);

      $('#update_library_pap.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);
    }

    $('#update_library_pap').on('click', function(e){
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
            url: "{{ route('library_pap.update') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'id' : pap_id,
              'pap_code' : $('#library_pap_code').val(),
              'pap' : $('#library_pap').val(),
              'description' : $('#library_pap_description').val(),
              'obligation_type' : $('#library_pap_obligation_type').val(),
              'remarks' : $('#library_pap_remarks').val(),
              'is_active' :  ($('#library_pap_is_active').iCheck('update')[0].checked ? 1  : 0)
            },
            success:function(data) {
              console.log(data);
              if(data.errors) {         
                if(data.errors.pap_code){
                  $('#library_pap_code').addClass('is-invalid');
                  $('#pap-code-error').html(data.errors.pap_code[0]);
                }   
                if(data.errors.pap){
                  $('#library_pap_pap').addClass('is-invalid');
                  $('#pap-error').html(data.errors.pap[0]);
                } 
                if(data.errors.request_status_type_id){
                  $('#library_pap_request_status_type_id').addClass('is-invalid');
                  $('#rs-type-error').html(data.errors.request_status_type_id[0]);
                }                     
            }
              if(data.success) {
                Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: 'PAP Code has been successfully updated.',
                  showConfirmButton: false,
                  timer: 1500
                })                        
                $('#library_pap_modal').modal('toggle')  
                $('#library_pap_table').DataTable().ajax.reload();
              }                      
            }                             
          });                                
        }       
      })   
    })

    $('#library_pap_table').on('click', '.update-library-pap', function(e){
      $('#library_pap_modal_header').html("Update PAP");         
      init_update_library_pap();
      pap_id = $(this).parents('tr').data('id');
      var request = view_library_pap(pap_id);
      request.then(function(data) {
        if(data['status'] == 1){            
          $('#library_pap_code').val(data['library_pap']['pap_code'])   
          $('#library_pap').val(data['library_pap']['pap'])   
          $('#library_pap_description').val(data['library_pap']['description'])   
          $('#library_pap_obligation_type').val(data['library_pap']['obligation_type'])   
          $('#library_pap_remarks').val(data['library_pap']['remarks'])   
          if(data['library_pap']['is_active'] == 1) {
            $('#library_pap_is_active').iCheck('check'); 
          } 
        }                      
      })    
      $('#library_pap_modal').modal('toggle')       
    })
  {{-- update end --}}

{{-- END --}}