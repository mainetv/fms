{{-- modal start --}}
   $('#bp_form3_modal').on('hide.bs.modal', function(){  
      init_view_bp_form3();   
      clear_attributes();
      clear_fields();
   });  
   $('#bp_form3_modal').on('shown.bs.modal', function () {
      $('#bp_form3_description').focus();
   })  
{{-- modal end --}}

{{-- view start --}}   
   function init_view_bp_form3(){
      $('.bp-form3-field')
         .val('')
         .attr('disabled', true);

      $('.save-buttons')
         .removeClass('d-inline')
         .addClass('d-none')
         .attr('disabled', true);
   }

   function view_bp_form3(bp_form3_id){
      var request = $.ajax({
         method: "GET",
         url: "{{ route('bp_form3.show') }}",
         data: {
         '_token': '{{ csrf_token() }}',
         'id' : bp_form3_id
         }
      });
      return request;
   }

   $('.btn_view_bp_form3').on('click', function(e){    
      $('#bp_form3_modal_header').html("View BP Form No. 3"); 
      bp_form3_id = $(this).data('id');
      init_view_bp_form3();   
      var request = view_bp_form3(bp_form3_id);   
      request.then(function(data) {
         if(data['status'] == 1){            
            $('#bp_form3_tier').val(data['bp_form3']['tier']) 
            $('#bp_form3_description').val(data['bp_form3']['description']) 
            $('#bp_form3_area_sqm').val(data['bp_form3']['area_sqm']) 
            $('#bp_form3_location').val(data['bp_form3']['location']) 
            $('#bp_form3_amount').val(data['bp_form3']['amount']) 
            $('#bp_form3_justification').val(data['bp_form3']['justification']) 
            $('#bp_form3_remarks').val(data['bp_form3']['remarks'])
         }                          
      })
      $('#bp_form3_modal').modal('toggle');
   })  
{{-- view end --}}

{{-- add start --}}
   function init_add_bp_form3(){
      $('.bp-form3-field')
         .attr('disabled', false);
         
      $('.add_bp_form3.save-buttons')
         .addClass('d-inline')
         .removeClass('d-none')
         .attr('disabled', false);      
   }

   $('.btn_add_bp_form3').on('click', function(){    
      init_add_bp_form3();
      var division_id=$(this).data('division-id');      
      var year=$(this).data('year');      
      var fiscal_year=$(this).data('fy');  
      $('#bp_form3_year').val(year);
      $('#bp_form3_fiscal_year').val(fiscal_year);
      $('#bp_form3_modal_header').html("Add BP Form No. 3");
      $('#bp_form3_modal').modal('toggle')       
   })

   $('.add_bp_form3').on('click', function(e){        
      e.prevenDefault;  
      clear_attributes();
      $.ajax({
         method: "POST",
         url: "{{ route('bp_form3.store') }}",
         data: {
         '_token': '{{ csrf_token() }}',
         'division_id' : $('#bp_form3_division_id').val(),
         'year' : $('#bp_form3_year').val(),
         'tier' : $('#bp_form3_tier').val(),
         'fiscal_year' : $('#bp_form3_fiscal_year').val(),
         'description' : $('#bp_form3_description').val(),
         'area_sqm' : $('#bp_form3_area_sqm').val(),
         'location' : $('#bp_form3_location').val(),
         'amount' : $('#bp_form3_amount').val(),
         'justification' : $('#bp_form3_justification').val(),
         'remarks' : $('#bp_form3_remarks').val(),
         },
         success:function(data) {
            console.log(data);
            if(data.errors) {         
               if(data.errors.description){
                  $('#bp_form3_description').addClass('is-invalid');
                  $('#bp-form3-description-error').html(data.errors.description[0]);
               }   
               if(data.errors.area_sqm){
                  $('#bp_form3_area_sqm').addClass('is-invalid');
                  $('#bp-form3-area-sqm-error').html(data.errors.area_sqm[0]);
               } 
               if(data.errors.location){
                  $('#bp_form3_location').addClass('is-invalid');
                  $('#bp-form3-location-error').html(data.errors.location[0]);
               } 
               if(data.errors.amount){
                  $('#bp_form3_amount').addClass('is-invalid');
                  $('#bp-form3-amount-error').html(data.errors.amount[0]);
               } 
               if(data.errors.justification){
                  $('#bp_form3_justification').addClass('is-invalid');
                  $('#bp-form3-justification-error').html(data.errors.justification[0]);
               }                                
            }
            if(data.success) {
               Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: 'BP Form No. 3 has been successfully added.',
                  showConfirmButton: false,
                  timer: 1500
               }) 
               $('#bp_form3_modal').modal('toggle');  
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
   function init_edit_bp_form3(){
      init_view_bp_form3()
      $('.bp-form3-field')
         .attr('disabled', false);

      $('.edit_bp_form3.save-buttons')
         .addClass('d-inline')
         .removeClass('d-none')
         .attr('disabled', false);
   }

   $('.btn_edit_bp_form3').on('click', function(e){  
      init_edit_bp_form3();
      bp_form3_id = $(this).data('id');
      $('#bp_form3_modal_header').html("Edit BP Form No. 3");     
      var request = view_bp_form3(bp_form3_id);
      request.then(function(data) {
         if(data['status'] == 1){                 
            $('#bp_form3_tier').val(data['bp_form3']['tier']) 
            $('#bp_form3_description').val(data['bp_form3']['description']) 
            $('#bp_form3_area_sqm').val(data['bp_form3']['area_sqm']) 
            $('#bp_form3_location').val(data['bp_form3']['location']) 
            $('#bp_form3_amount').val(data['bp_form3']['amount']) 
            $('#bp_form3_justification').val(data['bp_form3']['justification']) 
            $('#bp_form3_remarks').val(data['bp_form3']['remarks'])
         }           
      })
      $('#bp_form3_modal').modal('toggle')            
   })

   $('.edit_bp_form3').on('click', function(e){
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
               url: "{{ route('bp_form3.update') }}",
               data: {
                  '_token': '{{ csrf_token() }}',
                  'id' : bp_form3_id,
                  'tier' : $('#bp_form3_tier').val(),
                  'description' : $('#bp_form3_description').val(),
                  'area_sqm' : $('#bp_form3_area_sqm').val(),
                  'location' : $('#bp_form3_location').val(),
                  'amount' : $('#bp_form3_amount').val(),
                  'justification' : $('#bp_form3_justification').val(),
                  'remarks' : $('#bp_form3_remarks').val(),
               },
               success:function(data) {
                  console.log(data);
                  if(data.errors) {         
                     if(data.errors.description){
                        $('#bp_form3_description').addClass('is-invalid');
                        $('#bp-form3-description-error').html(data.errors.description[0]);
                     }   
                     if(data.errors.area_sqm){
                        $('#bp_form3_area_sqm').addClass('is-invalid');
                        $('#bp-form3-area-sqm-error').html(data.errors.area_sqm[0]);
                     } 
                     if(data.errors.location){
                        $('#bp_form3_location').addClass('is-invalid');
                        $('#bp-form3-location-error').html(data.errors.location[0]);
                     } 
                     if(data.errors.amount){
                        $('#bp_form3_amount').addClass('is-invalid');
                        $('#bp-form3-amount-error').html(data.errors.amount[0]);
                     } 
                     if(data.errors.justification){
                        $('#bp_form3_justification').addClass('is-invalid');
                        $('#bp-form3-justification-error').html(data.errors.justification[0]);
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
                     $('#bp_form3_modal').modal('toggle')
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
   $('.btn_delete_bp_form3').on('click', function(e){
      bp_form3_id = $(this).data('id');
      delete_bp_form3(bp_form3_id);
   })

   function delete_bp_form3(bp_form3_id){
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
            url: "{{ route('bp_form3.delete') }}",
            data: {
               '_token': '{{ csrf_token() }}',
               'id' : bp_form3_id
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