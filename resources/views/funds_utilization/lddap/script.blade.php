
{{-- START --}}
  {{-- modal start --}}
    $("#attach_dv_modal").on("hidden.bs.modal", function(){ 
      $('#dv_table').DataTable().destroy();      
    });

    $("#payee_modal").on("hidden.bs.modal", function(){ 
      $('#payee_table').DataTable().destroy();      
    });
  {{-- modal end --}}

  {{-- add start --}}
    $('.add_lddap').on('click', function(e){  
      e.prevenDefault;         
      clear_attributes();                   
      $.ajax({
        method: "POST",
        url: "{{ route('lddap.store') }}",
        data:  $('#lddap_form').serialize() + "&add_lddap=1",
        success:function(data) {
          console.log(data);
          if(data.errors) {    
            if(data.errors.lddap_date){
              $('#lddap_date').addClass('is-invalid');
              $('#date-error').html(data.errors.lddap_date[0]);
            }      
            if(data.errors.fund_id ){
              $('#fund_id').addClass('is-invalid');
              $('#fund-error').html(data.errors.fund_id[0]);
            } 
            if(data.errors.bank_account_id ){
              $('#bank_account_id').addClass('is-invalid');
              $('#bank-account-id-error').html(data.errors.bank_account_id[0]);
            } 
            if(data.errors.payment_mode_id ){
              $('#payment_mode_id').addClass('is-invalid');
              $('#payment-mode-error').html(data.errors.payment_mode_id[0]);
            }             
          }
          if(data.success) { 
            window.location.replace(data.redirect_url);               
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'LDDAP has been successfully added.',
              showConfirmButton: false,
              timer: 1500
            })   
          }
        },        
      });      
    })    
    
  {{-- add end    --}}

  {{-- attach dv start --}}  
    $('.btn_attach_dv').on('click', function(e){  
      $('#attach_dv_modal').modal('toggle');
      var month = $(this).data('lddap-month');
      var year = $(this).data('lddap-year');
      list_dvs(month, year);
    }) 

    function list_dvs(month, year){  
      var dv_table = $('#dv_table').DataTable({
        info: false,
        iDisplayLength: 20,
        order: [[0, 'desc']],
        ajax: {
          url: "{{ route('show_all_dvs') }}",
          method: "GET",
          data : {
            '_token': '{{ csrf_token() }}',
            'fund_id' : $('#fund_id').val(),
            'month' : month,
            'year' : year,
            'attach_dv_lddap' : 1,
          }      
        },
        columns: [
          {data: 'dv_id', title: 'DV ID', width: '7%', className: 'dt-center'},   
          {data: 'dv_date1', title: 'DV Date', width: '9%', className: 'dt-center'},   
          {data: 'dv_no', title: 'DV No.', width: '6%', className: 'dt-center'},
          {data: 'payee', title: 'Payee', width: '25%', className: 'dt-head-center'},
          {data: 'particulars', title: 'Particulars', width: '35%', className: 'dt-head-center'},
          {data: 'total_dv_net_amount', title: 'DV Net Amount', width: '10%', className: 'dt-head-center dt-body-right',
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
        url: "{{ route('lddap.update') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'lddap_id' : $('#lddap_id').val(),
          'dv_id' : dv_id,
          'attach_update_dv' : 1,
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
  {{-- attach dv end --}}
  
  {{-- edit start --}}
    $('#attached_dv_table').on('click', '.btn_remove_attached_dv', function(e){
      var id = $(this).data('id');
      var dv_id = $(this).data('dv-id');
      var lddap_id = $(this).data('lddap-id');
      Swal.fire({
        title: 'Are you sure you want to remove attached voucher?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      })
      .then((result) => {
        if (result.value) {
        $.ajax({
            method: "PATCH",
            url: "{{ route('lddap.delete') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'id' : id,
              'dv_id' : dv_id,
              'lddap_id' : lddap_id,
              'remove_attached_dv' : 1,
            },
            success: function(data) {      
              Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Attached voucher has been successfully removed.',
              showConfirmButton: false,
              timer: 1500
              }) 
              window.location.reload();
            }             
        })    
        }       
      })
    })

    $('.edit_lddap').on('click', function(e){     
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
            url: "{{ route('lddap.update') }}",
            data:  $('#lddap_form').serialize() + "&edit_lddap=1",
            success:function(data) {
              console.log(data);
              if(data.errors) {    
                if(data.errors.lddap_date){
                  $('#lddap_date').addClass('is-invalid');
                  $('#date-error').html(data.errors.lddap_date[0]);
                }      
                if(data.errors.fund_id ){
                  $('#fund_id').addClass('is-invalid');
                  $('#fund-error').html(data.errors.fund_id[0]);
                } 
                if(data.errors.bank_account_id ){
                  $('#bank_account_id').addClass('is-invalid');
                  $('#bank-account-id-error').html(data.errors.bank_account_id[0]);
                }            
              }            
              if(data.success) {    
                Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: 'LDDAP has been successfully updated.',
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

  {{-- replace payee bank account no start --}}  
      $('.btn_replace_payee_bank_account_no').on('click', function(e){  
        var payee_parent_id = $(this).data('payee-id');
        var dv_id = $(this).data('dv-id');
        $('#payee_modal').modal('toggle');
        list_payee_bank(payee_parent_id, dv_id);
      }) 

      function list_payee_bank(payee_parent_id, dv_id){ 
        var payee_table = $('#payee_table').DataTable({
          info: false,
          iDisplayLength: 20,
          ajax: {
            url: "{{ route('show_bank_accounts_by_payee') }}",
            method: "GET",
            data : {
              '_token': '{{ csrf_token() }}',
              'payee_parent_id' : payee_parent_id,
            }      
          },
          columns: [
            {data: 'payee', title: 'Payee', width: '3%', className: 'dt-head-center'},   
            {data: 'bank', title: 'Bank', width: '9%', className: 'dt-center'},   
            {data: 'bank_account_no', title: 'Bank Account No.', width: '9%', className: 'dt-center'},   
          ]
        });
        $('#dv_id').val(dv_id);
      }

      $('#payee_table').on('click', '.replace_payee_bank_account_no', function(e){
        var payee_id = $(this).data('id');
        e.prevenDefault;  
        clear_attributes();      
        $.ajax({
          method: "PATCH",
          url: "{{ route('lddap.update') }}",
          data: {
            '_token': '{{ csrf_token() }}',
            'dv_id' : $('#dv_id').val(),
            'payee_id' : payee_id,
            'replace_payee_bank_account' : 1,
          },
          success:function(data) {
            console.log(data);
            if(data.success) {
              $('#payee_modal').modal('toggle')               
              window.location.reload();  
            }
          },
        });      
      }) 
  {{-- replace payee bank account no end --}}

  {{-- print start --}}
    $('.print_lddap').on('click', function(e){ 
      var lddap_id = $('#lddap_id').val();
      window.open("{{ url('/lddap/print_lddap') }}/" + lddap_id);
    }) 
    
    $('.print_lddap_ada_summary').on('click', function(e){ 
      var lddap_id = $('#lddap_id').val();
      window.open("{{ url('/lddap/print_lddap_ada_summary') }}/" + lddap_id);
    })
  {{-- print end --}}  

  {{-- delete start --}}
    $('#lddap_table').on('click', '.btn_delete', function(e){
      id = $(this).data('id')
      delete_lddap(id);
    })

    function delete_lddap(id){
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
            url: "{{ route('lddap.delete') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'id' : id,
              'delete_lddap' : 1,
            },
            success: function(data) {      
              Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'LDDAP has been successfully deleted.',
              showConfirmButton: false,
              timer: 1500
              }) 
              window.location.reload(); 
              {{-- $('#lddap_table').DataTable().ajax.reload();    --}}
            }             
        })    
        }       
      })
    }
  {{-- delete end --}} 

  {{-- generate_lddap_no start  --}}
    $('.generate_lddap_no').click(function(){
      lddap_id = $(this).data('lddap-id');
      mm = $("#lddap_date").datepicker('getDate').getMonth() + 1; 
      var month = ( mm < 10 ) ? ( "0" + ( mm ).toString() ) : ( mm ).toString();
      var year = $("#lddap_date").datepicker('getDate').getFullYear();   
      var fund_id = $('#fund_id').val();
      var payment_mode_id = $('#payment_mode_id').val();
      $.ajax({
        method: "PATCH",
        url: "{{ route('generate_lddap_no') }}",
        data: {
          '_token': '{{ csrf_token() }}',         
          'lddap_id' : lddap_id,
          'fund_id' : fund_id,
          'payment_mode_id' : payment_mode_id,
          'month' : month,
          'year' : year,
        },
        success:function(data) {
          console.log(data);
          if(data.success) {                    
            window.location.reload();    
            {{-- $('#lddap_no').val(data.lddap_no);  --}}
          }
        },
      });
    });

    $('.generate_lddap_no_add').click(function(){ 
      mm = $("#lddap_date").datepicker('getDate').getMonth() + 1; 
      var month = ( mm < 10 ) ? ( "0" + ( mm ).toString() ) : ( mm ).toString();
      var year = $("#lddap_date").datepicker('getDate').getFullYear();   
      var fund_id = $('#fund_id').val();
      var payment_mode_id = $('#payment_mode_id').val();
      if(fund_id==''){
        alert('Please select fund first to generate LDDAP No.')
      }      
      $.ajax({
        method: "PATCH",
        url: "{{ route('generate_lddap_no') }}",
        {{-- data:  $('#lddap_form').serialize() + "&add_lddap=1", --}}
        data: {
          '_token': '{{ csrf_token() }}',  
          'fund_id' : fund_id,
          'payment_mode_id' : payment_mode_id,
          'month' : month,
          'year' : year,          
          'lddap_date' : $("#lddap_date").val(),          
          'add_lddap' : 1,          
        },
        success:function(data) {
          console.log(data);
          if(data.success) {        
            window.location.replace(data.redirect_url);           
          }
        },
      });
    });
  {{-- generate_lddap_no end  --}}
  
{{-- END --}}