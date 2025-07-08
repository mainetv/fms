function updateChartRowAndSummary(triggerRow) {
  const chartRow = triggerRow.closest('.chart-accounts-row');
  const rsId = chartRow.data('dv-rs-id');
  const summaryRow = $(`.summary-row[data-dv-rs-id="${rsId}"]`);
  const grossInput = summaryRow.find('input[name^="gross_amount["]');
  const grossAmount = parseFloat(grossInput.val()?.replace(/,/g, '') || 0);

  const taxFields = [
    'tax_one', 'tax_two', 'tax_twob',
    'tax_three', 'tax_five', 'tax_six',
    'wtax', 'other_tax'
  ];

  let totalTax = 0;
  taxFields.forEach((field) => {
    $(`input[name^="${field}[${rsId}]"]`).each(function () {
      totalTax += parseFloat($(this).val().replace(/,/g, '')) || 0;
    });
  });


  const netAmount = grossAmount - totalTax;

  // Update summary
  summaryRow.find('.all_deductions_display').text(totalTax.toLocaleString(undefined, { minimumFractionDigits: 2 }));
  summaryRow.find('.all_deductions_input').val(totalTax.toFixed(2));
  summaryRow.find('.net_amount_display').text(netAmount.toLocaleString(undefined, { minimumFractionDigits: 2 }));
  summaryRow.find(`input[name="net_amount[${rsId}]"]`).val(netAmount.toFixed(2));

  // Loop all chart rows (update MDS + BIR if matched)
  $(`.chart-accounts-row[data-dv-rs-id="${rsId}"]`).each(function () {
    const row = $(this);
    const accountTitle = row.find('input.account-title').val()?.toLowerCase() || '';
    const isMDS = accountTitle.includes('mds');
    const isBIR = accountTitle.includes('bir');

    if (isMDS) {
      // ✅ MDS: match netAmount
      row.find('input.chart-amount-hidden[data-mds="1"]').val(netAmount.toFixed(2));
      row.find('span.chart-amount-display').text(netAmount.toLocaleString(undefined, { minimumFractionDigits: 2 }));
    }

    if (isBIR) {
      let birAmount = 0;
      taxFields.forEach((field) => {
        row.find(`input[name^="${field}[${rsId}]"]`).each(function () {
          birAmount += parseFloat($(this).val().replace(/,/g, '')) || 0;
        });
      });

      const inputAmount = row.find('input.chart-amount-hidden');
      const spanAmount = row.find('span.chart-amount-display');

      inputAmount.val(birAmount.toFixed(2));
      spanAmount.text(birAmount.toLocaleString(undefined, { minimumFractionDigits: 2 }));
    }

  });
  updateTotalDvNetAmount();
}

// ✅ When any tax input changes
$(document).on('input', 'input.tax', function () {
  updateChartRowAndSummary($(this).closest('tr'));

  const value = $(this).val().replace(/,/g, '');
  $(this).val(value); // Optional: remove commas live
});

// ✅ When gross amount changes
$(document).on('input', 'input[name^="gross_amount["]', function () {
  const rsId = $(this).closest('.summary-row').data('dv-rs-id');
  const firstRow = $(`.chart-accounts-row[data-dv-rs-id="${rsId}"]`).first();
  updateChartRowAndSummary(firstRow);
});

function updateTotalDvNetAmount() {
  let totalNet = 0;

  $('input.net_amount_input').each(function () {
    const val = parseFloat($(this).val()?.replace(/,/g, '') || 0);
    totalNet += val;
  });

  $('#total_dv_net_amount').text(totalNet.toLocaleString(undefined, { minimumFractionDigits: 2 }));
}

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

  {{-- add dv chart account start --}}
    let current_dv_rs_net_id = null;

    const scrollContainer = $('#chart-scroll-container');
    const backToTopBtn = $('#btn-back-to-top');

    // Show button when scrolling down
    scrollContainer.on('scroll', function () {
      if ($(this).scrollTop() > 100) {
        backToTopBtn.fadeIn();
      } else {
        backToTopBtn.fadeOut();
      }
    });

    // Scroll to top on click
    backToTopBtn.on('click', function () {
      scrollContainer.animate({ scrollTop: 0 }, 300);
    });

    $('#reset_filters').on('click', function(e) {
      e.preventDefault(); // 👈 Prevents form submission or page reload

      $('#filter_level_min').val('');
      $('#filter_level_max').val('');
      $('#filter_uacs').val('');
      tbl_chart_accounts.draw(); // 👈 Redraw table with cleared filters
    });

    $('#chart-scroll-container').on('scroll', function () {
      let visibleRows = $('#tbl_chart_accounts tbody tr:visible');
      let firstVisible = visibleRows.first();

      if (!firstVisible.length) return;

      let currentLevel = parseInt(firstVisible.data('level'));
      if (currentLevel <= 4) {
        $('#sticky-preview').hide();
        return;
      }

      // Build stack of parent titles
      let previewHtml = '';
      let currentRow = firstVisible;

      while (parseInt(currentRow.data('level')) > 1) {
        let parentId = currentRow.data('parent-id');
        if (!parentId) break;

        currentRow = $('#tbl_chart_accounts tbody tr[data-id="' + parentId + '"]');
        if (!currentRow.length) break;

        let name = currentRow.find('span').text();
        let css = currentRow.find('span').attr('class') || '';

        previewHtml = `<div class="${css}">${name}</div>` + previewHtml;
      }

      $('#sticky-preview').html(previewHtml).show();
    });


    $('.btn_add_dv_chart_account').on('click', function(e){  
       $(this).tooltip('hide');

      current_dv_rs_net_id = $(this).data('dv-rs-id');
      $('#chart_account_modal').modal('toggle');
      list_chart_accounts(current_dv_rs_net_id);
    }) 

    function list_chart_accounts(current_dv_rs_net_id){ 
      if ($.fn.DataTable.isDataTable('#tbl_chart_accounts')) {
        $('#tbl_chart_accounts').DataTable().clear().destroy();
      }
      var tbl_chart_accounts = $('#tbl_chart_accounts').DataTable({
        info: false,
        scrollY: '60vh',
        scrollCollapse: true,
        paging: false,
        order: [[2, 'asc']],
        scrollX: true,
        ajax: {
          url: "{{ route('show_chart_accounts') }}",
          method: "GET",
          data : {
            '_token': '{{ csrf_token() }}',
            'dv_rs_net_id' : current_dv_rs_net_id,
          }      
        },
        columns: [
          {
            data: 'level_id',
            visible: false,
            searchable: true
          },
          {
            data: 'title',
            title: 'Account Title',
            width: '80%',
            className: 'dt-left dt-head-center',
            render: function(data, type, row) {
              return `<span class="${row.css_class}" data-level="${row.level_id}" data-parent-id="${row.parent_id}" data-id="${row.id}">${data}</span>`;
            }
          },
          {data: 'uacs', title: 'UACS', width: '10%', className: 'dt-center'},
          {data: 'subobject_code', title: 'Sub-Object Code', width: '10%', className: 'dt-center'},
        ],
        rowCallback: function(row, data) {
          $(row).attr('data-id', data.id);
          $(row).attr('data-parent-id', data.parent_id);
          $(row).attr('data-level', data.level_id);
        }
      });

      $.fn.dataTable.ext.search.push(function(settings, data, dataIndex, rowData) {
        const levelMin = parseInt($('#filter_level_min').val()) || 0;
        const levelMax = parseInt($('#filter_level_max').val()) || 99;
        const level = parseInt(rowData.level_id);

        const uacsSearch = $('#filter_uacs').val().toLowerCase();
        const uacs = (rowData.uacs || '').toLowerCase();

        const levelMatch = (level >= levelMin && level <= levelMax);
        const uacsMatch = !uacsSearch || uacs.includes(uacsSearch);

        return levelMatch && uacsMatch;
      });


      $('#filter_level_min, #filter_level_max, #filter_uacs').on('change keyup', function() {
        tbl_chart_accounts.draw(); // Redraw with new filters
      });

      $('#reset_filters').on('click', function() {
        $('#filter_level_min').val('');
        $('#filter_level_max').val('');
        $('#filter_uacs').val('');
        tbl_chart_accounts.draw();
      });
    }

    $('#tbl_chart_accounts').on('click', '.add_dv_chart_account', function(e){
      e.preventDefault();
      var accountId = $(this).data('id');
      $.ajax({
        method: "POST",
        url: "{{ route('dv.store') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'dv_rs_net_id' : current_dv_rs_net_id,
          'accountId' : accountId,
          'add_dv_account' : 1,
        },
        success:function(data) {
          if(data.success) {            
            $('#chart_account_modal').modal('toggle');
    
            const rsId = current_dv_rs_net_id;
            $(`.chart-accounts-row[data-dv-rs-id="${rsId}"] table tbody.chart-body-${rsId}`).html(data.html);

          }
        },
      });      
    }) 

    $(document).on('click', '#tbl_dv_chart_accounts .btn_delete_dv_chart_account', function(e) {
      e.preventDefault();
       const button = $(this); 
      const id = $(this).data('id');
      delete_dv_chart_account(id, button); 
    });

    function delete_dv_chart_account(id, button){
      Swal.fire({
        title: 'Are you sure you want to delete this DV chart of account?',
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
                'delete_dv_account' : 1,
              },
              success: function(data) {      
                button.tooltip('hide');
                
                // 🔥 Remove the specific row where the button was clicked
                button.closest('tr').remove();

                // 💡 Optionally update net amount again after deletion
                const rsId = button.closest('.chart-accounts-row').data('dv-rs-id');
                const firstRow = $(`.chart-accounts-row[data-dv-rs-id="${rsId}"]`).first();
                updateChartRowAndSummary(firstRow);

                Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: 'DV chart of account has been successfully deleted.',
                  showConfirmButton: false,
                  timer: 1500
                })                 
              }             
          })    
        }       
      })
    }
 {{-- add dv chart account end --}} 

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
       const formData = $('#dv_form').serializeArray();
       console.table(formData); 
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
    {{-- $('#attached_rs_net_table').on('click', '.btn_compute', function(e){
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
    }) --}}
  {{-- compute net amount end  --}}
{{-- END --}}