
{{-- START --}}
  {{-- modal start --}}
    $("#obligation_modal").on("hidden.bs.modal", function(){ 
      $('#obligations_by_allotment_table').dataTable().fnDestroy();
    });     
  {{-- modal end --}}

  {{-- view obligations start --}}
    $('.btn_obligation').on('click', function(e){
      id = $(this).data('id')
      $(".modal-body #allotment_id").val(id);
      
      $.getJSON( '{{ url('programming_allocation/allotment/show') }}/'+id, function( data ) {
        $('#pap_activity').val(data['allotment']['pap_activity']).change()   
        $('#expenditure').val(data['allotment']['object_expenditure']).change()   
      })
      .done(function(data) {                  
      })
      .fail(function() {
      });  

      obligations_by_allotment_table = $('#obligations_by_allotment_table').DataTable({
        paging : false,
        info: false,
        searching: false,
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('show_obligations_by_allotment_id') }}",
          method: "GET",
          data : {
            '_token': '{{ csrf_token() }}',
            'allotment_id' : $('#allotment_id').val(),
          }      
        },
        columns: [
          {data: 'allotment_division_acronym', title: 'Responsibility Center', width: '5%', className: 'dt-center'},   
          {{-- {data: 'allotment_division_acronym', title: 'Charged to', width: '5%', className: 'dt-center'},    --}}
          {data: 'rs_date', title: 'RS Date', width: '6%', className: 'dt-center'},   
          {data: 'rs_no', title: 'RS No.', width: '10%', className: 'dt-center'},
          {data: 'payee', title: 'Payee', width: '25%', className: 'dt-head-center dt-body-left'},
          {data: 'particulars', title: 'Particulars', width: '44%', className: 'dt-head-center dt-body-left'},
          {data: 'rs_amount', title: 'Amount', width: '10%', className: 'dt-head-center dt-body-right',
            render: $.fn.dataTable.render.number(',', '.', 2, '')
          },
        ]
      });
      
      $('#obligation_modal').modal('toggle');  
    })    

    {{-- $("#obligation_modal").on("hidden.bs.modal", function(){ 
      $('#adjustment_container').collapse('hide');  
      $('#allotment_adjustment_table').dataTable().fnDestroy();
      $('#adjustment_table').dataTable().fnDestroy();
    });      

    $('.hide_adjustment_container').on('click', function(e){
      $('#adjustment_container').collapse('hide'); 

      $('.edit_adjustment.save-buttons')
        .removeClass('d-inline')
        .addClass('d-none')
        .attr('disabled', true);
    }); --}}
  {{-- view obligations end --}}

  {{-- print start --}}
    $('.print').on('click', function(e){ 
      var rstype_id = $('#rstype_id_selected').val();
      var division_id = $('#division_id').val();
      var year = $('#year_selected').val();
      var view = $('#view_selected').val();
      window.open("{{ url('/reports/print_saob/') }}/" + rstype_id + "/" + division_id + "/" + year + "/" + view);
    }) 
    
    {{-- $('.print_lddap_ada_summary').on('click', function(e){ 
      var lddap_id = $('#lddap_id').val();
      window.open("{{ url('/lddap/print_lddap_ada_summary') }}/" + lddap_id);
    }) --}}
  {{-- print end --}}  
{{-- END --}}