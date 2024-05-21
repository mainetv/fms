
{{-- START --}}
  {{-- attach dv to check start --}}      
    $('.btn_attach_dv').on('click', function(e){   
      $('#attach_dv_modal').modal('toggle');
      mm = $("#check_date").datepicker('getDate').getMonth() + 1; 
      var month = ( mm < 10 ) ? ( "0" + ( mm ).toString() ) : ( mm ).toString();
      var year = $("#check_date").datepicker('getDate').getFullYear();   
      list_dvs(month, year);
    }) 

    function list_dvs(month, year){ 
      var dv_table = $('#dv_table').DataTable({
        info: false,
        destroy: true,
        iDisplayLength: 20,
        order: [[0, 'desc']],
        ajax: {
          url: "{{ route('show_all_dvs') }}",
          method: "GET",
          data : {
            '_token': '{{ csrf_token() }}',
            'month' : month,
            'year' : year,
            'attach_dv_check' : 1,
          }      
        },
        columns: [
          {data: 'dv_id', title: 'DV ID', width: '7%', className: 'dt-center'},   
          {data: 'dv_date', title: 'DV Date', width: '8%', className: 'dt-center'},   
          {data: 'dv_no', title: 'DV No.', width: '10%', className: 'dt-center'},
          {data: 'payee', title: 'Payee.', width: '40%', className: 'dt-head-center'},
          {data: 'fund', title: 'Fund', width: '15%', className: 'dt-center'},
          {data: 'total_dv_net_amount', title: 'Amount', width: '15%', className: 'dt-head-center dt-body-right',
            render: $.fn.dataTable.render.number(',', '.', 2, '')
          },
        ]
      });
    }

    $('#dv_table').on('click', '.attach_dv', function(e){     
      var dv_id = $(this).data('dv-id');
      e.prevenDefault;  
      clear_attributes();      
      $.ajax({
        method: "PATCH",
        url: "{{ route('checks.update') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'check_id' : $('#check_id').val(),
          'dv_id' : dv_id,
          'check_date' : $('#check_date').val(),
          'update_attach_dv' : 1,
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
    
    {{-- add check --}}
    $('.btn_add_check_attach_dv').on('click', function(e){  
      $('#attach_dv_modal').modal('toggle');
      mm = $("#check_date").datepicker('getDate').getMonth() + 1; 
      var month = ( mm < 10 ) ? ( "0" + ( mm ).toString() ) : ( mm ).toString();
      var year = $("#check_date").datepicker('getDate').getFullYear();   
      list_dvs_add_check(month, year);      
    }) 

    function list_dvs_add_check(month, year){ 
      var dv_table = $('#dv_table').DataTable({
        info: false,
        destroy: true,
        iDisplayLength: 20,
        order: [[0, 'desc']],
        ajax: {
          url: "{{ route('show_all_dvs') }}",
          method: "GET",
          data : {
            '_token': '{{ csrf_token() }}',
            'month' : month,
            'year' : year,
            'attach_dv_check' : 1,
            'add_check' : 1,
          }      
        },
        columns: [
          {data: 'dv_id', title: 'DV ID', width: '7%', className: 'dt-center'},   
          {data: 'dv_date', title: 'DV Date', width: '8%', className: 'dt-center'},   
          {data: 'dv_no', title: 'DV No.', width: '10%', className: 'dt-center'},
          {data: 'payee', title: 'Payee.', width: '40%', className: 'dt-head-center'},
          {data: 'fund', title: 'Fund', width: '15%', className: 'dt-center'},
          {data: 'total_dv_net_amount', title: 'Amount', width: '15%', className: 'dt-head-center dt-body-right',
            render: $.fn.dataTable.render.number(',', '.', 2, '')
          },
        ]
      });
    }
    
    $('#dv_table').on('click', '.add_check_attach_dv', function(e){     
      var dv_id = $(this).data('dv-id');
      e.prevenDefault;  
      clear_attributes();      
      $.ajax({
        method: "POST",
        url: "{{ route('checks.store') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'check_id' : $('#check_id').val(),
          'dv_id' : dv_id,
          'check_date' : $('#check_date').val(),
          'add_check_attach_dv' : 1,
        },
        success:function(data) {
          console.log(data);
          if(data.errors) {    
            if(data.errors.check_date){
              $('#check_date').addClass('is-invalid');
              $('#date-error').html(data.errors.check_date[0]);
            }           
          }
          if(data.success) {
            $('#attach_dv_modal').modal('toggle')  
            window.location.replace(data.redirect_url);    
          }
        },
      });      
    }) 
  {{-- attach dv to check end --}}
  
  {{-- edit start --}}
    $('.btn_edit').on('click', function(e){     
      var check_id = $(this).data('dv-check-id');
      $('#check_bank_modal').modal('toggle')        
      list_bank_account_no(check_id);
    })

    function list_bank_account_no(check_id){ 
      var bank_account_table = $('#bank_account_table').DataTable({
        info: false,
        destroy: true,
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
            $('#check_bank_modal').modal('toggle')                     
            window.location.reload();  
          }
        },
      });      
    }) 

    $('#attached_dv_table').on('click', '.btn_remove_attached_dv', function(e){
      var id = $(this).data('id');
      var dv_id = $(this).data('dv-id');
      Swal.fire({
        title: 'Are you sure you want to remove DV?',
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
              'dv_id' : dv_id,
              'remove_attached_dv' : 1,
            },
            success: function(data) {      
              Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'DV has been successfully removed.',
              showConfirmButton: false,
              timer: 1500
              }) 
              window.location.reload();
            }             
        })    
        }       
      })
    })

    $('.edit_check_dv').on('click', function(e){     
      e.preventDefault();
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
            dataType: 'json',         
            url: "{{ route('checks.update') }}",
            data:  $('#check_form').serialize() + "&edit_check_dv=1",
            success:function(data) {
              console.log(data);
              if(data.errors) {              
              }            
              if(data.success) {    
                Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: 'Check has been successfully updated.',
                  showConfirmButton: false,
                  timer: 1500
                })               
                window.location.reload();
              }                      
            }                             
          });                                
        }       
      })            
    })  
  {{-- edit end --}} 

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