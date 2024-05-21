{{-- modal start --}}
  $('#bp_form7_modal').on('hide.bs.modal', function(){     
    clear_attributes();
    clear_fields();
  });  
{{-- modal end --}}

{{-- add start --}}
  function init_add_bp_form7(){
    $('.bp-form7-field')
      .attr('disabled', false);
      
    $('#add_bp_form7.save-buttons')
      .addClass('d-inline')
      .removeClass('d-none')
      .attr('disabled', false);      
  }

  $('#add_new_bp_form7').on('click', function(){     
    init_add_bp_form7();         
    $('#bp_form7_modal_header').html("Add DOST Form No. 7");
    $('#bp_form7_modal').modal('toggle')       
  })

  $('#add_bp_form7').on('click', function(event){        
    event.prevenDefault;  
    clear_attributes();
    $.ajax({
      method: "POST",
      url: "{{ route('bp_form7.store') }}",
      data: {
        '_token': '{{ csrf_token() }}',
        'division_id' : $('#division_id').val(),
        'year' : $('#year').val(),        
      },
      success:function(data) {
        console.log(data);
        if(data.errors) {         
          if(data.errors.description){
            $('#description').addClass('is-invalid');
            $('#description-error').html(data.errors.description[0]);
          }                          
        }
        if(data.success) {
          Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'DOST Form No. 7 has been successfully added.',
            showConfirmButton: false,
            timer: 1500
          }) 
          $('#bp_form7_modal').modal('toggle')
          $('#bp_form7_table').DataTable().ajax.reload();
        }
      },
    });
  })
{{-- add end    --}}

{{-- update start --}}
  function init_update_bp_form7(){
    init_view_bp_form7()
    $('.bp-form7-field')
      .attr('disabled', false);

    $('#update_bp_form7.save-buttons')
      .addClass('d-inline')
      .removeClass('d-none')
      .attr('disabled', false);
  }

  $('#update_bp_form7').on('click', function(event){
    event.preventDefault();
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
      url: "{{ route('bp_form7.update') }}",
      data: {
        '_token': '{{ csrf_token() }}',
        'division_id' : $('#division_id').val(),
        'year' : $('#year').val(),
      },
      success:function(data) {
        console.log(data);
        if(data.errors) {         
          if(data.errors.description){
            $('#description').addClass('is-invalid');
            $('#description-error').html(data.errors.description[0]);
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
          $('#bp_form7_modal').modal('toggle')
          $('#bp_form7_table').DataTable().ajax.reload();
        }                      
        }                             
      });                                
      }       
    })   
  })      

  $('#abp_form7_table').on('click', '.update-bp-form7', function(e){
    $('#bp_form7_modal_header').html("Update DOST Form No. 7");        
    init_update_bp_form7();
    bp_form7_id = $(this).parents('tr').data('id');
    var request = view_bp_form7(bp_form7_id);
    request.then(function(data) {
      if(data['status'] == 1){        
        $('.consortium_type_id').each(function() {
          $(this).val(data['agency'][$(this).attr('name')]).change();
        });   
        $('#agency_name').val(data['agency']['agency']) 
      }           
    })
    $('#bp_form7_modal').modal('toggle')            
  })
{{-- update end --}}