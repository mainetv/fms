{{-- table start --}}
  var library_payees_table = $('#library_payees_table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    autoWidth: false,
    stateSave: true,
    lengthMenu: [ [10, 25, 50, -1], [25, 50, 75, "All"] ],
    dom: 'Bfrltip',
    ajax: {
      url: "{{ route('library_payees.table') }}",
      method: "GET",
      data : {
      '_token': '{{ csrf_token() }}'
      }
    },        
    order: [[ 0, 'desc' ]],
    columns: [      
      {data: 'id', visible: false},
      {data: 'payee', title: 'Payee'},
      {data: 'tin', title: 'TIN'},
      {data: 'bank', title: 'Bank'},
      {data: 'bank_branch', title: 'Bank Branch'},
      {data: 'bank_account_name', title: 'Bank Account Name'},
      {data: 'bank_account_no', title: 'Bank Account No'},
      {data: 'address', title: 'Address'},
      {data: 'is_active', title: 'Is Active',
        render: function (data, type, row) {
        if (type === 'display' || type === 'filter' ) {
          return data=='1' ? 'Yes' : 'No';
        }
          return data;
        }
      },
      {data: 'action', orderable: false, searchable: false}          
    ],
    buttons: [
      "copy", "excel", "pdf", "print", "colvis"
    ],
  });
{{-- table end --}}

{{-- START --}}
  {{-- modal start --}}
    $('#library_payees_modal').on('hide.bs.modal', function(){       
      clear_attributes();
      clearFields
      $('.payee_type')
        .removeClass('d-inline')
        .addClass('d-none')
        .attr('disabled', true)
        .attr('checked', true);
      $('.all')
        .removeClass('d-inline')
        .addClass('d-none')
        .attr('disabled', true)
        .attr('checked', true);
    });  

    $('#library_payees_modal').on('shown.bs.modal', function () {
      var payee_type = false;
      document.getElementByName("payee_type").checked = false;     
    })  
  
    $('#parent_id').on('change', function(){ 
      var parent_id = $(this).val();  
      if(parent_id==0){       
        $('.payee_type')
          .addClass('d-inline')
          .removeClass('d-none')
          .attr('disabled', true)
          .attr('checked', false);
        $('.all')
          .addClass('d-inline')
          .removeClass('d-none')
          .attr('disabled', true)
          .attr('checked', false);
        $('.organization')
          .removeClass('d-inline')
          .addClass('d-none')
          .attr('disabled', true);
        $('.individual')
          .removeClass('d-inline')
          .addClass('d-none')
          .attr('disabled', true);
        $('#is_active').prop('checked', true);    
        $('input[type=radio]').prop("checked", false);
        $("input[type=text]").val('');
        $("textarea").val('');
      }
      else{
        var payee_type_id = $(this).find(':selected').data('payeetypeid');
        var first = $(this).find(':selected').data('first');
        var mi = $(this).find(':selected').data('mi');
        var last = $(this).find(':selected').data('last');
        var suffix = $(this).find(':selected').data('suffix');
        var org = $(this).find(':selected').data('org');
        var orgacr = $(this).find(':selected').data('orgacr');
        var tin = $(this).find(':selected').data('tin');
        var bankid = $(this).find(':selected').data('bankid');
        var bankbranch = $(this).find(':selected').data('bankbranch');
        var bankaccntname = $(this).find(':selected').data('bankaccntname');
        var bankaccntno = $(this).find(':selected').data('bankaccntno');
        var address = $(this).find(':selected').data('address');
        var office = $(this).find(':selected').data('office');
        var email = $(this).find(':selected').data('email');
        var contact = $(this).find(':selected').data('contact');        
        var active = $(this).find(':selected').data('active');        
        
        $('.payee_type')
          .removeClass('d-inline')
          .addClass('d-none')
          .attr('disabled', true)
          .attr('checked',false);       
        if(payee_type_id==1){                  
          $('#first_name').val(first);       
          $('#middle_initial').val(mi);        
          $('#last_name').val(last);   
          $('#suffix').val(suffix);   
          $('.individual')
            .addClass('d-inline')
            .removeClass('d-none')
            .attr('disabled', false);
          $('.organization')
            .removeClass('d-inline')
            .addClass('d-none')
            .attr('disabled', true);
        }
        else{         
          $('#organization_name').val(org);  
          $('#organization_acronym').val(orgacr);  
          $('.organization')
            .addClass('d-inline')
            .removeClass('d-none')
            .attr('disabled', false);
          $('.individual')
            .removeClass('d-inline')
            .addClass('d-none')
            .attr('disabled', true);
        }      
        $('#payee_type_id').val(payee_type_id); 
        $('#tin').val(tin);       
        $('#bank_id').each(function() {
          $(this).val(bankid).change();
        });
        $('#bank_branch').val(bankbranch);
        $('#bank_account_name').val(bankaccntname);
        $('#bank_account_no').val(bankaccntno);
        $('#address').val(address);
        $('#office_address').val(office);
        $('#email_address').val(email);
        $('#contact_no').val(contact);
        $('#contact_no').val(contact);
        if(active == 1) {
          $('#is_active').iCheck('check'); 
        } 
        $('.all')
          .addClass('d-inline')
          .removeClass('d-none')
          .attr('disabled', false);
      }
    })
    
    $('input[name="payee_type"]').click(function(){
      var payee_type_id = $(this).val();
      $('#payee_type_id').val(payee_type_id);
      if( payee_type_id == "1")
      {
        $('.individual')
          .addClass('d-inline')
          .removeClass('d-none')
          .attr('disabled', false);
        $('.organization')
          .removeClass('d-inline')
          .addClass('d-none')
          .attr('disabled', true);
      }
      else{
        $('.organization')
          .addClass('d-inline')
          .removeClass('d-none')
          .attr('disabled', false);
        $('.individual')
          .removeClass('d-inline')
          .addClass('d-none')
          .attr('disabled', true);
      }
    });
  {{-- modal end --}}

  {{-- add start --}}
    function init_add(){
      $('.library-payee-field')
        .attr('disabled', false);
        
      $('.add_payee.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);  
      
      $('.parent_id')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);         
    }

    $('.btn_add').on('click', function(){ 
      init_add();         
      $('#library_payees_modal_header').html("Add Payee");
      $('#library_payees_modal').modal('toggle');    
    })

    $('.add_payee').on('click', function(e){
      e.prevenDefault;  
      $.ajax({
        method: "POST",
        url: "{{ route('library_payees.store') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'parent_id' : $('#parent_id').val(),
          'payee_type_id' : $('#payee_type_id').val(),
          'organization_name' : $('#organization_name').val(),
          'organization_acronym' : $('#organization_acronym').val(),
          'first_name' : $('#first_name').val(),
          'middle_initial' : $('#middle_initial').val(),
          'last_name' : $('#last_name').val(),
          'suffix' : $('#suffix').val(),
          'tin' : $('#tin').val(),
          'bank_id' : $('#bank_id').val(),
          'bank_branch' : $('#bank_branch').val(),
          'bank_account_name' : $('#bank_account_name').val(),
          'bank_account_no' : $('#bank_account_no').val(),
          'address' : $('#address').val(),
          'office_address' : $('#office_address').val(),
          'email_address' : $('#email_address').val(),
          'contact_no' : $('#contact_no').val(),
          'is_active' :  ($('#payee_is_active').iCheck('update')[0].checked ? 1  : 0),
        },
        success:function(data) {
          console.log(data);        
          if(data.errors) { 
            if(data.errors.first_name){
              $('#first_name').addClass('is-invalid');
              $('#first-error').html(data.errors.first_name[0]);
            } 
            if(data.errors.last_name){
              $('#last_name').addClass('is-invalid');
              $('#last-error').html(data.errors.last_name[0]);
            }  
            if(data.errors.organization_name){
              $('#organization_name').addClass('is-invalid');
              $('#organization-error').html(data.errors.organization_name[0]);
            }             
          }
          if(data.success) {
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Payee has been successfully added.',
              showConfirmButton: false,
              timer: 1500
            }) 
            $('#library_payees_modal').modal('toggle');
            $('#library_payees_table').DataTable().ajax.reload();
          }
        },
      });
    })
  {{-- add end    --}}

  {{-- view start --}}
    function init_view_payee(){
      $('.save-buttons')
        .removeClass('d-inline')
        .addClass('d-none')
        .attr('disabled', true);

      $('.library-payee-field')
        .attr('disabled', true);

      $('.parent_id')
        .removeClass('d-inline')
        .addClass('d-none')
        .attr('disabled', true);  

      $('.all')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', true)
        .attr('checked', false);
    }

    function view_payee(payee_id){
      var request = $.ajax({
        method: "GET",
        url: "{{ route('payee.show') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'id' : payee_id
        }
      });
      return request;
    }
  {{-- view end --}}

  {{-- update start --}}
    function init_edit_payees(){      
      init_view_payee();
      $('.library-payee-field')
        .attr('disabled', false);

      $('.edit_payee.save-buttons')
        .addClass('d-inline')
        .removeClass('d-none')
        .attr('disabled', false);
    }

    $('.edit_payee').on('click', function(e){
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
            url: "{{ route('library_payees.update') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'id' : $('#payee_id').val(),
              'payee_type_id' : $('#payee_type_id').val(),
              'organization_name' : $('#organization_name').val(),
              'organization_acronym' : $('#organization_acronym').val(),
              'first_name' : $('#first_name').val(),
              'middle_initial' : $('#middle_initial').val(),
              'last_name' : $('#last_name').val(),
              'suffix' : $('#suffix').val(),
              'tin' : $('#tin').val(),
              'bank_id' : $('#bank_id').val(),
              'bank_branch' : $('#bank_branch').val(),
              'bank_account_name' : $('#bank_account_name').val(),
              'bank_account_no' : $('#bank_account_no').val(),
              'address' : $('#address').val(),
              'office_address' : $('#office_address').val(),
              'email_address' : $('#email_address').val(),
              'contact_no' : $('#contact_no').val(),
              'is_active' :  ($('#payee_is_active').iCheck('update')[0].checked ? 1  : 0),
            },
            success:function(data) {
              console.log(data);
              if(data.success) {
                Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: 'Payee has been successfully updated.',
                  showConfirmButton: false,
                  timer: 1500
                })                        
                $('#library_payees_modal').modal('toggle')  
                $('#library_payees_table').DataTable().ajax.reload();
              }                      
            }                             
          });                                
        }       
      })   
    })

    $('#library_payees_table').on('click', '.btn_edit_payee', function(e){
      $('#library_payees_modal_header').html("Edit Payee");         
      init_edit_payees();
      payee_id = $(this).parents('tr').data('id');
      var request = view_payee(payee_id);
      request.then(function(data) {
        if(data['status'] == 1){
          if( data['library_payees']['payee_type_id'] == 1)
          {
            $('.individual')
              .addClass('d-inline')
              .removeClass('d-none')
              .attr('disabled', false);
            $('.organization')
              .removeClass('d-inline')
              .addClass('d-none')
              .attr('disabled', true);
          }
          else{
            $('.organization')
              .addClass('d-inline')
              .removeClass('d-none')
              .attr('disabled', false);
            $('.individual')
              .removeClass('d-inline')
              .addClass('d-none')
              .attr('disabled', true);
          }
          $('#payee_id').val(data['library_payees']['id'])   
          $('#payee_type_id').val(data['library_payees']['payee_type_id'])   
          $('#organization_name').val(data['library_payees']['organization_name'])   
          $('#organization_acronym').val(data['library_payees']['organization_acronym'])   
          $('#first_name').val(data['library_payees']['first_name'])   
          $('#middle_initial').val(data['library_payees']['middle_initial'])   
          $('#last_name').val(data['library_payees']['last_name'])   
          $('#suffix').val(data['library_payees']['suffix'])   
          $('#tin').val(data['library_payees']['tin'])   
          $('#bank_id').val(data['library_payees']['bank_id'])   
          $('#bank_branch').val(data['library_payees']['bank_branch'])   
          $('#bank_account_name').val(data['library_payees']['bank_account_name'])   
          $('#bank_account_name1').val(data['library_payees']['bank_account_name1'])   
          $('#bank_account_name2').val(data['library_payees']['bank_account_name2'])   
          $('#bank_account_no').val(data['library_payees']['bank_account_no'])   
          $('#address').val(data['library_payees']['address'])   
          $('#office_address').val(data['library_payees']['office_address'])   
          $('#email_address').val(data['library_payees']['email_address'])   
          $('#contact_no').val(data['library_payees']['contact_no'])   
          if( data['library_payees']['is_active'] == 1)
          {
            $('#payee_is_active').iCheck('check'); 
          }
        }                      
      })    
      $('#library_payees_modal').modal('toggle')       
    })
  {{-- update end --}}

{{-- END --}}

