
{{-- START --}}
  {{-- modal start --}}
    $('#nca_modal').on('hide.bs.modal', function(){
      init_view_nca();
      clear_attributes();
      clearFields      
    });     
  {{-- modal end --}}

  {{-- view start --}}   
    function init_view_nca(){
      $('.nca-field')
        .val('')
        .attr('disabled', true);

      $('.save-buttons')
        .removeClass('d-inline')
        .addClass('d-none')
        .attr('disabled', true);
    }
  {{-- view end --}}

  {{-- add start --}}     
    function init_add_nca(){
      $('.nca-field')
        .attr('disabled', false);
        
      $('.add_nca.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);      
    }
    
    $('.btn_add').on('click', function(e){       
      init_add_nca();   
      var fund = $(this).data('fund');
      var year = $(this).data('year');
      $(".modal-body #fund_id").val(fund);
      $(".modal-body #year").val(year);       
      $('#nca_modal').modal('toggle')       
    })

    $('.add_nca').on('click', function(e){     
      e.prevenDefault;  
      clear_attributes();      
      $.ajax({
        method: "POST",
        url: "{{ route('nca.store') }}",
        data: {
          '_token': '{{ csrf_token() }}',      
          'year' : $('#year').val(),
          'fund_id' : $('#fund_id').val(),          
          'jan_nca' : $('#jan_nca').val(),
          'feb_nca' : $('#feb_nca').val(),
          'mar_nca' : $('#mar_nca').val(),
          'apr_nca' : $('#apr_nca').val(),
          'may_nca' : $('#may_nca').val(),
          'jun_nca' : $('#jun_nca').val(),
          'jul_nca' : $('#jul_nca').val(),
          'aug_nca' : $('#aug_nca').val(),
          'sep_nca' : $('#sep_nca').val(),
          'oct_nca' : $('#oct_nca').val(),
          'nov_nca' : $('#nov_nca').val(),
          'dec_nca' : $('#dec_nca').val(),
        },
        success:function(data) {
          console.log(data);
          if(data.errors) {      
          }
          if(data.success) {
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'NCA has been successfully added.',
              showConfirmButton: false,
              timer: 1500
            })   
            $('#nca_modal').modal('toggle');                            
          }
        },
      });
    })   
  {{-- add end    --}}

     
{{-- END --}}