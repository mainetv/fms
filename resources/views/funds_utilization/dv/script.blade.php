
{{-- START --}}
  {{-- modal start --}}
    $('#dv_modal').on('hide.bs.modal', function(){
      init_view_dv();
      clear_attributes();
      clearFields  
    });    

    $('#dv_modal').on('shown.bs.modal', function () {
      $('#dv_date').focus();
    })  

    $("#attach_rs_modal").on("hidden.bs.modal", function(){ 
      $('#rs_by_payee_table').DataTable().destroy();      
    });
  {{-- modal end --}}

  {{-- view start --}}   
    function init_view_dv(){
      $('.dv-field')
        .val('')
        .attr('disabled', true);

      $('.save-buttons')
        .removeClass('d-inline')
        .addClass('d-none')
        .attr('disabled', true);
    }

    {{-- $('.btn_view').on('click', function(e){
      $('#dv_modal_header').html("View DV");        
      id = $(this).data('id')
      $.getJSON( '{{ url('funds_utilization/dv/show_dv') }}/'+id, function( data ) {
      })
      .done(function(data) {    
        $('#fund_id').val(data['dv']['fund_id']).change()
      })
      .fail(function() {
      });        
      $('#dv_modal').modal('toggle')            
    }) --}}
  {{-- view end --}}

  {{-- add start --}}
    $('.add_dv').on('click', function(e){  
      e.prevenDefault;         
      clear_attributes();                   
      $.ajax({
        method: "POST",
        url: "{{ route('dv.store') }}",
        data:  $('#dv_form').serialize() + "&add_dv=1",
        success:function(data) {
          console.log(data);
          if(data.errors) {    
            if(data.errors.dv_date){
              $('#dv_date').addClass('is-invalid');
              $('#date-error').html(data.errors.dv_date[0]);
            }      
            if(data.errors.fund_id ){
              $('#fund_id').addClass('is-invalid');
              $('#fund-error').html(data.errors.fund_id[0]);
            } 
            if(data.errors.payee_id ){
              $('#payee_id').addClass('is-invalid');
              $('#payee-error').html(data.errors.payee_id[0]);
            }             
          }
          if(data.success) { 
            window.location.replace(data.redirect_url);               
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Disbursement voucher has been successfully added.',
              showConfirmButton: false,
              timer: 1500
            })   
          }
        },        
      });      
    })     
  {{-- add end    --}}

  {{-- attach rs start --}}      
    function list_rs_by_payee(){  
        var rs_by_payee_table = $('#rs_by_payee_table').DataTable({
        info: false,
        iDisplayLength: 20,
        order: [[0, 'desc']],
        ajax: {
          url: "{{ route('show_rs_by_payee') }}",
          method: "GET",
          data : {
            '_token': '{{ csrf_token() }}',
            'payee_id' : $('#payee_id').val(),
            'parent_id' : $('#parent_id').val(),
            'division_id' : $('#division_id').val(),
            'fund_id' : $('#fund_id').val(),
            'attach_rs' : 1,
          }      
        },
        columns: [
          {data: 'rs_id', title: 'ID', width: '3%', className: 'dt-center'},   
          {data: 'rs_date', title: 'Date', width: '9%', className: 'dt-center'},   
          {data: 'rs_no', title: 'No.', width: '10%', className: 'dt-center'},
          {data: 'particulars', title: 'Particulars', width: '20%', className: 'dt-head-center'},
          {data: 'total_rs_activity_amount', title: 'Obligated Amount', width: '10%', className: 'dt-head-center dt-body-right',
            render: $.fn.dataTable.render.number(',', '.', 2, '')
          },
          {{-- {data: 'balance', title: 'Current Balance', width: '10%', className: 'dt-head-center dt-body-right', 
            render: $.fn.dataTable.render.number(',', '.', 3, '')
          },           --}}
        ]
      });
    }

    $('.btn_attach_rs').on('click', function(e){  
      $('#attach_rs_modal').modal('toggle');
      list_rs_by_payee();
    }) 

    $('#rs_by_payee_table').on('click', '.attach_rs', function(e){
      var rs_id = $(this).data('rs-id');
      e.prevenDefault;  
      clear_attributes();      
      $.ajax({
        method: "POST",
        url: "{{ route('dv.store') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'dv_id' : $('#dv_id').val(),
          'dv_date' : $('#dv_date').val(),
          'fund_id' : $('#fund_id').val(),
          'payee_id' : $('#payee_id').val(),
          'rs_id' : rs_id,
          'attach_rs' : 1,
        },
        success:function(data) {
          console.log(data);
          if(data.success) {            
            $('#attach_rs_modal').modal('toggle')            
            window.location.reload();            
          }
        },
      });      
    }) 

    function list_rs_by_payee_edit(dv_rs_id){  
      var rs_by_payee_table = $('#rs_by_payee_table').DataTable({
        info: false,
        iDisplayLength: 20,
        ajax: {
          url: "{{ route('show_rs_by_payee') }}",
          method: "GET",
          data : {
            '_token': '{{ csrf_token() }}',
            'payee_id' : $('#payee_id').val(),
            'division_id' : $('#division_id').val(),
            'fund_id' : $('#fund_id').val(),
            'edit_attached_rs' : 1,
          }      
        },
        columns: [
          {data: 'rs_id', title: 'ID', width: '3%', className: 'dt-center'},   
          {data: 'rs_date', title: 'Date', width: '9%', className: 'dt-center'},   
          {data: 'rs_no', title: 'No.', width: '10%', className: 'dt-center'},
          {data: 'particulars', title: 'Particulars', width: '20%', className: 'dt-head-center'},
          {data: 'total_rs_activity_amount', title: 'Obligated Amount', width: '10%', className: 'dt-head-center dt-body-right',
            render: $.fn.dataTable.render.number(',', '.', 3, '')
          },
          {{-- {data: 'balance', title: 'Current Balance', width: '10%', className: 'dt-head-center dt-body-right', 
            render: $.fn.dataTable.render.number(',', '.', 3, '')
          },           --}}
        ]
      });
      $('#dv_rs_id_edit').val(dv_rs_id);
    }

    $('.btn_edit_attached_rs').on('click', function(e){  
      var dv_rs_id = $(this).data('dv-rs-id');
      $('#attach_rs_modal').modal('toggle');
      list_rs_by_payee_edit(dv_rs_id);
    }) 

    $('#rs_by_payee_table').on('click', '.edit_attached_rs', function(e){
      var rs_id = $(this).data('rs-id');
      e.prevenDefault;  
      clear_attributes();      
      $.ajax({
        method: "PATCH",
        url: "{{ route('dv.update') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'dv_id' : $('#dv_id').val(),
          'rs_id' : rs_id,
          'dv_rs_id' : $('#dv_rs_id_edit').val(),
          'edit_attached_rs' : 1,
        },
        success:function(data) {
          console.log(data);
          if(data.success) {
            $('#attach_rs_modal').modal('toggle')               
            window.location.reload();
          }
        },
      });
    }) 
  {{-- attach rs end --}}
  
  {{-- attach rs net start --}}      
    function list_rs_by_dv(){  
      var rs_by_payee_table = $('#rs_by_payee_table').DataTable({
      info: false,
      iDisplayLength: 20,
      order: [[0, 'desc']],
      ajax: {
        url: "{{ route('show_rs_by_dv') }}",
        method: "GET",
        data : {
          '_token': '{{ csrf_token() }}',
          'dv_id' : $('#dv_id').val(),
          'attach_rs_net' : 1,
        }      
      },
      columns: [
        {data: 'rs_id', title: 'ID', width: '3%', className: 'dt-center'},   
        {data: 'rs_date', title: 'Date', width: '9%', className: 'dt-center'},   
        {data: 'rs_no', title: 'No.', width: '10%', className: 'dt-center'},
        {data: 'particulars', title: 'Particulars', width: '20%', className: 'dt-head-center'},
        {data: 'total_rs_activity_amount', title: 'Obligated Amount', width: '10%', className: 'dt-head-center dt-body-right',
          render: $.fn.dataTable.render.number(',', '.', 2, '')
        },
      ]
      });
    }

    $('.btn_attach_rs_net').on('click', function(e){  
      $('#attach_rs_modal').modal('toggle');
      list_rs_by_dv();
    }) 

    $('#rs_by_payee_table').on('click', '.attach_rs_net', function(e){
      var rs_id = $(this).data('rs-id');
      e.prevenDefault;  
      clear_attributes();      
      $.ajax({
        method: "POST",
        url: "{{ route('dv.store') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'dv_id' : $('#dv_id').val(),
          'total_dv_gross_amount' : $('#total_dv_gross_amount').val(),
          'rs_id' : rs_id,
          'attach_rs_net' : 1,
        },
        success:function(data) {
          console.log(data);
          if(data.success) {
            window.location.reload();   
            $('#attach_rs_modal').modal('toggle')    
          }
        },
      });      
    }) 

    function list_rs_by_dv_edit(dv_rs_id){  
      var rs_by_payee_table = $('#rs_by_payee_table').DataTable({
        info: false,
        iDisplayLength: 20,
        ajax: {
          url: "{{ route('show_rs_by_dv') }}",
          method: "GET",
          data : {
            '_token': '{{ csrf_token() }}',
            'dv_id' : $('#dv_id').val(),
            'edit_attached_rs_net' : 1,
          }      
        },
        columns: [
          {data: 'rs_id', title: 'ID', width: '3%', className: 'dt-center'},   
          {data: 'rs_date', title: 'Date', width: '9%', className: 'dt-center'},   
          {data: 'rs_no', title: 'No.', width: '10%', className: 'dt-center'},
          {data: 'particulars', title: 'Particulars', width: '20%', className: 'dt-head-center'},
          {data: 'total_rs_activity_amount', title: 'Obligated Amount', width: '10%', className: 'dt-head-center dt-body-right',
            render: $.fn.dataTable.render.number(',', '.', 3, '')
          },
          {{-- {data: 'balance', title: 'Current Balance', width: '10%', className: 'dt-head-center dt-body-right', 
            render: $.fn.dataTable.render.number(',', '.', 3, '')
          },           --}}
        ]
      });
      $('#dv_rs_id_edit').val(dv_rs_id);
    }

    $('.btn_edit_attached_rs_net').on('click', function(e){  
      var dv_rs_id = $(this).data('dv-rs-id');
      $('#attach_rs_modal').modal('toggle');
      list_rs_by_dv_edit(dv_rs_id);
    }) 

    $('#rs_by_payee_table').on('click', '.edit_attached_rs_net', function(e){
      var rs_id = $(this).data('rs-id');
      e.prevenDefault;  
      clear_attributes();      
      $.ajax({
        method: "PATCH",
        url: "{{ route('dv.update') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'dv_id' : $('#dv_id').val(),
          'rs_id' : rs_id,
          'dv_rs_id' : $('#dv_rs_id_edit').val(),
          'edit_attached_rs_net' : 1,
        },
        success:function(data) {
          console.log(data);
          if(data.success) {
            $('#attach_rs_modal').modal('toggle')               
            window.location.reload();
          }
        },
      });
    }) 
  {{-- attach rs net end --}}

  {{-- edit start --}}
    $('#attached_rs_table').on('click', '.btn_remove_attached_rs', function(e){
      var id = $(this).data('id');
      var dv_id = $(this).data('dv-id');
      var rs_id = $(this).data('rs-id');
      Swal.fire({
        title: 'Are you sure you want to remove attached request and status?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      })
      .then((result) => {
        if (result.value) {
        $.ajax({
            method: "PATCH",
            url: "{{ route('dv.delete') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'id' : id,
              'dv_id' : dv_id,
              'rs_id' : rs_id,
              'remove_attached_rs' : 1,
            },
            success: function(data) {      
              Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Attached request and status has been successfully removed.',
              showConfirmButton: false,
              timer: 1500
              }) 
              window.location.reload();
            }             
        })    
        }       
      })
    })

    $('#attached_rs_net_table').on('click', '.btn_remove_attached_rs_net', function(e){
      var id = $(this).data('id');
      var dv_id = $(this).data('dv-id');
      var lddap_id = $(this).data('lddap-id');
      Swal.fire({
        title: 'Are you sure you want to remove attached request and status?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      })
      .then((result) => {
        if (result.value) {
        $.ajax({
            method: "PATCH",
            url: "{{ route('dv.delete') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'id' : id,
              'dv_id' : dv_id,
              'lddap_id' : lddap_id,
              'remove_attached_rs_net' : 1,
            },
            success: function(data) {      
              Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Attached request and status has been successfully removed.',
              showConfirmButton: false,
              timer: 1500
              }) 
              window.location.reload();
            }             
        })    
        }       
      })
    })

    $('.edit_dv').on('click', function(e){     
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
            url: "{{ route('dv.update') }}",
            data:  $('#dv_form').serialize() + "&edit_dv=1",
            success:function(data) {
              console.log(data);
              if(data.errors) {    
                if(data.errors.dv_date){
                  $('#dv_date').addClass('is-invalid');
                  $('#date-error').html(data.errors.dv_date[0]);
                }      
                if(data.errors.fund_id){
                  $('#fund_id').addClass('is-invalid');
                  $('#fund-error').html(data.errors.fund_id[0]);
                } 
                if(data.errors.payee_id){
                  $('#payee_id').addClass('is-invalid');
                  $('#payee-error').html(data.errors.payee_id[0]);
                }             
              }              
              if(data.success) {    
                Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: 'DV has been successfully updated.',
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
    
    $('.update_dv').on('click', function(e){     
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
            url: "{{ route('dv.update') }}",
            data:  $('#dv_form').serialize() + "&update_dv=1",
            success:function(data) {
              console.log(data);
              if(data.errors) {    
                if(data.errors.dv_date){
                  $('#dv_date').addClass('is-invalid');
                  $('#date-error').html(data.errors.dv_date[0]);
                }             
              }              
              if(data.success) {    
                Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: 'DV has been successfully updated.',
                  showConfirmButton: false,
                  timer: 1500
                })   
                $('#attached_rs_table').html(data);
              }                      
            }                             
          });                                
        }       
      })            
    }) 
  {{-- edit end --}}

  {{-- print start --}}
    $('.print_dv').on('click', function(e){ 
      var dv_id = $('#dv_id').val();
      window.open("{{ url('/disbursement_voucher/print_dv') }}/" + dv_id);
    })      
  {{-- print end --}}  

  {{-- delete start --}}
    $('#dv_table').on('click', '.btn_delete', function(e){
      id = $(this).data('id')
      delete_dv(id);      
    })

    function delete_dv(id){
      Swal.fire({
        title: 'Are you sure you want to delete DV?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      })
      .then((result) => {
        if (result.value) {
          $.ajax({
              method: "PATCH",
              url: "{{ route('dv.delete') }}",
              data: {
                '_token': '{{ csrf_token() }}',
                'id' : id,
                'delete_dv' : 1,
              },
              success: function(data) {      
                Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: 'DV has been successfully deleted.',
                  showConfirmButton: false,
                  timer: 1500
                }) 
                $('#dv_table').DataTable().ajax.reload();
              }             
          })    
        }       
      })
    }
  {{-- delete end --}} 

  {{-- generate_dv_no start  --}}
    $('.generate_dv_no').click(function(){
      dv_id = $(this).data('dv-id');
      year = $(this).data('year');
      $.ajax({
        method: "PATCH",
        url: "{{ route('generate_dv_no') }}",
        data: {
          '_token': '{{ csrf_token() }}',         
          'dv_id' : dv_id,
          'year' : year,
          'module_id' : 6,
          'division_id' : $('#division_id').val(),
        },
        success:function(data) {
          console.log(data);
          if(data.success) {                    
            window.location.reload();    
          }
        },
      });
      {{-- $('#rs_no').val('2023'); --}}
      {{-- alert(rs_year);     --}}
    });
  {{-- generate_dv_no end  --}}

  {{-- compute net amount start  --}}  
    $('#attached_rs_net_table').on('click', '.btn_compute', function(e){
      var id = $(this).data('dv-rs-id');
      var total_tax = 0;
      var gross_amount = 0;
      var net_amount = 0;
      $(".tax").each(function(){
        tax = $(this).val();
        tax=tax.replaceAll(',', '');
        total_tax += +tax;
      });
      var gross_amount = $('#gross_amount').val();
      gross_amount = gross_amount.replaceAll(',', '');
      var net_amount = (gross_amount - total_tax);  
      net_amount=net_amount.toFixed(2); 
      $('#net_amount').val(net_amount);
    })
  {{-- compute net amount end  --}}
{{-- END --}}