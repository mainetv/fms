{{-- modal start --}}
   $('#bp_form205_modal').on('hide.bs.modal', function(){  
      init_view_bp_form205();   
      clear_attributes();
      clearFields
   });  
   $('#bp_form205_modal').on('shown.bs.modal', function () {
      $('#retiree_emp_code').focus();
   })  
{{-- modal end --}}

{{-- view start --}}   
   function init_view_bp_form205(){
      $('.bp-form205-field')
         .val('')
         .attr('disabled', true);

      $('.save-buttons')
         .removeClass('d-inline')
         .addClass('d-none')
         .attr('disabled', true);
   }

   function view_bp_form205(bp_form205_id){
      var request = $.ajax({
         method: "GET",
         url: "{{ route('bp_form205.show') }}",
         data: {
         '_token': '{{ csrf_token() }}',
         'id' : bp_form205_id
         }
      });
      return request;
   }

   $('.btn_view_bp_form205').on('click', function(e){    
      $('#bp_form205_modal_header').html("View BP Form No. 205"); 
      bp_form205_id = $(this).data('id');
      init_view_bp_form205();   
      var request = view_bp_form205(bp_form205_id);   
      request.then(function(data) {
         if(data['status'] == 1){            
            $('#retiree_emp_code').val(data['bp_form205']['retiree_emp_code']) 
         }                          
      })
      $('#bp_form205_modal').modal('toggle');
   })  
{{-- view end --}}

{{-- add start --}}
   function init_add_bp_form205(){
      $('.bp-form205-field')
         .attr('disabled', false);
         
      $('.add_bp_form205.save-buttons')
         .addClass('d-inline')
         .removeClass('d-none')
         .attr('disabled', false);      
   }

   $('.btn_add_bp_form205').on('click', function(){    
      init_add_bp_form205();
      var division_id=$(this).data('division-id');      
      var year=$(this).data('year');      
      var fiscal_year=$(this).data('fy');  
      $('#bp_form205_year').val(year);
      $('#bp_form205_fiscal_year').val(fiscal_year);
      $('#bp_form205_modal_header').html("Add BP Form No. 205");
      $('#bp_form205_modal').modal('toggle')       
   })

   $('.add_bp_form205').on('click', function(e){        
      e.prevenDefault;  
      clear_attributes();
      $.ajax({
         method: "POST",
         url: "{{ route('bp_form205.store') }}",
         data: {
         '_token': '{{ csrf_token() }}',
         'division_id' : $('#bp_form205_division_id').val(),
         'year' : $('#bp_form205_year').val(),
         'fiscal_year' : $('#bp_form205_fiscal_year').val(),
         'retirement_law_id' : $('#retirement_law_id').val(),
         'emp_code' : $('#retiree_emp_code').val(),
         'position_id_at_retirement_date' : $('#position_id_at_retirement_date').val(),
         'highest_monthly_salary' : $('#highest_monthly_salary').val(),
         'sl_credits_earned' : $('#sl_credits_earned').val(),
         'vl_credits_earned' : $('#vl_credits_earned').val(),
         'leave_amount' : $('#leave_amount').val(),
         'total_creditable_service' : $('#total_creditable_service').val(),
         'num_gratuity_months' : $('#num_gratuity_months').val(),
         'gratuity_amount' : $('#gratuity_amount').val(),
         },
         success:function(data) {
            console.log(data);
            if(data.errors) {         
               if(data.errors.retirement_law_id){
                  $('#retirement_law_id').addClass('is-invalid');
                  $('#bp-form205-retirement-law-error').html(data.errors.retirement_law_id[0]);
               }
               if(data.errors.emp_code){
                  $('#retiree_emp_code').addClass('is-invalid');
                  $('#bp-form205-name-error').html(data.errors.emp_code[0]);
               }
               if(data.errors.position_id_at_retirement_date){
                  $('#position_id_at_retirement_date').addClass('is-invalid');
                  $('#bp-form205-position-error').html(data.errors.position_id_at_retirement_date[0]);
               }
               if(data.errors.highest_monthly_salary){
                  $('#highest_monthly_salary').addClass('is-invalid');
                  $('#bp-form205-salary-error').html(data.errors.highest_monthly_salary[0]);
               } 
               if(data.errors.sl_credits_earned){
                  $('#sl_credits_earned').addClass('is-invalid');
                  $('#bp-form205-sl-error').html(data.errors.sl_credits_earned[0]);
               }
               if(data.errors.vl_credits_earned){
                  $('#vl_credits_earned').addClass('is-invalid');
                  $('#bp-form205-vl-error').html(data.errors.vl_credits_earned[0]);
               }
               if(data.errors.leave_amount){
                  $('#leave_amount').addClass('is-invalid');
                  $('#bp-form205-leave-amount-error').html(data.errors.leave_amount[0]);
               }   
               if(data.errors.total_creditable_service){
                  $('#total_creditable_service').addClass('is-invalid');
                  $('#bp-form205-gratuity-service-error').html(data.errors.total_creditable_service[0]);
               }
               if(data.errors.num_gratuity_months){
                  $('#num_gratuity_months').addClass('is-invalid');
                  $('#bp-form205-gratuity-months-error').html(data.errors.num_gratuity_months[0]);
               }
               if(data.errors.gratuity_amount){
                  $('#gratuity_amount').addClass('is-invalid');
                  $('#bp-form205-gratuity-amount-error').html(data.errors.gratuity_amount[0]);
               }                             
            }
            if(data.success) {
               Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: 'BP Form No. 205 has been successfully added.',
                  showConfirmButton: false,
                  timer: 1500
               }) 
               $('#bp_form205_modal').modal('toggle');  
               window.location.reload();
               $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
                  var id = $(e.target).attr("href").substr(1);
                  window.location.hash = id;
               });
               var hash = window.location.hash;
               $('#fy_tabs a[href="' + hash + '"]').tab('show');
            }
         },
      });
   })
{{-- add end    --}}

{{-- edit start --}}
   function init_edit_bp_form205(){
      init_view_bp_form205()
      $('.bp-form205-field')
         .attr('disabled', false);

      $('.edit_bp_form205.save-buttons')
         .addClass('d-inline')
         .removeClass('d-none')
         .attr('disabled', false);
   }

   $('.btn_edit_bp_form205').on('click', function(e){  
      init_edit_bp_form205();
      bp_form205_id = $(this).data('id');
      $('#bp_form205_modal_header').html("Edit BP Form No. 205");     
      var request = view_bp_form205(bp_form205_id);
      request.then(function(data) {
         if(data['status'] == 1){                 
            $('#retirement_law_id').val(data['bp_form205']['retirement_law_id']) 
            $('#retiree_emp_code').val(data['bp_form205']['emp_code']) 
            $('#position_id_at_retirement_date').val(data['bp_form205']['position_id_at_retirement_date']) 
            $('#highest_monthly_salary').val(data['bp_form205']['highest_monthly_salary']) 
            $('#vl_credits_earned').val(data['bp_form205']['vl_credits_earned']) 
            $('#sl_credits_earned').val(data['bp_form205']['sl_credits_earned']) 
            $('#leave_amount').val(data['bp_form205']['leave_amount']) 
            $('#total_creditable_service').val(data['bp_form205']['total_creditable_service']) 
            $('#num_gratuity_months').val(data['bp_form205']['num_gratuity_months']) 
            $('#gratuity_amount').val(data['bp_form205']['gratuity_amount']) 
         }           
      })
      $('#bp_form205_modal').modal('toggle')            
   })

   $('.edit_bp_form205').on('click', function(e){
      e.preventDefault();
      clear_attributes()
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
               url: "{{ route('bp_form205.update') }}",
               data: {
                  '_token': '{{ csrf_token() }}',
                  'id' : bp_form205_id,
                  'retirement_law_id' : $('#retirement_law_id').val(),
                  'emp_code' : $('#retiree_emp_code').val(),
                  'position_id_at_retirement_date' : $('#position_id_at_retirement_date').val(),
                  'highest_monthly_salary' : $('#highest_monthly_salary').val(),
                  'sl_credits_earned' : $('#sl_credits_earned').val(),
                  'vl_credits_earned' : $('#vl_credits_earned').val(),
                  'leave_amount' : $('#leave_amount').val(),
                  'total_creditable_service' : $('#total_creditable_service').val(),
                  'num_gratuity_months' : $('#num_gratuity_months').val(),
                  'gratuity_amount' : $('#gratuity_amount').val(),
               },
               success:function(data) {
                  console.log(data);
                  if(data.errors) {         
                     if(data.errors.retirement_law_id){
                        $('#retirement_law_id').addClass('is-invalid');
                        $('#bp-form205-retirement-law-error').html(data.errors.retirement_law_id[0]);
                     }
                     if(data.errors.emp_code){
                        $('#retiree_emp_code').addClass('is-invalid');
                        $('#bp-form205-name-error').html(data.errors.emp_code[0]);
                     }
                     if(data.errors.position_id_at_retirement_date){
                        $('#position_id_at_retirement_date').addClass('is-invalid');
                        $('#bp-form205-position-error').html(data.errors.position_id_at_retirement_date[0]);
                     }
                     if(data.errors.highest_monthly_salary){
                        $('#highest_monthly_salary').addClass('is-invalid');
                        $('#bp-form205-salary-error').html(data.errors.highest_monthly_salary[0]);
                     } 
                     if(data.errors.sl_credits_earned){
                        $('#sl_credits_earned').addClass('is-invalid');
                        $('#bp-form205-sl-error').html(data.errors.sl_credits_earned[0]);
                     }
                     if(data.errors.vl_credits_earned){
                        $('#vl_credits_earned').addClass('is-invalid');
                        $('#bp-form205-vl-error').html(data.errors.vl_credits_earned[0]);
                     }
                     if(data.errors.leave_amount){
                        $('#leave_amount').addClass('is-invalid');
                        $('#bp-form205-leave-amount-error').html(data.errors.leave_amount[0]);
                     }   
                     if(data.errors.total_creditable_service){
                        $('#total_creditable_service').addClass('is-invalid');
                        $('#bp-form205-gratuity-service-error').html(data.errors.total_creditable_service[0]);
                     }
                     if(data.errors.num_gratuity_months){
                        $('#num_gratuity_months').addClass('is-invalid');
                        $('#bp-form205-gratuity-months-error').html(data.errors.num_gratuity_months[0]);
                     }
                     if(data.errors.gratuity_amount){
                        $('#gratuity_amount').addClass('is-invalid');
                        $('#bp-form205-gratuity-amount-error').html(data.errors.gratuity_amount[0]);
                     }                             
                  }
                  if(data.success) {            
                     Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Record has been successfully edited.',
                        showConfirmButton: false,
                        timer: 1500
                     }) 
                     $('#bp_form205_modal').modal('toggle')
                     window.location.reload();
                     $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
                        var id = $(e.target).attr("href").substr(1);
                        window.location.hash = id;
                     });
                     var hash = window.location.hash;
                     $('#fy_tabs a[href="' + hash + '"]').tab('show');
                  }                                        
               }                             
            });                                
         }       
      })   
   })  
{{-- edit end --}}

{{-- delete start --}}
   $('.btn_delete_bp_form205').on('click', function(e){
      bp_form205_id = $(this).data('id');
      delete_bp_form205(bp_form205_id);
   })

   function delete_bp_form205(bp_form205_id){
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
            url: "{{ route('bp_form205.delete') }}",
            data: {
               '_token': '{{ csrf_token() }}',
               'id' : bp_form205_id
            },
            success: function(data) {      
               Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: 'Record has been successfully deleted.',
                  showConfirmButton: false,
                  timer: 1500
               }) 
               window.location.reload();
               $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
                  var id = $(e.target).attr("href").substr(1);
                  window.location.hash = id;
               });
               var hash = window.location.hash;
               $('#fy_tabs a[href="' + hash + '"]').tab('show');   
            }             
         })    
         }       
      })
   }
{{-- delete end --}} 

{{-- retiree last position dropdown --}}
   $('#position_id_at_retirement_date').on('select2:opening', function(e){
      if($('#retiree_emp_code').val() == '' || $('#retiree_emp_code').val() == null){
      display_notification_content('Please select employee first!')
      return false;
      }
   })

   function view_position(emp_code, position){
      $('#position_id_at_retirement_date > option:not(:first-child):not(:nth-child(1))')
      .remove()
   
      var request_position = view_position_by_emp_code(emp_code);
      request_position.then(function (data) {
      jQuery.each(data['positions'], function() {
         $('#position_id_at_retirement_date').append('<option value="'+this.id+'">'+this.position+'</option>')
      })      
      $('#retiree_emp_code').val(emp_code).change();
      $('#position_id_at_retirement_date').val(position).change();
      })
   }

   function view_position_by_emp_code(emp_code){
      var request = $.ajax({
      method: "GET",
      url: "{{ route('show_position_by_emp_code') }}",
      data: {
         '_token': '{{ csrf_token() }}',
         'emp_code' : emp_code
      }
      });
      return request;
   }

   $('#retiree_emp_code').on('select2:select', function(e){  
      $('#position_id_at_retirement_date')
      .val('')
      .change()
      $('#position_id_at_retirement_date > option:not(:first-child):not(:nth-child(1))')
      .remove()
      emp_code = $('#retiree_emp_code').val();
      
      var request = view_position_by_emp_code(emp_code);
      request.then(function(data) {
      jQuery.each(data['positions'], function() {
         $('#position_id_at_retirement_date').append('<option value="'+this.position_id+'">'+this.position_desc+'</option>')
      })
      emp_code = '';
      })
   })
{{-- retiree last position dropdown end--}}   