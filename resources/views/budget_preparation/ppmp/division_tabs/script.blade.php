
{{-- START --}}
  {{-- modal start --}}
    $('#pap_modal').on('hide.bs.modal', function(){       
      init_view_pap();
      clear_attributes();
      clear_fields();
    }); 

    $('#activity_modal').on('hide.bs.modal', function(){       
      init_view_activity();
      clear_attributes();
      clear_fields();
    });    

    $('#subactivity_modal').on('hide.bs.modal', function(){       
      init_view_subactivity();
      clear_attributes();
      clear_fields();
    });

    $('#expenditure_modal_activity').on('hide.bs.modal', function(){       
      init_view_expenditure_activity();
      clear_attributes();
      clear_fields();
    });

    $('#expenditure_modal_subactivity').on('hide.bs.modal', function(){       
      init_view_expenditure_subactivity();
      clear_attributes();
      clear_fields();
    });

    $('#pap_modal').on('shown.bs.modal', function () {
      $('#bp_pap_id').focus();
    }) 

    $('#activity_modal').on('shown.bs.modal', function () {
      $('#bp_activity_id').focus();
    }) 

    $('#pap_modal').on('show.bs.modal', function (e) { 
      var opener=e.relatedTarget;  
      var id=$(opener).data('id');    
      $('.modal-body').find('[name="budget_proposal_id"]').val(id);  
      init_add_pap();        
    });
   
    $('#activity_modal').on('show.bs.modal', function (e) { 
      var opener=e.relatedTarget;  
      var id=$(opener).data('id');    
      $('.modal-body').find('[name="bp_pap_id"]').val(id);  
      init_add_activity();        
    });

    $('#subactivity_modal').on('show.bs.modal', function (e) {
      var opener=e.relatedTarget;  
      var id=$(opener).data('id');    
      $('.modal-body').find('[name="budget_proposal_activity_id_forsubact"]').val(id);   
      init_add_subactivity();            
    });

    $('#expenditure_modal_activity').on('show.bs.modal', function (e) {
      var opener=e.relatedTarget;  
      var id=$(opener).data('id'); 
      $('.modal-body').find('[name="budget_proposal_activity_id_activity"]').val(id);  
      init_add_expenditure_activity();   
    });

    $('#expenditure_modal_subactivity').on('show.bs.modal', function (e) {
      var opener=e.relatedTarget;  
      var id=$(opener).data('id'); 
      $('.modal-body').find('[name="budget_proposal_subactivity_id_subactivity"]').val(id);    
      init_add_expenditure_subactivity();
    });

  {{-- modal end --}}

  {{-- view start --}}   
    function init_view_pap(){
      $('.pap-field')
        .val('')
        .attr('disabled', true);

      $('.save-buttons')
        .removeClass('d-inline')
        .addClass('d-none')
        .attr('disabled', true);
    }

    function init_view_activity(){
      $('.activity-field')
        .val('')
        .attr('disabled', true);

      $('.save-buttons')
        .removeClass('d-inline')
        .addClass('d-none')
        .attr('disabled', true);
    }

    function init_view_subactivity(){
      $('.subactivity-field')
        .val('')
        .attr('disabled', true);

      $('.save-buttons')
        .removeClass('d-inline')
        .addClass('d-none')
        .attr('disabled', true);
    }

    function init_view_expenditure_activity(){
      $('.expenditure-activity-field')
        .val('')
        .attr('disabled', true);

      $('.save-buttons')
        .removeClass('d-inline')
        .addClass('d-none')
        .attr('disabled', true);
    }

    function init_view_expenditure_subactivity(){
      $('.expenditure-subactivity-field')
        .val('')
        .attr('disabled', true);

      $('.save-buttons')
        .removeClass('d-inline')
        .addClass('d-none')
        .attr('disabled', true);
    }
  {{-- view end --}}

  {{-- add start --}}
    function init_add_pap(){
      $('.pap-field')
        .attr('disabled', false);
        
      $('#add_pap.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);      
    }

    function init_add_activity(){
      $('.activity-field')
        .attr('disabled', false);
        
      $('#add_activity.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);      
    }

    function init_add_subactivity(){
      $('.subactivity-field')
        .attr('disabled', false);
        
      $('#add_subactivity.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);      
    }

    function init_add_expenditure_activity(){
      $('.expenditure-activity-field')
        .attr('disabled', false);
        
      $('#add_expenditure_activity.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);      
    }

    function init_add_expenditure_subactivity(){
      $('.expenditure-subactivity-field')
        .attr('disabled', false);
        
      $('#add_expenditure_subactivity.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);      
    }

    $('#add_new_pap').on('click', function(){     
      init_add_pap();       
      var opener=e.relatedTarget;  
      var id=$(opener).data('id'); 
      $('.modal-body').find('[name="budget_proposal_id"]').val(id);
      $('#pap_modal').modal('toggle')       
    })

    $('#add_new_activity').on('click', function(){     
      init_add_activity();   
      var opener=e.relatedTarget;  
      var id=$(opener).data('id'); 
      $('.modal-body').find('[name="bp_pap_id"]').val(id);
      $('#activity_modal').modal('toggle')       
    })

    $('#add_new_subactivity').on('click', function(){     
      init_add_subactivity();              
      var opener=e.relatedTarget;  
      var id=$(opener).data('id'); 
      $('.modal-body').find('[name="budget_proposal_activity_id_forsubact"]').val(id);
      $('#subactivity_modal').modal('toggle')       
    })

    $('#add_new_expenditure_activity').on('click', function(){     
      init_add_expenditure_activity();  
      var opener=e.relatedTarget;  
      var id=$(opener).data('id'); 
      $('.modal-body').find('[name="budget_proposal_activity_id_activity"]').val(id);
      $('#expenditure_modal_activity').modal('toggle')       
    })

    $('#add_new_expenditure_subactivity').on('click', function(){     
      init_add_expenditure_subactivity(); 
      var opener=e.relatedTarget;  
      var id=$(opener).data('id'); 
      $('.modal-body').find('[name="budget_proposal_subactivity_id_subactivity"]').val(id); 
      $('#expenditure_modal_subactivity').modal('toggle')       
    })

    $('#add_pap').on('click', function(e){        
      e.prevenDefault;  
      clear_attributes();      
      $.ajax({
        method: "POST",
        url: "{{ route('division_proposals.postAction') }}",
        data: {
          '_token': '{{ csrf_token() }}',          
          'add_pap' : '1',
          'budget_proposal_id' : $('#budget_proposal_id').val(),
          'pap_code' : $('#bp_pap_id').val(),
        },
        success:function(data) {
          console.log(data);
          if(data.errors) {         
            if(data.errors.pap_code){
              $('#bp_pap_id').addClass('is-invalid');
              $('#pap-code-error').html(data.errors.pap_code[0]);
            }                          
          }
          if(data.success) {
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'PAP has been successfully added.',
              showConfirmButton: false,
              timer: 1500
            })   
            $('#pap_modal').modal('toggle');

            window.location.reload();
            $('#vert-tabs-tab a').click(function(e) {
              e.preventDefault();
              $(this).tab('show');
            });
  
            {{-- // store the currently selected tab in the hash value --}}
            $("div.nav-tabs > a").on("shown.bs.tab", function(e) {
                var id = $(e.target).attr("href").substr(1);
                window.location.hash = id;
            });
  
            {{-- // on load of the page: switch to the currently selected tab --}}
            var hash = window.location.hash;
            $('#vert-tabs-tab a[href="' + hash + '"]').tab('show');                    
          }
        },
      });
    })

    $('#add_activity').on('click', function(e){        
      e.prevenDefault;  
      clear_attributes();      
      $.ajax({
        method: "POST",
        url: "{{ route('division_proposals.postAction') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'add_activity' : '1',
          'year_selected' : $('#year_selected').val(),
          'bp_pap_id' : $('#bp_pap_id').val(),
          'activity_id' : $('#bp_activity_id').val(),
        },
        success:function(data) {
          console.log(data);
          if(data.errors) {         
            if(data.errors.activity_id){
              $('#bp_activity_id').addClass('is-invalid');
              $('#activity-id-error').html(data.errors.activity_id[0]);
            }                          
          }
          if(data.success) {
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Activity has been successfully added.',
              showConfirmButton: false,
              timer: 1500
            })             
            $('#activity_modal').modal('toggle')  
            location.reload();           
          }
        },
      });
    })

    $('#add_subactivity').on('click', function(e){        
      e.prevenDefault;  
      clear_attributes();      
      $.ajax({
        method: "POST",
        url: "{{ route('division_proposals.postAction') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'add_subactivity' : '1',
          'bp_activity_id' : $('#budget_proposal_activity_id_forsubact').val(),
          'subactivity_id' : $('#budget_proposal_subactivity_id').val(),
        },
        success:function(data) {
          console.log(data);
          if(data.errors) {         
            if(data.errors.subactivity_id){
              $('#budget_proposal_subactivity_id').addClass('is-invalid');
              $('#subactivity-id-error').html(data.errors.subactivity_id[0]);
            }                          
          }
          if(data.success) {
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Subactivity has been successfully added.',
              showConfirmButton: false,
              timer: 1500
            })             
            $('#subactivity_modal').modal('toggle') 
            window.location.reload();         
          }
        },
      });
    })

    $('#add_expenditure_activity').on('click', function(e){        
      e.prevenDefault;  
      clear_attributes();      
      $.ajax({
        method: "POST",
        url: "{{ route('division_proposals.postAction') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'add_expenditure_activity' : '1',
          'bp_activity_id' : $('#budget_proposal_activity_id_activity').val(),
          'expenditure_id' : $('#budget_proposal_object_expenditure_id_activity').val(),
          'fy1_amount' : $('#fy1_amount_activity').val(),
          'fy2_amount' : $('#fy2_amount_activity').val(),
          'fy3_amount' : $('#fy3_amount_activity').val(),
        },
        success:function(data) {
          console.log(data);
          if(data.errors) {         
            if(data.errors.expenditure){
              $('#budget_proposal_object_expenditure_id').addClass('is-invalid');
              $('#expenditure-id-error-activity').html(data.errors.expenditure[0]);
            }                          
          }
          if(data.success) {
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Expenditure has been successfully added.',
              showConfirmButton: false,
              timer: 1500
            })             
            $('#expenditure_modal_activity').modal('toggle') 
            window.location.reload();         
          }
        },
      });
    })

    $('#add_expenditure_subactivity').on('click', function(e){        
      e.prevenDefault;  
      clear_attributes();      
      $.ajax({
        method: "POST",
        url: "{{ route('division_proposals.postAction') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'add_expenditure_subactivity' : '1',
          'budget_proposal_subactivity_id' : $('#budget_proposal_subactivity_id_subactivity').val(),
          'expenditure_id' : $('#budget_proposal_object_expenditure_id_subactivity').val(),
          'fy1_amount' : $('#fy1_amount_subactivity').val(),
          'fy2_amount' : $('#fy2_amount_subactivity').val(),
          'fy3_amount' : $('#fy3_amount_subactivity').val(),
        },
        success:function(data) {
          console.log(data);
          if(data.errors) {         
            if(data.errors.expenditure){
              $('#budget_proposal_object_expenditure_id').addClass('is-invalid');
              $('#expenditure-id-error-activity').html(data.errors.expenditure[0]);
            }                          
          }
          if(data.success) {
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Expenditure has been successfully added.',
              showConfirmButton: false,
              timer: 1500
            })             
            $('#expenditure_modal_subactivity').modal('toggle') 
            window.location.reload();         
          }
        },
      });
    })
  {{-- add end    --}}

{{-- END --}}