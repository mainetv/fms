{{-- START --}}
  function togglePayeeFields(disableAll = false) {
    let payeeType = $('input[name="payee_type_id"]:checked').val();
    $('.payee-field').prop('disabled', disableAll);
    if (!disableAll) {
      if (payeeType == "1") {
            $('#individual').prop('checked', true);
            $('.individual').removeClass('d-none').find('input').prop('disabled', false);
            $('.organization').addClass('d-none').find('input').prop('disabled', true).val('');
      } else if (payeeType == "2") {
            $('#organization').prop('checked', true);
            $('.organization').removeClass('d-none').find('input').prop('disabled', false);
            $('.individual').addClass('d-none').find('input').prop('disabled', true).val('');
      } else {
          $(".organization, .individual").addClass("d-none").find("input").prop("disabled", true).val('');
      }
    }
  }        

  $('input[name="payee_type_id"]').change(function() {
    togglePayeeFields(false);
  });

  $('input[name="payee_type_id"]').prop('disabled', false);
  
  $('#payee_modal').on('show.bs.modal', function () {
    $('.is-invalid').removeClass('is-invalid');
    $('.error').html('');
  });

  const requiredFields = [
      { id: 'payee_type_id', event: 'change', isRadio: true },
      { id: 'first_name', event: 'input'},
      { id: 'last_name', event: 'input'},
      { id: 'organization_name', event: 'input'},
      { id: 'tin', event: 'input'},
      { id: 'bank_id', event: 'change', isSelect: true },
      { id: 'bank_account_name', event: 'input'},
      { id: 'bank_account_no', event: 'input'},
  ];

  requiredFields.forEach(field => {
      $(`#${field.id}`).on(field.event, function() {
          validateField($(this), field.isSelect);
      });
  }); 

  function validateField($element, isSelect = false) {
    const feedbackElement = `#${$element.attr('id')}-feedback`;
    let value = $element.val();

    if (isSelect) {
       value = $element.val() && $element.val() !== "";
    } else {
       value = value.trim();
    }

    if (value) {
       if (isSelect) {
             $element.next('span').removeClass('is-invalid');
       } else {
             $element.removeClass('is-invalid');
       }
       $(feedbackElement).html('');
    } else {
       if (isSelect) {
             $element.next('span').addClass('is-invalid');
       } else {
             $element.addClass('is-invalid');
       }
    }
  }

  function actionButtons(id, payeeWasUsed, isVerified) {
    let buttons = `<center style="white-space:nowrap">
      <button type="button" class="btn_view btn btn-xs1 btn-outline-dark" data-id="${id}" title="View Payee"
            data-toggle="tooltip" data-placement="auto">
            <i class="fa fa-eye"></i>
      </button>&nbsp;
      <button type="button" class="btn_add_child btn btn-xs1 btn-outline-primary" data-id="${id}" title="Add New Payee"
          data-toggle="tooltip" data-placement="auto">
          <i class="fa fa-plus"></i>
      </button>`;

    if (isVerified != 1 && !payeeWasUsed) {
      buttons += `&nbsp;<button type="button" class="btn_verify btn btn-xs1 btn-outline-primary" data-id="${id}" title="Verify Payee"
                    data-toggle="tooltip" data-placement="auto">
                    <i class="fa-solid fa-user-check"></i>
                  </button>
                  &nbsp;<button type="button" class="btn_edit btn btn-xs1 btn-outline-success" data-id="${id}" title="Edit Payee"
                      data-toggle="tooltip" data-placement="auto">
                      <i class="fa fa-edit"></i>
                  </button>&nbsp;
                  <button type="button" class="btn_delete btn btn-xs1 btn-outline-danger" data-id="${id}" title="Delete Payee"
                      data-toggle="tooltip" data-placement="auto">
                      <i class="fa fa-trash"></i>
                  </button>`;
    }

    buttons += `</center>`;
    return buttons;
  }

  function loadRecords(){	
      var tbl_payees = $('#tbl_payees').DataTable({
        destroy: true,
        info: true,
        dom: '<"row"<"col-lg-1"l><"col-md-11"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>',
        fixedColumns: true,
        processing: true,
        responsive: true,
        paging: true,
        order: [[5, "asc"]], 
        ajax: {
            url: "{{ route('listPayees') }}",
            method: "GET",
            data : {
              '_token': '{{ csrf_token() }}',
            },    
        },
        rowId: 'id',
        columns: [ 
            { 
              data: null,
              className: "dt-head-center dt-body-left",
              render: function(data, type, row) {
                  return row?.payee ?? '';
              }
            }, 
            { 
              data: null,
              render: function(data, type, row) {
                  return row?.tin ?? '';
              }
            }, 
            { 
              data: null,
              render: function(data, type, row) {
                  return row?.bank?.bank_acronym ?? '';
              }
            }, 
            { 
              data: null,
              render: function(data, type, row) {
                  return row?.bank_account_name ?? '';
              }
            },           
            { 
              data: null,
              render: function(data, type, row) {
                  return row?.bank_account_no ?? '';
              }
            },
            { 
              data: null,
              render: function(data, type, row) {
                  let badgeClass = row?.is_verified == 1 ? "badge-primary" : "badge-danger";
                  let text = row?.is_verified == 1 ? "Yes" : "No";
                  return `<span class="badge-pill ${badgeClass}">${text}</span>`;
              }
            },
            { 
              data: null,
              render: function(data, type, row) {
                  let badgeClass = row?.is_active == 1 ? "badge-primary" : "badge-danger";
                  let text = row?.is_active == 1 ? "Yes" : "No";
                  return `<span class="badge-pill ${badgeClass}">${text}</span>`;
              }
            },
            { 
                data: "id",
                orderable: false,
                render: function(data, type, row) {
                    return actionButtons(row.id, row.payeeWasUsed, row.is_verified);
                }
            },             		
        ],
        drawCallback: function() {
            $('[data-toggle="tooltip"]').tooltip();
        }
      });
  }

  function view(id){
      var request = $.ajax({
        method: "GET",
        url: '{{ route('utilities.payee.show', ':id') }}'.replace(':id', id),
        data: {
            '_token': '{{ csrf_token() }}',
            'id' : id
        }
      });
      return request;
  }

  $('#btn_add').click(function (e) {
    e.preventDefault(); 
    $('.add').removeClass('d-none');   
    $('.update').addClass('d-none');  
    $('.verify').addClass('d-none');     
    $('#payee_modal_header').html("Add Payee");
    $('input[name="payee_type_id"]').prop('disabled', false).prop('checked', false);
    $('#is_active').prop('checked', true);
    togglePayeeFields(false);
    $('#payee_modal').modal('toggle');  
  });

  $('#tbl_payees').on('click', '.btn_add_child', function (e) {
    e.preventDefault(); 
    var id = $(this).data('id'); 
    $('.add').removeClass('d-none');   
    $('.update').addClass('d-none');  
    $('.verify').addClass('d-none');     
    $('#payee_modal_header').html("Add Payee");
    view(id).then(response => {
       Object.keys(response).forEach(key => {
          let field = $(`#${key}`);
          if (field.is(':checkbox')) {
             field.prop('checked', response[key] == 1);
          } else {
             field.val(response[key] || '');
          }
       });

       let payeeTypeInput = $(`input[name="payee_type_id"][value="${response.payee_type_id}"]`);
       payeeTypeInput.prop('checked', true).trigger('change');

       $('input[name="payee_type_id"]').each(function() {
          $(this).attr('readonly', true).css({
             'pointer-events': 'none', // Prevents clicking
             'opacity': '0.5' // Grays out
          });
       });

       togglePayeeFields(false); // Enable only the relevant fields
    });     

    $('#payee_modal').modal('toggle');  
  });

  $('#frm_payee').on('click', '.add', function (e) {
    $.ajax({
       method: 'POST',
       url: '{{ route('utilities.payee.store') }}',       
       data: $('#frm_payee').serializeArray(),           
       success:function(response) {
          loadRecords();    
          $('#payee_modal').modal('toggle');                                     
          Swal.fire({
             position: 'top-end',
             icon: 'success',
             title: 'Payee successfully added.',
             showConfirmButton: false,
             timer: 1500
          })  
       },
       error: function (xhr) {
          var response = JSON.parse(xhr.responseText);
          
          $('.is-invalid').removeClass('is-invalid'); 
          $('.error').html('');

          $.each(response.errors, function(field, messages) {
             var element = $('#' + field);
             var feedbackElement = $('#' + field + '-feedback');

             if (element.length) {
                   element.addClass('is-invalid');
                   feedbackElement.html(messages[0]).show();
             }
          });

          // Scroll to first error field
          var $firstErrorField = $('.is-invalid:first');
          if ($firstErrorField.length) {
             $('html, body').animate({ scrollTop: $firstErrorField.offset().top - 100 }, 'slow');
          }
       }
    });              
  });

  function saveUpdate(action, id){
    $.ajax({
      method: 'PATCH',
      url: '{{ route('utilities.payee.update', ':id') }}'.replace(':id', id),
      data: $('#frm_payee').serializeArray().concat([
          { name: 'action', value: action },
      ]),
      success:function(response) {      
          loadRecords();  
          $('#payee_modal').modal('toggle');                                     
          Swal.fire({
            position: 'top-end',  
            icon: 'success',
            title: response.message,
            showConfirmButton: false,
            timer: 1500
          })  
      }, 
    }); 
  }

  $('#tbl_payees').on('click', '.btn_verify', function (e) {
    e.preventDefault(); 
    var id = $(this).data('id'); 
    $('#payee_modal_header').html("Verify Payee");
    $('.add').addClass('d-none');   
    $('.update').addClass('d-none');  
    $('.verify').removeClass('d-none');  
    view(id).then(response => {
      Object.keys(response).forEach(key => {
         let field = $(`#${key}`);
         if (field.is(':checkbox')) {
            field.prop('checked', response[key] == 1);
         } else {
            field.val(response[key] || '');
         }
      });

      $(`input[name="payee_type_id"][value="${response.payee_type_id}"]`).prop('checked', true).trigger('change');
      togglePayeeFields(true);      
   });      
   $('#payee_modal').modal('toggle'); 
  });

  $('#tbl_payees').on('click', '.btn_edit', function (e) {
    e.preventDefault(); 
    var id = $(this).data('id'); 
    $('#payee_modal_header').html("Edit Payee");
    $('.add').addClass('d-none');   
    $('.update').removeClass('d-none');  
    $('.verify').addClass('d-none');    
    view(id).then(response => {
       Object.keys(response).forEach(key => {
          let field = $(`#${key}`);
          if (field.is(':checkbox')) {
             field.prop('checked', response[key] == 1);
          } else {
             field.val(response[key] || '');
          }
       });
       $('input[name="payee_type_id"]').each(function() {
          $(this).prop('disabled', false).attr('readonly', false).css({
             'pointer-events': 'auto',
             'opacity': '1'
          });
       });

       $(`input[name="payee_type_id"][value="${response.payee_type_id}"]`)
          .prop('checked', true)
          .trigger('change');
       togglePayeeFields(false); // Enable only the relevant fields
    });     

    $('#payee_modal').modal('toggle');  
  });

  $('#frm_payee').on('click', '.update', function (e) {
      e.preventDefault();    
      var id = $('#frm_payee #id').val();
      var action = 'update';
      Swal.fire({
        title: 'Are you sure you want to save changes?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      })
      .then((result) => {        
        if (result.value) {   
          saveUpdate(action, id);                    
        }       
      })    
  });

  $('#frm_payee').on('click', '.verify', function (e) {   
    e.preventDefault();    
    var id = $('#frm_payee #id').val();
    var action = 'verify';
    Swal.fire({
      title: 'Are you sure you want to verify this payee?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes'
    })
    .then((result) => {        
      if (result.value) {        
        saveUpdate(action, id);                                     
      }       
    })    
  });

  $('#tbl_payees').on('click', '.btn_view', function (e) {
    e.preventDefault(); 
    var id = $(this).data('id');    
    $('#payee_modal_header').html("View Payee");           
    $('.save-buttons').addClass('d-none');         
    view(id).then(response => {
       Object.keys(response).forEach(key => {
             let field = $(`#${key}`);
             if (field.is(':checkbox')) {
                field.prop('checked', response[key] == 1);
             } else {
                field.val(response[key] || '');
             }
       });

       $(`input[name="payee_type_id"][value="${response.payee_type_id}"]`).prop('checked', true).trigger('change');
       togglePayeeFields(true); // Disable all fields
    });     

    $('#payee_modal').modal('toggle');      
  });

  $('#tbl_payees').on('click', '.btn_delete', function (e) {
      e.preventDefault(); 
      var id = $(this).data('id'); 
      Swal.fire({
        title: 'Are you sure you want to delete this payee?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes'
      })
      .then((result) => {        
        if (result.value) {          
            $.ajax({
            method: 'DELETE', 
            url: '{{ route('utilities.payee.destroy', ':id') }}'.replace(':id', id),
            data: { id:id },
            success:function(response) {      
              loadRecords();                         
              Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: response.message,
                  showConfirmButton: false,
                  timer: 1500
              })  
            },  
            error: function (xhr, status, error) {
              Swal.fire({
                  position: 'top-end',
                  icon: 'error',
                  title: response.message,
                  showConfirmButton: false,
                  timer: 1500
              });
            }  
            });                                      
        }       
      })  
  }); 
  
  loadRecords();
{{-- END --}}

