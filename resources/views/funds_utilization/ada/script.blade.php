
{{-- START --}}
  {{-- modal start --}}
    $("#attach_lddap_modal").on("hidden.bs.modal", function(){ 
      $('#lddap_table').DataTable().destroy();      
    });
  {{-- modal end --}}

  {{-- add start --}}
    $('.add_ada').on('click', function(e){  
      e.prevenDefault;         
      clear_attributes();                   
      $.ajax({
        method: "POST",
        url: "{{ route('ada.store') }}",
        data:  $('#ada_form').serialize() + "&add_ada=1",
        success:function(data) {
          console.log(data);
          if(data.errors) {    
            if(data.errors.ada_date){
              $('#ada_date').addClass('is-invalid');
              $('#date-error').html(data.errors.ada_date[0]);
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
            window.location.replace(data.redirect_url);               
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'ADA has been successfully added.',
              showConfirmButton: false,
              timer: 1500
            })   
          }
        },        
      });      
    })    
    
  {{-- add lddap to ada end    --}}

  {{-- attach lddap to ad start --}}      
    function list_lddap(ada_month, ada_year){  
      var lddap_table = $('#lddap_table').DataTable({
        info: false,
        iDisplayLength: 20,
        order: [[0, 'desc']],
        ajax: {
          url: "{{ route('show_lddap') }}",
          method: "GET",
          data : {
            '_token': '{{ csrf_token() }}',
            'fund_id' : $('#fund_id').val(),
            'ada_month' : ada_month,
            'ada_year' : ada_year,
            'attach_lddap' : 1,
          }      
        },
        columns: [
          {data: 'lddap_id', title: 'LDDAP ID', width: '10%', className: 'dt-center'},   
          {data: 'lddap_date', title: 'LDDAP Date', width: '15%', className: 'dt-center'},   
          {data: 'lddap_no', title: 'LDDAP No.', width: '20%', className: 'dt-center'},
          {data: 'nca_no', title: 'NCA No.', width: '15%', className: 'dt-center'},
          {data: 'bank_account_no', title: 'Bank Account No.', width: '15%', className: 'dt-center'},
          {data: 'total_lddap_net_amount', title: 'Amount', width: '15%', className: 'dt-head-center dt-body-right',
            render: $.fn.dataTable.render.number(',', '.', 2, '')
          },
        ]
      });
    }

    $('.btn_attach_lddap').on('click', function(e){  
      $('#attach_lddap_modal').modal('toggle');
      var ada_month = $(this).data('ada-month');
      var ada_year = $(this).data('ada-year');
      list_lddap(ada_month, ada_year);
    }) 

    $('#lddap_table').on('click', '.attach_lddap', function(e){     
      var lddap_id = $(this).data('lddap-id');
      e.prevenDefault;  
      clear_attributes();      
      $.ajax({
        method: "PATCH",
        url: "{{ route('ada.update') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'ada_id' : $('#ada_id').val(),
          'lddap_id' : lddap_id,
          'attach_update_lddap' : 1,
        },
        success:function(data) {
          console.log(data);
          if(data.success) {
            $('#attach_lddap_modal').modal('toggle')               
            window.location.reload();  
          }
        },
      });      
    })     
  {{-- attach lddap to ada end --}}
  
  {{-- edit start --}}
    $('#attached_lddap_table').on('click', '.btn_remove_attached_lddap', function(e){
      var id = $(this).data('id');
      var lddap_id = $(this).data('lddap-id');
      var ada_id = $(this).data('ada-id');
      Swal.fire({
        title: 'Are you sure you want to remove attached LDDAP?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      })
      .then((result) => {
        if (result.value) {
        $.ajax({
            method: "PATCH",
            url: "{{ route('ada.delete') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'id' : id,
              'lddap_id' : lddap_id,
              'ada_id' : ada_id,
              'remove_attached_lddap' : 1,
            },
            success: function(data) {      
              Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Attached LDDAP has been successfully removed.',
              showConfirmButton: false,
              timer: 1500
              }) 
              window.location.reload();
            }             
        })    
        }       
      })
    })

    $('.edit_ada').on('click', function(e){     
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
            url: "{{ route('ada.update') }}",
            data:  $('#ada_form').serialize() + "&edit_ada=1",
            success:function(data) {
              console.log(data);
              if(data.errors) {    
                if(data.errors.ada_date){
                  $('#ada_date').addClass('is-invalid');
                  $('#date-error').html(data.errors.ada_date[0]);
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
                  title: 'ADA has been successfully updated.',
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

  {{-- print start --}}
    {{-- $('.print_lddap').on('click', function(e){ 
      var lddap_id = $('#lddap_id').val();
      window.open("{{ url('/ada/print_lddap') }}/" + lddap_id);
    })  --}}
    
    $('.print_lddap_ada_summary').on('click', function(e){ 
      var ada_id = $('#ada_id').val();
      window.open("{{ url('/ada/print_lddap_ada_summary') }}/" + ada_id);
    })
  {{-- print end --}}  

  {{-- delete start --}}
    $('#ada_table').on('click', '.btn_delete', function(e){
      id = $(this).data('id')
      delete_ada(id);
    })

    function delete_ada(id){
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
            url: "{{ route('ada.delete') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'id' : id,
              'delete_ada' : 1,
            },
            success: function(data) {      
              Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'ADA has been successfully deleted.',
              showConfirmButton: false,
              timer: 1500
              }) 
              $('#ada_table').DataTable().ajax.reload();
            }             
        })    
        }       
      })
    }
  {{-- delete end --}} 

  {{-- generate ada no start  --}}
    $('.generate_lddap_no').click(function(){
      ada_id = $(this).data('ada-id');
      year = $(this).data('year');
      fund_id = $(this).data('fund-id');
      prefix_code = $(this).data('prefix-code');
      $.ajax({
        method: "PATCH",
        url: "{{ route('generate_ada_no') }}",
        data: {
          '_token': '{{ csrf_token() }}',         
          'ada_id' : ada_id,
          'fund_id' : fund_id,
        },
        success:function(data) {
          console.log(data);
          if(data.success) {                    
            window.location.reload();    
          }
        },
      });
    });
  {{-- generate ada no end  --}}
  
{{-- END --}}