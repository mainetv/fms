
{{-- table start --}}
  var budget_proposal_fiscal_years_table = $('#budget_proposal_fiscal_years_table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    lengthChange: false,
    autoWidth: false,
    stateSave: true,
    dom: 'Bfrtip',
    ajax: {
        url: "{{ route('fiscal_years.table') }}",
        method: "GET",
        data :  {
          '_token': '{{ csrf_token() }}',
        }      
    },    
    columns: [      
        {data: 'year', name: 'year'},
        {data: 'fiscal_year1', name: 'fiscal_year1'},
        {data: 'fiscal_year2', name: 'fiscal_year2'},
        {data: 'fiscal_year3', name: 'fiscal_year3'},
        {data: 'open_date_from', name: 'open_date_from'},
        {data: 'open_date_to', name: 'open_date_to'},
        {data: 'file', orderable: false, searchable: false},         
        {data: 'is_locked', name: 'is_locked',
          render: function (data, type, row) {
          if (type === 'display' || type === 'filter' ) {
            return data=='1' ? 'Yes' : 'No';
          }
            return data;
          }
        },
        {data: 'is_active', name: 'is_active',
          render: function (data, type, row) {
          if (type === 'display' || type === 'filter' ) {
            return data=='1' ? 'Yes' : 'No';
          }
            return data;
          }
        },
        {data: 'action', orderable: false, searchable: false}          
    ]
  });
{{-- table end --}}

{{-- START --}}
   {{-- modal start --}}
      $('#budget_proposal_fiscal_years_modal').on('hide.bs.modal', function(){       
         init_view_budget_proposal_fiscal_years();
         clear_attributes();
         clear_fields();
      });  

      $('#budget_proposal_fiscal_years_modal').on('shown.bs.modal', function () {
         $('#budget_proposal_year').focus();
      })  
   {{-- modal end --}}

   {{-- view start --}}
      function init_view_budget_proposal_fiscal_years(){
         $('.budget-proposal-fiscal-years-field')
         .val('')
         .attr('disabled', true);

         $('.save-buttons')
         .removeClass('d-inline')
         .addClass('d-none')
         .attr('disabled', true);

         $('.existing_file').removeClass('d-none');
      }

      function view_budget_proposal_fiscal_years(fiscal_year_id){
         var request = $.ajax({
         method: "GET",
         url: "{{ route('fiscal_years.show') }}",
         data: {
            '_token': '{{ csrf_token() }}',
            'id' : fiscal_year_id
         }
         });
         return request;
      }

      $('#budget_proposal_fiscal_years_table').on('click', '.view-fiscal-years', function(e){    
         $('.upload_file').addClass('d-none');      
         $('#budget_proposal_fiscal_years_modal_header').html("View Budget Proposal Fiscal Year");     
         fiscal_year_id = $(this).parents('tr').data('id');
         init_view_budget_proposal_fiscal_years();   
         var request = view_budget_proposal_fiscal_years(fiscal_year_id);   
         request.then(function(data) {
         if(data['status'] == 1){     
            $('#budget_proposal_year').val(data['fiscal_years']['year'])   
            $('#budget_proposal_fiscal_year1').val(data['fiscal_years']['fiscal_year1'])   
            $('#budget_proposal_fiscal_year2').val(data['fiscal_years']['fiscal_year2'])   
            $('#budget_proposal_fiscal_year3').val(data['fiscal_years']['fiscal_year3'])   
            $('#open_date_from').val(data['fiscal_years']['open_date_from'])   
            $('#open_date_to').val(data['fiscal_years']['open_date_to'])
            if(data['fiscal_years']['is_active'] == 1) {
               $('#year_is_active').iCheck('check'); 
            }
         }
                        
         })
         $('#budget_proposal_fiscal_years_modal').modal('toggle');
      })
   {{-- view end --}}

   {{-- add start --}}
      function init_add_budget_proposal_fiscal_years(){
         $('.budget-proposal-fiscal-years-field')
            .attr('disabled', false);
         
         $('#add_budget_proposal_fiscal_years.save-buttons')
            .addClass('d-inline')
            .removeClass('d-none')
            .attr('disabled', false); 
         
         $('.existing_file').addClass('d-none');          
         $('.upload_file').removeClass('d-none');  
         $('.choose_file_label').text("Choose File");
      }

      $('#add_new_budget_proposal_fiscal_years').on('click', function(){   
         init_add_budget_proposal_fiscal_years();         
         $('#budget_proposal_fiscal_years_modal_header').html("Add Budget Proposal Fiscal Year");
         $('#budget_proposal_fiscal_years_modal').modal('toggle');   
      })

      $('#add_budget_proposal_fiscal_years').on('click', function(e){
         e.prevenDefault;  
         clear_attributes();       
         var file = $('#upload_file').prop('files')[0];  
         if($('#year_is_active').is(":checked")){
            var is_active = 1;
         }                 
         else{
            var is_active = 0;
         }    
         var postData=new FormData();  
         postData.append('year',$('#budget_proposal_year').val());           
         postData.append('fiscal_year1',$('#budget_proposal_fiscal_year1').val());           
         postData.append('fiscal_year2',$('#budget_proposal_fiscal_year2').val());           
         postData.append('fiscal_year3',$('#budget_proposal_fiscal_year3').val());           
         postData.append('open_date_from',$('#open_date_from').val());           
         postData.append('open_date_to',$('#open_date_to').val());      
         postData.append('is_active',is_active);             
         postData.append('upload_file',file);               
         $.ajax({            
            method: "POST",
            url: "{{ route('fiscal_years.store') }}",
            async:true,
            enctype: "multipart/form-data",
            contentType : false,
            processType : false,  
            processData:false,
            data: postData,           
            success:function(data) {
               console.log(data);
               if(data.errors) {         
                  if(data.errors.year){
                     $('#budget_proposal_year').addClass('is-invalid');
                     $('#budget-proposal-fiscal-years-error').html(data.errors.year[0]);
                  }   
                  if(data.errors.fiscal_year1){
                     $('#budget_proposal_fiscal_year1').addClass('is-invalid');
                     $('#fiscal-year1-error').html(data.errors.fiscal_year1[0]);
                  } 
                  if(data.errors.fiscal_year2){
                     $('#budget_proposal_fiscal_year2').addClass('is-invalid');
                     $('#fiscal-year2-error').html(data.errors.fiscal_year2[0]);
                  } 
                  if(data.errors.fiscal_year3){
                     $('#budget_proposal_fiscal_year3').addClass('is-invalid');
                     $('#fiscal-year3-error').html(data.errors.fiscal_year3[0]);
                  } 
                  if(data.errors.open_date_from){
                     $('#open_date_from').addClass('is-invalid');
                     $('#open-date-from-error').html(data.errors.open_date_from[0]);
                  }
                  if(data.errors.open_date_to){
                     $('#open_date_to').addClass('is-invalid');
                     $('#open-date-to-error').html(data.errors.open_date_to[0]);
                  }                                
               }
               if(data.success) {
                  Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: 'Fiscal year has been successfully added.',
                  showConfirmButton: false,
                  timer: 1500
                  }) 
                  $('#budget_proposal_fiscal_years_modal').modal('toggle')
                  $('#budget_proposal_fiscal_years_table').DataTable().ajax.reload();
               }
            },
         });
      })
   {{-- add end    --}}

   {{-- update start --}}
      function init_edit_budget_proposal_fiscal_years(){
         init_view_budget_proposal_fiscal_years()
         $('.budget-proposal-fiscal-years-field')
         .attr('disabled', false);

         $('#edit_budget_proposal_fiscal_years.save-buttons')
         .addClass('d-inline')
         .removeClass('d-none')
         .attr('disabled', false);    
         
         $('.existing_file').removeClass('d-none');          
         $('.upload_file').removeClass('d-none');        
         $('.choose_file_label').text("Replace File");
      }

      $('#edit_budget_proposal_fiscal_years').on('click', function(e){
         e.preventDefault();
         clear_attributes();
         var file = $('#upload_file').prop('files')[0];  
         alert(file);
         if(!isset(file)){
            alert(file);
         }                     
         if($('#year_is_active').is(":checked")){
            var is_active = 1;
         }                 
         else{
            var is_active = 0;
         }    
         var postData=new FormData();  
         postData.append('year',$('#budget_proposal_year').val());           
         postData.append('fiscal_year1',$('#budget_proposal_fiscal_year1').val());           
         postData.append('fiscal_year2',$('#budget_proposal_fiscal_year2').val());           
         postData.append('fiscal_year3',$('#budget_proposal_fiscal_year3').val());           
         postData.append('open_date_from',$('#open_date_from').val());           
         postData.append('open_date_to',$('#open_date_to').val());      
         postData.append('is_active',is_active);             
         postData.append('upload_file',file);  
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
                  url: "{{ route('fiscal_years.update') }}",
                  async:true,
                  enctype: "multipart/form-data",
                  contentType : false,
                  processType : false,  
                  processData:false,
                  data: postData,    
                  success:function(data) {
                     console.log(data);
                     if(data.errors) {         
                        if(data.errors.year){
                           $('#budget_proposal_year').addClass('is-invalid');
                           $('#budget-proposal-fiscal-years-error').html(data.errors.year[0]);
                        }   
                        if(data.errors.fiscal_year1){
                           $('#budget_proposal_fiscal_year1').addClass('is-invalid');
                           $('#fiscal-year1-error').html(data.errors.fiscal_year1[0]);
                        } 
                        if(data.errors.fiscal_year2){
                           $('#budget_proposal_fiscal_year2').addClass('is-invalid');
                           $('#fiscal-year2-error').html(data.errors.fiscal_year2[0]);
                        } 
                        if(data.errors.fiscal_year3){
                           $('#budget_proposal_fiscal_year3').addClass('is-invalid');
                           $('#fiscal-year3-error').html(data.errors.fiscal_year3[0]);
                        } 
                        if(data.errors.open_date_from){
                           $('#open_date_from').addClass('is-invalid');
                           $('#open-date-from-error').html(data.errors.open_date_from[0]);
                        }
                        if(data.errors.open_date_to){
                           $('#open_date_to').addClass('is-invalid');
                           $('#open-date-to-error').html(data.errors.open_date_to[0]);
                        }                                
                     }
                     if(data.success) {
                        Swal.fire({
                           position: 'top-end',
                           icon: 'success',
                           title: 'Fiscal year has been successfully updated.',
                           showConfirmButton: false,
                           timer: 1500
                        })                        
                        $('#budget_proposal_fiscal_years_modal').modal('toggle')
                        $('#budget_proposal_fiscal_years_table').DataTable().ajax.reload();
                     }                      
                  }                             
               });                                
            }       
         })   
      })

      $('#budget_proposal_fiscal_years_table').on('click', '.update-fiscal-years', function(e){
         $('#budget_proposal_fiscal_years_modal_header').html("Update Budget Proposal Fiscal Year");         
         init_edit_budget_proposal_fiscal_years();
         fiscal_year_id = $(this).parents('tr').data('id');
         var request = view_budget_proposal_fiscal_years(fiscal_year_id);
         request.then(function(data) {
            if(data['status'] == 1){            
               $('#budget_proposal_year').val(data['fiscal_years']['year'])                
               $('#budget_proposal_fiscal_year1').val(data['fiscal_years']['fiscal_year1'])  
               $('#budget_proposal_fiscal_year2').val(data['fiscal_years']['fiscal_year2'])  
               $('#budget_proposal_fiscal_year3').val(data['fiscal_years']['fiscal_year3'])  
               $('#open_date_from').val(data['fiscal_years']['open_date_from'])  
               $('#open_date_to').val(data['fiscal_years']['open_date_to']) 
               $('#existing_file').val(data['fiscal_years']['filename']) 
               if(data['fiscal_years']['is_active'] == 1) {
                  $('#year_is_active').iCheck('check'); 
               }  
            }                      
         }) 
         $('#budget_proposal_fiscal_years_modal').modal('toggle')       
      })
   {{-- update end --}}

   {{-- open budget proposal --}}
      $('#budget_proposal_fiscal_years_table').on('click', '.open-budget-proposal', function(){
         fiscal_year_id = $(this).parents('tr').data('id'); 
         year = $(this).parents('tr').data('year');                 
         open_budget_proposal(fiscal_year_id, year);
      })

      function open_budget_proposal(fiscal_year_id, year){      
         Swal.fire({
            title: 'Open call for budget proposal to all divisions?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
         })
         .then((result) => {
            if (result.value) {
               $.ajax({
                  method: "POST",
                  url: "{{ route('fiscal_years.store') }}",
                  data: {
                     '_token': '{{ csrf_token() }}',
                     'year' : year,
                     'all_divisions' : $('#all_divisions').val(),
                  },
                  success: function(data) {      
                     Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Call for budget proposal has been opened to all divisions.',
                        showConfirmButton: false,
                        timer: 1500
                     }) 
                     $('#budget_proposal_fiscal_years_table').DataTable().ajax.reload();
                  }             
               })    
            }       
         })
      }
   {{-- open budget proposal --}}

   {{-- close budget proposal --}}
      $('#budget_proposal_fiscal_years_table').on('click', '.close-budget-proposal', function(){
         fiscal_year_id = $(this).parents('tr').data('id'); 
         year = $(this).parents('tr').data('year');                 
         close_budget_proposal(fiscal_year_id, year);
      })

      function close_budget_proposal(fiscal_year_id, year){      
         Swal.fire({
            title: 'Close call for budget proposal to all divisions?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
         })
         .then((result) => {
            if (result.value) {
               $.ajax({
                  method: "PATCH",
                  url: "{{ route('fiscal_years.close') }}",
                  data: {
                     '_token': '{{ csrf_token() }}',
                     'id' : fiscal_year_id,
                     'year' : year,
                     'all_divisions' : $('#all_divisions').val(),
                  },
                  success: function(data) {      
                     Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Call for budget proposal has been closed to all divisions.',
                        showConfirmButton: false,
                        timer: 1500
                     }) 
                     $('#budget_proposal_fiscal_years_table').DataTable().ajax.reload();     
                  }             
               })    
            }       
         })
      }
   {{-- close budget proposal --}}
{{-- END --}}