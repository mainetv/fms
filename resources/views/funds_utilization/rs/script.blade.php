
{{-- START --}}
  {{-- modal start --}}
    $("#attach_allotment_modal").on("hidden.bs.modal", function(){ 
      $('#all_allotment_table').DataTable().destroy();        
      $('#all_allotment_table').empty(); 
    });

    $("#particulars_template_modal").on("hidden.bs.modal", function(){ 
      $('#particulars_template_table').DataTable().destroy();        
      $('#particulars_template_table').empty(); 
    });
  {{-- modal end --}}

  {{-- view start --}}   
    function init_view_ors(){
      $('.rs-field')
        .val('')
        .attr('disabled', true);

      $('.save-buttons')
        .removeClass('d-inline')
        .addClass('d-none')
        .attr('disabled', true);
    }
    
    $('.btn_view').on('click', function(e){      
      $('#ors_modal_header').html("View ORS");        
      init_view_ors();
      id = $(this).data('id');
      show_rs(id);            
      show_attached_activities_by_rs(id);           
      $('#ors_modal').modal('toggle')                
    })

    $('#showall').on('click', function(e){ 
      if($("#showall").prop('checked') == true){
        $("#showall").val(1);
      }
      else{
        $("#showall").val(0);
      }  
    })

    $('#is_locked').on('click', function(e){ 
      if($("#is_locked").prop('checked') == true){
        $("#is_locked").val(1);
      }
      else{
        $("#is_locked").val(0);
      }  
    })
  {{-- view end --}}

  {{-- add start --}}   
    $('.add_rs').on('click', function(e){ 
      if($("#showall").prop('checked') == true){
        showall = 1;
      }
      else{
        showall = 0;
      }        
      e.prevenDefault;         
      clear_attributes();                   
      $.ajax({
        method: "POST",
        url: "{{ route('rs.store') }}",
        data:  $('#rs_form').serialize() + "&showall="+showall + "&add_rs=1",
        success:function(data) {
          console.log(data);
          if(data.errors) {    
            if(data.errors.rs_date){
              $('#rs_date').addClass('is-invalid');
              $('#date-error').html(data.errors.rs_date[0]);
            }      
            if(data.errors.fund_id ){
              $('#fund_id ').addClass('is-invalid');
              $('#fund-error').html(data.errors.fund_id[0]);
            } 
            if(data.errors.payee_id ){
              $('#payee_id ').addClass('is-invalid');
              $('#payee-error').html(data.errors.payee_id[0]);
            }             
          }
          if(data.success) { 
            window.location.replace(data.redirect_url);               
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Request and status has been successfully added.',
              showConfirmButton: false,
              timer: 1500
            })   
          }
        },        
      });      
    })
  {{-- add end --}}

  {{-- attach allotment activity start by budget --}}  
    $('.btn_attach_allotment_activity').on('click', function(e){  
      $('#attach_allotment_modal').modal('toggle')    
      list_all_allotment(rs_type_id);      
    }) 
      
    function list_all_allotment(){ 
      if($('#rs_type_id').val()==1) { 
        var groupColumn = 2;  
        var groupColumn1 = 3;  
        var all_allotment_table = $('#all_allotment_table').DataTable({
          info: false,
          orderCellsTop: true,
          iDisplayLength: 20,
          ajax: {
            url: "{{ route('show_all_allotment') }}",
            method: "GET",
            data : {
              '_token': '{{ csrf_token() }}',
              'division_id' : $('#division_id').val(),
              'division_acronym' : $('#division_acronym').val(),
              'year' : $('#year').val(),
              'rs_type_id' : $('#rs_type_id').val(),
              'attach_allotment' : 1,
            }     
          },    
          columns: [
            {data: 'division_acronym', title: 'Division', width: '3%', className:'dt-center'},   
            {data: null, defaultContent: '' , title: 'PAP', className:'dt-head-center', width: '10%', orderable: false,},
            {data: 'pap_all', title: 'PAP',  className:'dt-head-center'},
            {data: 'year_activity_subactivity', title: 'Activity', className:'dt-head-center'},
            {data: 'code_expenditure_specific', title: 'Activity - Sub-activity / Account Code', width: '50%', className:'dt-head-center'},
          ], 
          order: [[0, 'asc'], [2, 'asc'],[3, 'asc'],[4, 'asc']],
          columnDefs: [
            { visible: false, targets: groupColumn  },
            { visible: false, targets: groupColumn1  }
          ],
          drawCallback: function (settings) {
              var api = this.api();
              var rows = api.rows({ page: 'current' }).nodes();
              var last = null; 
              var last1 = null; 
              api
                .column(groupColumn, { page: 'current' })
                .data()
                .each(function (group, i) {
                  if (last !== group) {
                      $(rows)
                          .eq(i)
                          .before('<tr class="group"><td></td><td colspan="2" class="text-left font-weight-bold">' + group + '</td></tr>'); 
                      last = group;
                  }
              });

              api
                .column(groupColumn1, { page: 'current' })
                .data()
                .each(function (group1, i) {
                  if (last !== group1) {
                      $(rows)
                          .eq(i)
                          .before('<tr class="group1"><td colspan="2"></td><td class="text-left font-weight-bold">' + group1 + '</td></tr>'); 
                      last = group1;
                  }
              });
          },
          initComplete: function () {
            this.api().columns([0]).every(function () {
              var column = this;
              $(column.header()).append("<br>")
              var select = $('<select><option value=""></option></select>')
                .appendTo($(column.header()))
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );

                    column
                        .search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });
            column.data().unique().sort().each(function (d, j) {
                select.append('<option value="' + d + '" >' + d + '</option>')
              } );
            } );
          }
        });
      }
      else{
        var groupColumn = 2;  
        var groupColumn1 = 3;  
        var all_allotment_table = $('#all_allotment_table').DataTable({
          info: false,
          orderCellsTop: true,
          iDisplayLength: 20,
          ajax: {
            url: "{{ route('show_all_allotment') }}",
            method: "GET",
            data : {
              '_token': '{{ csrf_token() }}',
              'division_id' : $('#division_id').val(),
              'division_acronym' : $('#division_acronym').val(),
              'year' : $('#year').val(),
              'rs_type_id' : $('#rs_type_id').val(),
              'attach_allotment' : 1,
            }     
          },    
          columns: [
            {data: 'division_acronym', title: 'Division', width: '3%', className:'dt-center'},   
            {data: null, defaultContent: '' , title: 'PAP', className:'dt-head-center', width: '10%', orderable: false,},
            {data: 'pap_code', title: 'PAP',  className:'dt-head-center'},
            {data: 'year_activity_subactivity', title: 'Activity', className:'dt-head-center'},
            {data: 'expcode_expense_objcode_expenditure_specific', title: 'Activity - Sub-activity / Account Code', width: '50%', className:'dt-head-center'},
          ], 
          order: [[0, 'asc'], [2, 'asc'],[3, 'asc'],[4, 'asc']],
          columnDefs: [
            { visible: false, targets: groupColumn  },
            { visible: false, targets: groupColumn1  }
          ],
          drawCallback: function (settings) {
              var api = this.api();
              var rows = api.rows({ page: 'current' }).nodes();
              var last = null; 
              var last1 = null; 
              api
                .column(groupColumn, { page: 'current' })
                .data()
                .each(function (group, i) {
                  if (last !== group) {
                      $(rows)
                          .eq(i)
                          .before('<tr class="group"><td></td><td colspan="2" class="text-left font-weight-bold">' + group + '</td></tr>'); 
                      last = group;
                  }
              });

              api
                .column(groupColumn1, { page: 'current' })
                .data()
                .each(function (group1, i) {
                  if (last !== group1) {
                      $(rows)
                          .eq(i)
                          .before('<tr class="group1"><td colspan="2"></td><td class="text-left font-weight-bold">' + group1 + '</td></tr>'); 
                      last = group1;
                  }
              });
          },
          initComplete: function () {
            this.api().columns([0]).every(function () {
              var column = this;
              $(column.header()).append("<br>")
              var select = $('<select><option value=""></option></select>')
                .appendTo($(column.header()))
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );

                    column
                        .search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });
            column.data().unique().sort().each(function (d, j) {
                select.append('<option value="' + d + '" >' + d + '</option>')
              } );
            } );
          }
        });
      }
      $.ajax({
        method: "PATCH",   
        dataType: 'json',         
        url: "{{ route('rs.update') }}",
        data:  $('#rs_form').serialize() + "&update_rs=1",
        success:function(data) {
          console.log(data);
        }                             
      });
    }  

    $('#all_allotment_table').on('click', '.attach_allotment_activity', function(e){
      var allotment_id = $(this).data('allotment-id');
      var user_role_id = $('#user_role_id').val();
      e.prevenDefault;  
      clear_attributes();      
      $.ajax({
        method: "POST",
        url: "{{ route('rs.store') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'rs_id' : $('#rs_id').val(),
          'user_role_id' : user_role_id,
          'allotment_id' : allotment_id,
          'total_rs_activity_amount' : $('#total_rs_activity_amount').val(),
          'attach_rs_allotment' : 1,
        },
        success:function(data) {
          console.log(data);
          if(data.success) {
            $('#attach_allotment_modal').modal('toggle')            
            window.location.reload();  
          }
        },
      });
    }) 

    $('.btn_edit_attached_allotment_activity').on('click', function(e){  
      var rs_allotment_id = $(this).data('rs-allotment-id');
      $('#attach_allotment_modal').modal('toggle')  
      list_all_allotment_edit(rs_allotment_id);            
    })

    function list_all_allotment_edit(rs_allotment_id){  
      if($('#rs_type_id').val()==1) { 
        var groupColumn = 2;  
        var groupColumn1 = 3;  
        var all_allotment_table = $('#all_allotment_table').DataTable({
          info: false,
          orderCellsTop: true,
          iDisplayLength: 20,
          ajax: {
            url: "{{ route('show_all_allotment') }}",
            method: "GET",
            data : {
              '_token': '{{ csrf_token() }}',
              'division_id' : $('#division_id').val(),
              'division_acronym' : $('#division_acronym').val(),
              'year' : $('#year').val(),
              'rs_type_id' : $('#rs_type_id').val(),
              'rs_allotment_id' : rs_allotment_id,
              'edit_attached_allotment' : 1,
            }     
          },
          columns: [
            {data: 'division_acronym', title: 'Division', width: '3%', className:'dt-center'},   
            {data: null, defaultContent: '' , title: 'PAP', className:'dt-head-center', width: '10%', orderable: false,},
            {data: 'pap_all', title: 'PAP',  className:'dt-head-center'},
            {data: 'year_activity_subactivity', title: 'Activity', className:'dt-head-center'},
            {data: 'code_expenditure_specific', title: 'Activity - Sub-activity / Account Code', width: '50%', className:'dt-head-center'},
          ], 
          order: [[0, 'asc'], [2, 'asc'],[3, 'asc'],[4, 'asc']],
          columnDefs: [
            { visible: false, targets: groupColumn  },
            { visible: false, targets: groupColumn1  }
          ],
          drawCallback: function (settings) {
              var api = this.api();
              var rows = api.rows({ page: 'current' }).nodes();
              var last = null; 
              var last1 = null; 
              api
                .column(groupColumn, { page: 'current' })
                .data()
                .each(function (group, i) {
                  if (last !== group) {
                      $(rows)
                          .eq(i)
                          .before('<tr class="group"><td></td><td colspan="2" class="text-left font-weight-bold">' + group + '</td></tr>'); 
                      last = group;
                  }
              });

              api
                .column(groupColumn1, { page: 'current' })
                .data()
                .each(function (group1, i) {
                  if (last !== group1) {
                      $(rows)
                          .eq(i)
                          .before('<tr class="group1"><td colspan="2"></td><td class="text-left font-weight-bold">' + group1 + '</td></tr>'); 
                      last = group1;
                  }
              });
          }, 
          initComplete: function () {
            this.api().columns([0]).every(function () {
              var column = this;
              $(column.header()).append("<br>")
              var select = $('<select><option value=""></option></select>')
                .appendTo($(column.header()))
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );

                    column
                        .search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });
            column.data().unique().sort().each(function (d, j) {
                {{-- select.append('<option value="' + d + '" if(division_acronym="'+d+'") selected>' + d + '</option>') --}}
                select.append('<option value="' + d + '" >' + d + '</option>')
              } );
            } );
          }
        });
      }  
      else{
        var groupColumn = 2;  
        var groupColumn1 = 3;  
        var all_allotment_table = $('#all_allotment_table').DataTable({
          info: false,
          orderCellsTop: true,
          iDisplayLength: 20,
          ajax: {
            url: "{{ route('show_all_allotment') }}",
            method: "GET",
            data : {
              '_token': '{{ csrf_token() }}',
              'division_id' : $('#division_id').val(),
              'division_acronym' : $('#division_acronym').val(),
              'year' : $('#year').val(),
              'rs_type_id' : $('#rs_type_id').val(),
              'rs_allotment_id' : rs_allotment_id,
              'edit_attached_allotment' : 1,
            }     
          },
          columns: [
            {data: 'division_acronym', title: 'Division', width: '3%', className:'dt-center'},   
            {data: null, defaultContent: '' , title: 'PAP', className:'dt-head-center', width: '10%', orderable: false,},
            {data: 'pap_all', title: 'PAP',  className:'dt-head-center'},
            {data: 'year_activity_subactivity', title: 'Activity', className:'dt-head-center'},
            {data: 'expcode_expense_objcode_expenditure_specific', title: 'Activity - Sub-activity / Account Code', width: '50%', className:'dt-head-center'},
          ], 
          order: [[0, 'asc'], [2, 'asc'],[3, 'asc'],[4, 'asc']],
          columnDefs: [
            { visible: false, targets: groupColumn  },
            { visible: false, targets: groupColumn1  }
          ],
          drawCallback: function (settings) {
              var api = this.api();
              var rows = api.rows({ page: 'current' }).nodes();
              var last = null; 
              var last1 = null; 
              api
                .column(groupColumn, { page: 'current' })
                .data()
                .each(function (group, i) {
                  if (last !== group) {
                      $(rows)
                          .eq(i)
                          .before('<tr class="group"><td></td><td colspan="2" class="text-left font-weight-bold">' + group + '</td></tr>'); 
                      last = group;
                  }
              });

              api
                .column(groupColumn1, { page: 'current' })
                .data()
                .each(function (group1, i) {
                  if (last !== group1) {
                      $(rows)
                          .eq(i)
                          .before('<tr class="group1"><td colspan="2"></td><td class="text-left font-weight-bold">' + group1 + '</td></tr>'); 
                      last = group1;
                  }
              });
          }, 
          initComplete: function () {
            this.api().columns([0]).every(function () {
              var column = this;
              $(column.header()).append("<br>")
              var select = $('<select><option value=""></option></select>')
                .appendTo($(column.header()))
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );

                    column
                        .search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });
            column.data().unique().sort().each(function (d, j) {
                {{-- select.append('<option value="' + d + '" if(division_acronym="'+d+'") selected>' + d + '</option>') --}}
                select.append('<option value="' + d + '" >' + d + '</option>')
              } );
            } );
          }
        }); 
      }    
      $('#rs_allotment_id_edit').val(rs_allotment_id);
    }

    $('#all_allotment_table').on('click', '.edit_attached_allotment_activity', function(e){
      var allotment_id = $(this).data('allotment-id');
      var user_role_id = $('#user_role_id').val();
      e.prevenDefault;  
      clear_attributes();      
      $.ajax({
        method: "PATCH",
        url: "{{ route('rs.update') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'rs_id' : $('#rs_id').val(),
          'user_role_id' : user_role_id,
          'allotment_id' : allotment_id,
          'rs_allotment_id' : $('#rs_allotment_id_edit').val(),
          'edit_attached_allotment' : 1,
        },
        success:function(data) {
          console.log(data);
          if(data.success) {
            $('#attach_allotment_modal').modal('toggle')            
            window.location.reload();    
          }
        },
      });
    }) 
  {{-- attach allotment activity end by budget--}}

  {{-- notice adjustment start--}}
    function list_all_allotment_notice_adjustment(){   
      if($('#rs_type_id').val()==1) {
        var groupColumn = 2;  
        var groupColumn1 = 3;     
        var all_allotment_table = $('#all_allotment_table').DataTable({
          info: false,
          orderCellsTop: true,
          iDisplayLength: 20,
          ajax: {
            url: "{{ route('show_all_allotment') }}",
            method: "GET",
            data : {
              '_token': '{{ csrf_token() }}',
              'division_id' : $('#division_id').val(),
              'division_acronym' : $('#division_acronym').val(),
              'year' : $('#year').val(),
              'rs_type_id' : $('#rs_type_id').val(),
              'notice_adjustment' : 1,
            }     
          },
          columns: [
            {data: 'division_acronym', title: 'Division', width: '3%', className:'dt-center'},   
            {data: null, defaultContent: '' , title: 'PAP', className:'dt-head-center', width: '10%', orderable: false,},
            {data: 'pap_all', title: 'PAP',  className:'dt-head-center'},
            {data: 'year_activity_subactivity', title: 'Activity', className:'dt-head-center'},
            {data: 'code_expenditure_specific', title: 'Activity - Sub-activity / Account Code', width: '50%', className:'dt-head-center'},
          ], 
          order: [[0, 'asc'], [2, 'asc'],[3, 'asc'],[4, 'asc']],
          columnDefs: [
            { visible: false, targets: groupColumn  },
            { visible: false, targets: groupColumn1  }
          ],
          drawCallback: function (settings) {
              var api = this.api();
              var rows = api.rows({ page: 'current' }).nodes();
              var last = null; 
              var last1 = null; 
              api
                .column(groupColumn, { page: 'current' })
                .data()
                .each(function (group, i) {
                  if (last !== group) {
                      $(rows)
                          .eq(i)
                          .before('<tr class="group"><td></td><td colspan="2" class="text-left font-weight-bold">' + group + '</td></tr>'); 
                      last = group;
                  }
              });

              api
                .column(groupColumn1, { page: 'current' })
                .data()
                .each(function (group1, i) {
                  if (last !== group1) {
                      $(rows)
                          .eq(i)
                          .before('<tr class="group1"><td colspan="2"></td><td class="text-left font-weight-bold">' + group1 + '</td></tr>'); 
                      last = group1;
                  }
              });
          },
          initComplete: function () {
            this.api().columns([0]).every(function () {
              var column = this;
              $(column.header()).append("<br>")
              var select = $('<select><option value=""></option></select>')
                .appendTo($(column.header()))
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );

                    column
                        .search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });
            column.data().unique().sort().each(function (d, j) {
                {{-- select.append('<option value="' + d + '" if(division_acronym="'+d+'") selected>' + d + '</option>') --}}
                select.append('<option value="' + d + '" >' + d + '</option>')
              } );
            } );
          }
        });
      }
      else{
        var groupColumn = 2;  
        var groupColumn1 = 3;     
        var all_allotment_table = $('#all_allotment_table').DataTable({
          info: false,
          orderCellsTop: true,
          iDisplayLength: 20,
          ajax: {
            url: "{{ route('show_all_allotment') }}",
            method: "GET",
            data : {
              '_token': '{{ csrf_token() }}',
              'division_id' : $('#division_id').val(),
              'division_acronym' : $('#division_acronym').val(),
              'year' : $('#year').val(),
              'rs_type_id' : $('#rs_type_id').val(),
              'notice_adjustment' : 1,
            }     
          },
          columns: [
            {data: 'division_acronym', title: 'Division', width: '3%', className:'dt-center'},   
            {data: null, defaultContent: '' , title: 'PAP', className:'dt-head-center', width: '10%', orderable: false,},
            {data: 'pap_all', title: 'PAP',  className:'dt-head-center'},
            {data: 'year_activity_subactivity', title: 'Activity', className:'dt-head-center'},
            {data: 'expcode_expense_objcode_expenditure_specific', title: 'Activity - Sub-activity / Account Code', width: '50%', className:'dt-head-center'},
          ], 
          order: [[0, 'asc'], [2, 'asc'],[3, 'asc'],[4, 'asc']],
          columnDefs: [
            { visible: false, targets: groupColumn  },
            { visible: false, targets: groupColumn1  }
          ],
          drawCallback: function (settings) {
              var api = this.api();
              var rows = api.rows({ page: 'current' }).nodes();
              var last = null; 
              var last1 = null; 
              api
                .column(groupColumn, { page: 'current' })
                .data()
                .each(function (group, i) {
                  if (last !== group) {
                      $(rows)
                          .eq(i)
                          .before('<tr class="group"><td></td><td colspan="2" class="text-left font-weight-bold">' + group + '</td></tr>'); 
                      last = group;
                  }
              });

              api
                .column(groupColumn1, { page: 'current' })
                .data()
                .each(function (group1, i) {
                  if (last !== group1) {
                      $(rows)
                          .eq(i)
                          .before('<tr class="group1"><td colspan="2"></td><td class="text-left font-weight-bold">' + group1 + '</td></tr>'); 
                      last = group1;
                  }
              });
          },
          initComplete: function () {
            this.api().columns([0]).every(function () {
              var column = this;
              $(column.header()).append("<br>")
              var select = $('<select><option value=""></option></select>')
                .appendTo($(column.header()))
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );

                    column
                        .search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });
            column.data().unique().sort().each(function (d, j) {
                {{-- select.append('<option value="' + d + '" if(division_acronym="'+d+'") selected>' + d + '</option>') --}}
                select.append('<option value="' + d + '" >' + d + '</option>')
              } );
            } );
          }
        });
      }
    }
    
    $('.btn_add_notice_adjustment').on('click', function(e){  
      $('#attach_allotment_modal_header').html("Select allotment for notice of adjustment"); 
      $('#attach_allotment_modal').modal('toggle')  
      list_all_allotment_notice_adjustment();
    })  
    
    function list_all_allotment_edit_notice_adjustment(rs_allotment_id){ 
      if($('#rs_type_id').val()==1) {
        var groupColumn = 2;  
        var groupColumn1 = 3;          
        var all_allotment_table = $('#all_allotment_table').DataTable({
          info: false,
          orderCellsTop: true,
          iDisplayLength: 20,
          ajax: {
            url: "{{ route('show_all_allotment') }}",
            method: "GET",
            data : {
              '_token': '{{ csrf_token() }}',
              'division_id' : $('#division_id').val(),
              'division_acronym' : $('#division_acronym').val(),
              'year' : $('#year').val(),
              'rs_type_id' : $('#rs_type_id').val(),
              'edit_notice_adjustment' : 1,
            }     
          },
          columns: [
            {data: 'division_acronym', title: 'Division', width: '3%', className:'dt-center'},   
            {data: null, defaultContent: '' , title: 'PAP', className:'dt-head-center', width: '10%', orderable: false,},
            {data: 'pap_all', title: 'PAP',  className:'dt-head-center'},
            {data: 'year_activity_subactivity', title: 'Activity', className:'dt-head-center'},
            {data: 'code_expenditure_specific', title: 'Activity - Sub-activity / Account Code', width: '50%', className:'dt-head-center'},
          ], 
          order: [[0, 'asc'], [2, 'asc'],[3, 'asc'],[4, 'asc']],
          columnDefs: [
            { visible: false, targets: groupColumn  },
            { visible: false, targets: groupColumn1  }
          ],
          drawCallback: function (settings) {
              var api = this.api();
              var rows = api.rows({ page: 'current' }).nodes();
              var last = null; 
              var last1 = null; 
              api
                .column(groupColumn, { page: 'current' })
                .data()
                .each(function (group, i) {
                  if (last !== group) {
                      $(rows)
                          .eq(i)
                          .before('<tr class="group"><td></td><td colspan="2" class="text-left font-weight-bold">' + group + '</td></tr>'); 
                      last = group;
                  }
              });

              api
                .column(groupColumn1, { page: 'current' })
                .data()
                .each(function (group1, i) {
                  if (last !== group1) {
                      $(rows)
                          .eq(i)
                          .before('<tr class="group1"><td colspan="2"></td><td class="text-left font-weight-bold">' + group1 + '</td></tr>'); 
                      last = group1;
                  }
              });
          },
          initComplete: function () {
            this.api().columns([0]).every(function () {
              var column = this;
              $(column.header()).append("<br>")
              var select = $('<select><option value=""></option></select>')
                .appendTo($(column.header()))
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );

                    column
                        .search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });
            column.data().unique().sort().each(function (d, j) {
                {{-- select.append('<option value="' + d + '" if(division_acronym="'+d+'") selected>' + d + '</option>') --}}
                select.append('<option value="' + d + '" >' + d + '</option>')
              } );
            } );
          }
        });
      }
      else{
        var groupColumn = 2;  
        var groupColumn1 = 3;          
        var all_allotment_table = $('#all_allotment_table').DataTable({
          info: false,
          orderCellsTop: true,
          iDisplayLength: 20,
          ajax: {
            url: "{{ route('show_all_allotment') }}",
            method: "GET",
            data : {
              '_token': '{{ csrf_token() }}',
              'division_id' : $('#division_id').val(),
              'division_acronym' : $('#division_acronym').val(),
              'year' : $('#year').val(),
              'rs_type_id' : $('#rs_type_id').val(),
              'edit_notice_adjustment' : 1,
            }     
          },
          columns: [
            {data: 'division_acronym', title: 'Division', width: '3%', className:'dt-center'},   
            {data: null, defaultContent: '' , title: 'PAP', className:'dt-head-center', width: '10%', orderable: false,},
            {data: 'pap_all', title: 'PAP',  className:'dt-head-center'},
            {data: 'year_activity_subactivity', title: 'Activity', className:'dt-head-center'},
            {data: 'expcode_expense_objcode_expenditure_specific', title: 'Activity - Sub-activity / Account Code', width: '50%', className:'dt-head-center'},
          ], 
          order: [[0, 'asc'], [2, 'asc'],[3, 'asc'],[4, 'asc']],
          columnDefs: [
            { visible: false, targets: groupColumn  },
            { visible: false, targets: groupColumn1  }
          ],
          drawCallback: function (settings) {
              var api = this.api();
              var rows = api.rows({ page: 'current' }).nodes();
              var last = null; 
              var last1 = null; 
              api
                .column(groupColumn, { page: 'current' })
                .data()
                .each(function (group, i) {
                  if (last !== group) {
                      $(rows)
                          .eq(i)
                          .before('<tr class="group"><td></td><td colspan="2" class="text-left font-weight-bold">' + group + '</td></tr>'); 
                      last = group;
                  }
              });

              api
                .column(groupColumn1, { page: 'current' })
                .data()
                .each(function (group1, i) {
                  if (last !== group1) {
                      $(rows)
                          .eq(i)
                          .before('<tr class="group1"><td colspan="2"></td><td class="text-left font-weight-bold">' + group1 + '</td></tr>'); 
                      last = group1;
                  }
              });
          },
          initComplete: function () {
            this.api().columns([0]).every(function () {
              var column = this;
              $(column.header()).append("<br>")
              var select = $('<select><option value=""></option></select>')
                .appendTo($(column.header()))
                .on('change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );

                    column
                        .search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });
            column.data().unique().sort().each(function (d, j) {
                select.append('<option value="' + d + '" >' + d + '</option>')
              } );
            } );
          }
        });
      }
      $('#rs_allotment_id_edit').val(rs_allotment_id);
    }
    
    $('.btn_edit_notice_adjustment').on('click', function(e){  
      $('#attach_allotment_modal_header').html("Select allotment for notice of adjustment"); 
      var rs_allotment_id = $(this).data('rs-allotment-id');
      $('#attach_allotment_modal').modal('toggle')  
      list_all_allotment_edit_notice_adjustment(rs_allotment_id);
    })  

    $('#all_allotment_table').on('click', '.add_notice_adjustment', function(e){
      var allotment_id = $(this).data('allotment-id');
      var user_role_id = $('#user_role_id').val();
      e.prevenDefault;  
      clear_attributes();      
      $.ajax({
        method: "POST",
        url: "{{ route('rs.store') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'rs_id' : $('#rs_id').val(),
          'allotment_id' : allotment_id,
          'add_notice_adjustment' : 1,
        },
        success:function(data) {
          console.log(data);
          if(data.success) {
            $('#attach_allotment_modal').modal('toggle')            
            window.location.reload();    
          }
        },
      });
    }) 

    $('#all_allotment_table').on('click', '.edit_notice_adjustment', function(e){
      var allotment_id = $(this).data('allotment-id');
      var user_role_id = $('#user_role_id').val();
      e.prevenDefault;  
      clear_attributes();      
      $.ajax({
        method: "PATCH",
        url: "{{ route('rs.update') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'rs_id' : $('#rs_id').val(),
          'allotment_id' : allotment_id,
          'rs_allotment_id' : $('#rs_allotment_id_edit').val(),
          'edit_notice_adjustment' : 1,
        },
        success:function(data) {
          console.log(data);
          if(data.success) {
            $('#attach_allotment_modal').modal('toggle')            
            window.location.reload();    
          }
        },
      });
    }) 

  {{-- notice adjustment end--}}

  {{-- attach activity start --}}
    function list_all_activity(){        
      var all_allotment_table = $('#all_allotment_table').DataTable({
        info: false,
        orderCellsTop: true,
        iDisplayLength: 25,
        ajax: {
          url: "{{ route('show_all_allotment') }}",
          method: "GET",
          data : {
            '_token': '{{ csrf_token() }}',
            'division_id' : $('#division_id').val(),
            'division_acronym' : $('#division_acronym').val(),
            'year' : $('#year').val(),
            'rs_type_id' : $('#rs_type_id').val(),
            'showall' : $('#showall').val(),
            'attach_activity' : 1,
          }     
        },
        columns: [
          {data: 'division_acronym', title: 'Division', width: '3%', className: 'dt-center'},   
          {data: 'activity_subactivity_specific', title: 'Activity ', width: '46%', className: 'dt-head-center'},
        ],
        initComplete: function () {
          this.api().columns([0]).every(function () {
            var column = this;
            $(column.header()).append("<br>")
            var select = $('<select><option value=""></option></select>')
              .appendTo($(column.header()))
              .on('change', function () {
                  var val = $.fn.dataTable.util.escapeRegex(
                      $(this).val()
                  );

                  column
                      .search(val ? '^' + val + '$' : '', true, false)
                      .draw();
              });
          column.data().unique().sort().each(function (d, j) {
              select.append('<option value="' + d + '" >' + d + '</option>')
            } );
          } );
        }
      });
    }

    $('.btn_attach_activity').on('click', function(e){ 
      $('#attach_allotment_modal_header').html("Select activity to attach");  
      $('#attach_allotment_modal').modal('toggle')  
      list_all_activity();
    }) 
    
    function list_all_activity_edit(rs_allotment_id){  
      var all_allotment_table = $('#all_allotment_table').DataTable({
        info: false,
        orderCellsTop: true,
        iDisplayLength: 25,
        ajax: {
          url: "{{ route('show_all_allotment') }}",
          method: "GET",
          data : {
            '_token': '{{ csrf_token() }}',
            'division_id' : $('#division_id').val(),
            'division_acronym' : $('#division_acronym').val(),
            'year' : $('#year').val(),
            'rs_type_id' : $('#rs_type_id').val(),
            'rs_allotment_id' : rs_allotment_id,
            'showall' : $('#showall').val(),
            'edit_attached_activity' : 1,
          }     
        },
        columns: [
          {data: 'division_acronym', title: 'Division', width: '3%', className: 'dt-center'},   
          {data: 'activity_subactivity_specific', title: 'Activity ', width: '46%', className: 'dt-head-center'},
        ], 
        initComplete: function () {
          this.api().columns([0]).every(function () {
            var column = this;
            $(column.header()).append("<br>")
            var select = $('<select><option value=""></option></select>')
              .appendTo($(column.header()))
              .on('change', function () {
                  var val = $.fn.dataTable.util.escapeRegex(
                      $(this).val()
                  );

                  column
                      .search(val ? '^' + val + '$' : '', true, false)
                      .draw();
              });
          column.data().unique().sort().each(function (d, j) {
              select.append('<option value="' + d + '" >' + d + '</option>')
            } );
          } );
        }
      });      
      $('#rs_allotment_id_edit').val(rs_allotment_id);
    }

    $('.btn_edit_attached_activity').on('click', function(e){  
      var rs_allotment_id = $(this).data('rs-allotment-id');
      $('#attach_allotment_modal_header').html("Select activity to attach");  
      $('#attach_allotment_modal').modal('toggle')  
      list_all_activity_edit(rs_allotment_id);            
    })

    $('#all_allotment_table').on('click', '.attach_activity', function(e){ 
      var allotment_id = $(this).data('allotment-id');
      var user_role_id = $('#user_role_id').val();
      e.prevenDefault;          
      $.ajax({
        method: "POST",
        url: "{{ route('rs.store') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'rs_id' : $('#rs_id').val(),
          'user_role_id' : user_role_id,
          'allotment_id' : allotment_id,
          'attach_rs_allotment' : 1,
        },
        success:function(data) {
          console.log(data);
          if(data.success) {
            $('#attach_allotment_modal').modal('toggle')            
            window.location.reload();   
          }
        },
      });
    }) 

    $('#all_allotment_table').on('click', '.edit_attached_activity', function(e){
      var allotment_id = $(this).data('allotment-id');
      var user_role_id = $('#user_role_id').val();
      e.prevenDefault;  
      clear_attributes();      
      $.ajax({
        method: "PATCH",
        url: "{{ route('rs.update') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'rs_id' : $('#rs_id').val(),
          'user_role_id' : user_role_id,
          'allotment_id' : allotment_id,
          'rs_allotment_id' : $('#rs_allotment_id_edit').val(),
          'edit_attached_allotment' : 1,
        },
        success:function(data) {
          console.log(data);
          if(data.success) {
            $('#attach_allotment_modal').modal('toggle')            
            window.location.reload();    
          }
        },
      });
    }) 
  {{-- attach activity end--}}

  {{-- insert particulars template start --}}
    $('.btn_insert_particulars_template').on('click', function(e){  
      var rs_type_id = $(this).data('rs-type-id');
      $('#particulars_template_modal').modal('toggle')  
      list_particulars_template_by_rs_type(rs_type_id);            
    })

    function list_particulars_template_by_rs_type(rs_type_id){      
      var particulars_template_table = $('#particulars_template_table').DataTable({
        info: false,
        iDisplayLength: 25,
        ajax: {
          url: "{{ route('show_particulars_template_by_rs_type') }}",
          method: "GET",
          data : {
            '_token': '{{ csrf_token() }}',
            'rs_type_id' : rs_type_id,
          }     
        },
        columns: [
            {data: 'transaction_type', title: 'Transaction Type'},   
            {data: 'transaction_detail', title: 'Transaction'},   
        ]
      });
    }

    {{-- function insert_particulars_template(x) { --}}
    $('#particulars_template_table').on('click', '.insert_particulars_template', function(e){
      var particulars = $(this).data('particulars');
      $('#particulars_template_modal').modal('toggle')  
      $('#particulars').val(particulars);     
      {{-- document.getElementById('particulars').value=document.getElementById('temps[' + x + ']').value ; --}}
    })
  {{-- insert particulars template end --}}
  
  {{-- edit start --}}
    $('.edit_rs').on('click', function(e){       
      if($("#showall").prop('checked') == true){
        showall = 1;
      }
      else{
        showall = 0;
      }  
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
            url: "{{ route('rs.update') }}",
            data:  $('#rs_form').serialize() + "&showall="+showall + "&edit_rs=1",
            success:function(data) {
              console.log(data);
              if(data.errors) {    
                if(data.errors.rs_date){
                  $('#rs_date').addClass('is-invalid');
                  $('#date-error').html(data.errors.rs_date[0]);
                }      
                if(data.errors.fund_id ){
                  $('#fund_id ').addClass('is-invalid');
                  $('#fund-error').html(data.errors.fund_id[0]);
                }           
              }              
              if(data.success) {    
                Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: 'Record has been successfully updated.',
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
    
    $('.update_rs').on('click', function(e){    
      if($("#is_locked").prop('checked') == true){
        is_locked = 1;
      }
      else{
        is_locked = 0;
      }   
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
            url: "{{ route('rs.update') }}",
            data:  $('#rs_form').serialize() + "&is_locked="+is_locked + "&update_rs=1",
            success:function(data) {
              console.log(data);
              if(data.errors) {    
                if(data.errors.rs_date){
                  $('#rs_date').addClass('is-invalid');
                  $('#date-error').html(data.errors.rs_date[0]);
                }      
                if(data.errors.fund_id ){
                  $('#fund_id ').addClass('is-invalid');
                  $('#fund-error').html(data.errors.fund_id[0]);
                }           
              }              
              if(data.success) {    
                Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: 'Record has been successfully updated.',
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

  {{-- generate_rs_no start  --}}
    $('.generate_rs_no').click(function(){
      rs_id = $(this).data('rs-id');
      rs_month = $(this).data('rs-month');
      prefix_code = $(this).data('prefix-code');
      year = $(this).data('year');
      rs_type_id = $(this).data('rs-type-id');
      rs_type = $(this).data('rs-type');
      allotment_count = $(this).data('allotment-count');
      $.ajax({
        method: "PATCH",
        url: "{{ route('generate_rs_no') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'allotment_count' : allotment_count,
          'rs_id' : rs_id,
          'rs_month' : rs_month,
          'prefix_code' : prefix_code,
          'year' : year,
          'module_id' : 5,
          'rs_type' : rs_type,
          'rs_type_id' : rs_type_id,
          'division_id' : $('#division_id').val(),
        },
        success:function(data) {
          console.log(data);
          if(data.errors) {    
            if(data.errors.allotment_count){
              $('#rs_no').addClass('is-invalid')
              $('#attached_allotment_table').addClass('is-invalid')
              $('.btn_attach_allotment_activity').addClass('is-invalid');          
            }         
          } 
          if(data.success) {  
            $.ajax({
              method: "PATCH",   
              dataType: 'json',         
              url: "{{ route('rs.update') }}",
              data:  $('#rs_form').serialize() + "&is_locked="+is_locked + "&update_rs=1",                            
            });                   
            window.location.reload();    
          }
        },
      });
      {{-- $('#rs_no').val('2023'); --}}
      {{-- alert(rs_year);     --}}
    });
  {{-- generate_rs_no end  --}}

  {{-- remove start --}}
    $('.btn_remove_attached_allotment').on('click', function(){
      id = $(this).data('id')
      remove_attached_allotment(id);
    })

    function remove_attached_allotment(id){
      Swal.fire({
        title: 'Are you sure you want to remove attached allotment?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      })
      .then((result) => {
        if (result.value) {
        $.ajax({
            method: "PATCH",
            url: "{{ route('rs.delete') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'id' : id,
              'remove_attached_allotment' : 1,
            },
            success: function(data) {      
              Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Attached allotment has been successfully removed.',
              showConfirmButton: false,
              timer: 1500
              }) 
              window.location.reload();    
            }             
        })    
        }       
      })
    }

    $('.btn_remove_notice_adjustment').on('click', function(){
      id = $(this).data('id')
      remove_notice_adjustment(id);
    })

    function remove_notice_adjustment(id, rs_id){
      Swal.fire({
        title: 'Are you sure you want to remove notice adjustment?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      })
      .then((result) => {
        if (result.value) {
        $.ajax({
            method: "PATCH",
            url: "{{ route('rs.delete') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'id' : id,
              'rs_id' : rs_id,
              'remove_attached_allotment' : 1,
            },
            success: function(data) {      
              Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Notice adjustment has been successfully removed.',
              showConfirmButton: false,
              timer: 1500
              }) 
              window.location.reload();    
            }             
        })    
        }       
      })
    }

    $('.btn_remove_attached_activity').on('click', function(){
      id = $(this).data('id')
      rs_id = $(this).data('rs-id')
      remove_attached_activity(id, rs_id);
    })

    function remove_attached_activity(id, rs_id){
      Swal.fire({
        title: 'Are you sure you want to remove attached activity?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      })
      .then((result) => {
        if (result.value) {
        $.ajax({
            method: "PATCH",
            url: "{{ route('rs.delete') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'id' : id,
              'rs_id' : rs_id,
              'remove_attached_activity' : 1,
            },
            success: function(data) {      
              Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Attached activity has been successfully removed.',
              showConfirmButton: false,
              timer: 1500
              }) 
              window.location.reload();    
            }             
        })    
        }       
      })
    }
  {{-- remove end --}} 

  {{-- print start --}}
    $('.print_p1').on('click', function(e){ 
      var rs_id = $('#rs_id').val();
      window.open("{{ url('/request_and_status/print_rs_page1') }}/" + rs_id);
    })   
    
    $('.print_p2').on('click', function(e){ 
      var rs_id = $('#rs_id').val();
      window.open("{{ url('/request_and_status/print_rs_page2') }}/" + rs_id);
    })   
  {{-- print end --}}  
{{-- END --}}