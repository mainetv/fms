
{{-- START --}}
  {{-- add start --}}
    function init_add(){
      $('#add.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);      
    }
    
    $('.btn_add').on('click', function(){  
      init_add( );        
      $('#radai_modal_header').html("Add RADAI");
      $('#radai_modal').modal('toggle')       
    })

    $('.add').on('click', function(e){  
      mm = $("#radai_date").datepicker('getDate').getMonth() + 1; 
      var month = ( mm < 10 ) ? ( "0" + ( mm ).toString() ) : ( mm ).toString();
      var year = $("#radai_date").datepicker('getDate').getFullYear();   
      var bank_account_id = $('#bank_account_id').val(); 
      var radai_date = $('#radai_date').val(); 
      e.prevenDefault;         
      clear_attributes();                   
      $.ajax({
        method: "POST",
        url: "{{ route('radai.store') }}",
        {{-- data:  $('#radai_form').serialize(), --}}
        data: {
          '_token': '{{ csrf_token() }}',      
          'month' : month,
          'year' : year,
          'radai_date' : radai_date ?? NULL,
          'bank_account_id' : bank_account_id,
        },
        success:function(data) {
          console.log(data);
          if(data.errors) {    
            if(data.errors.bank_account_id){
              $('#bank_account_id').addClass('is-invalid');
              $('#bank-error').html(data.errors.bank_account_id[0]);
            }      
            if(data.errors.radai_date){
              $('#radai_date').addClass('is-invalid');
              $('#date-error').html(data.errors.radai_date[0]);
            }           
          }
          if(data.success) {                         
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'RADAI has been successfully added.',
              showConfirmButton: false,
              timer: 1500
            })   
            $('#radai_modal').modal('toggle');
            $('#radai_table').DataTable().ajax.reload();
          }
        },        
      });      
    })    
    
  {{-- add end    --}}

  {{-- edit start --}}
    $('.btn_edit').on('click', function(e){     
      var check_id = $(this).data('dv-check-id');
      $('#check_bank_modal').modal('toggle')        
      list_bank_account_no(check_id);
    })

    function list_bank_account_no(check_id){ 
      var bank_account_table = $('#bank_account_table').DataTable({
        info: false,
        iDisplayLength: 20,
        order: [[0, 'desc']],
        ajax: {
          url: "{{ route('show_bank_account_no') }}",
          method: "GET",
          data : {
            '_token': '{{ csrf_token() }}',
          }      
        },
        columns: [
          {data: 'bank_acronym', title: 'Bank Branch', width: '7%', className: 'dt-center'},   
          {data: 'bank_account_no', title: 'Bank Account No.', width: '7%', className: 'dt-center'},   
          {data: 'fund', title: 'Fund', width: '8%', className: 'dt-center'},   
          {data: 'fund_cluster', title: 'Fund Cluster', width: '10%', className: 'dt-center'},         
        ]
      });
      $('#check_id').val(check_id);
    }

    $('#bank_account_table').on('click', '.update_bank_account_no', function(e){   
      var id = $(this).data('id');
      e.prevenDefault;  
      clear_attributes();      
      $.ajax({
        method: "PATCH",
        url: "{{ route('checks.update') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'dv_check_id' : $('#check_id').val(),
          'bank_account_id' : id,
          'update_bank_account_no' : 1,
        },
        success:function(data) {
          console.log(data);
          if(data.success) {
            $('#attach_dv_modal').modal('toggle')                     
            window.location.reload();  
          }
        },
      });      
    }) 
  {{-- edit end --}}

  {{-- print start --}}
    $('.print').on('click', function(e){ 	
      var radai_id = $('#radai_id').val();
      window.open("{{ url('/radai/print_radai') }}/" + radai_id);
    }) 
  {{-- print end --}}  

  {{-- delete start --}}
    $('#checks_table').on('click', '.btn_delete', function(e){
      id = $(this).data('id')
      delete_check(id);
    })

    function delete_check(id){
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
            url: "{{ route('checks.delete') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'id' : id,
              'delete_check' : 1,
            },
            success: function(data) {      
              Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Check has been successfully deleted.',
              showConfirmButton: false,
              timer: 1500
              }) 
              $('#checks_table').DataTable().ajax.reload();
            }             
        })    
        }       
      })
    }
  {{-- delete end --}} 

{{-- END --}}