let currentAction = 'clear'; 

const pageKey = window.location.pathname;

const savedValue = localStorage.getItem(`searchValue_${pageKey}`);
if (savedValue) {
  $("#search").val(savedValue);
  if (savedValue.trim() !== "") {
    loadRecords('search');
  } else {
    $('#tbl_payees').DataTable().clear().draw();
    localStorage.removeItem(`searchValue_${pageKey}`);
  }
} else {
  $('#tbl_payees').DataTable().clear().draw();
  localStorage.removeItem(`searchValue_${pageKey}`);
}

$("#search").on("input", function() {
  localStorage.setItem(`searchValue_${pageKey}`, $(this).val());
});

window.addEventListener("beforeunload", function () {
  const navType = performance.getEntriesByType("navigation")[0]?.type || "";

  if (navType !== "reload") {
    localStorage.removeItem(`searchValue_${pageKey}`);
  }
});

$("#search").focus(); 

$("#search").keypress(function (e) {
  if (e.which === 13) {
    e.preventDefault(); 
    $("#btn_search").click(); 
  }
});

function showLoader() {
  $('#loader').show();
}

function hideLoader() {
  $('#loader').hide();
}

function disableButtons(disable) {
  $('button[value]').prop('disabled', disable);
}

$('button[value]').click(function() {
  let action = $(this).val();

  if(action === 'clear') {
    $("#search").val('');
    localStorage.removeItem(`searchValue_${pageKey}`);

    disableButtons(true);
    showLoader();

    loadRecords(action);
    
    return; 
  }
  
  disableButtons(true);
  showLoader();
  loadRecords(action);
});

function loadRecords(action) {
  currentAction = action; 
  var search = $('#search').val();

  var tbl_payees = $('#tbl_payees').DataTable({
    destroy: true,
    info: true,
    dom: '<"row"<"col-lg-1"l><"col-md-11"f>>rt<"row"<"col-md-6 text-left"i><"col-md-6 text-right"p>>',
    fixedColumns: true,
    responsive: true,
    paging: true,
    order: [[2, "asc"]],
    ajax: {
      url: "{{ route('searchPayee') }}",
      method: "GET",
      data: {
        '_token': '{{ csrf_token() }}',
        'search': search,
        'action': action,  
      },
      complete: function() {
        disableButtons(false);
        hideLoader();
      },
      beforeSend: function() {
        showLoader();
      }
    },
    rowId: 'id',
    columns: [
      {
        data: null,
        render: function(data, type, row) {
          return row?.id ?? '';
        }
      },
      {
        data: null,
        render: function(data, type, row) {
          return row?.parent_id ?? '';
        }
      },
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
          return row?.bank?.bank ?? '';
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
        render: function (data, type, row) {
          let btnClass = row?.is_active == 1 ? "btn-success" : "btn-danger";
          let text = row?.is_active == 1 ? "Yes" : "No";
          let tooltipText = row?.is_active == 1 ? "Click to inactive" : "Click to active";

          return `<button type="button" class="btn_toggle_active btn btn-sm ${btnClass}" 
                    data-id="${row.id}" data-active="${row.is_active}" 
                    data-toggle="tooltip" data-placement="top" title="${tooltipText}">
                    ${text}
                  </button>`;
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

$("#first_name").autocomplete({
  source: function(request, response) {
    $.ajax({
      url: "{{ route('searchPayeeFirstName') }}",
      dataType: "json",
      data: {
        term: request.term
      },
      success: function(data) {
        response(data);
      },
      error: function(xhr, status, error) {
      }
    });
  },
  minLength: 1,
  select: function(event, ui) {
    $("#parent_id").val(ui.item.parent_id);
    $("#first_name").val(ui.item.first_name);
    $("#middle_initial").val(ui.item.middle_initial);
    $("#last_name").val(ui.item.last_name);
    $("#payee_parent_name").val(ui.item.value);
    return false;
  }
});

$("#organization_name").autocomplete({
  source: function(request, response) {
    $.ajax({
      url: "{{ route('searchPayeeOrganization') }}",
      dataType: "json",
      data: {
        term: request.term
      },
      success: function(data) {
        response(data);
      }
    });
  },
  minLength: 1,
  select: function(event, ui) {
    $("#organization_name").val(ui.item.organization_name);
    $("#organization_acronym").val(ui.item.organization_acronym);
    $("#parent_id").val(ui.item.parent_id);
    $("#payee_parent_name").val(ui.item.value);
    return false;
  }
});      

$('#first_name, #organization_name').on('input', function() {
  $('#parent_id, #payee_parent_name').val('');
});

$('#payee_modal').on('hidden.bs.modal', function() {
  $('#frm_payee')[0].reset();
  $(this).find('select').each(function () {
        $(this).prop('selectedIndex', 0).trigger('change');
    });
});

$('#payee_modal').on('show.bs.modal', function() {
  $('.is-invalid').removeClass('is-invalid');
  $('.invalid-feedback').html('');
});

$('input[name="payee_type_id"]').change(function() {
  togglePayeeFields(false);
  $('#payee_type_id').removeClass('is-invalid');
  $('#payee_type_id-feedback').html('');

  $('#parent_id').val('');
  $('#payee_parent_name').val('');
  $('#id').val('');
});

$('input[name="payee_type_id"]').prop('disabled', false);

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

@include('scripts.validation')

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
    buttons += `&nbsp;<button type="button" class="btn_edit btn btn-xs1 btn-outline-success" data-id="${id}" title="Edit/Verify Payee"
          data-toggle="tooltip" data-placement="auto">
          <i class="fa fa-edit"></i>
        </button>&nbsp;
        <button type="button" class="btn_delete btn btn-xs1 btn-outline-danger" data-id="${id}" title="Delete Payee"
          data-toggle="tooltip" data-placement="auto">
          <i class="fa fa-trash"></i>
        </button>`;
  }
  if (isVerified == 1 && !payeeWasUsed) {
    buttons += `&nbsp;<button type="button" class="btn_edit btn btn-xs1 btn-outline-success" data-id="${id}" title="Edit Payee"
          data-toggle="tooltip" data-placement="auto">
          <i class="fa fa-edit"></i>
        </button>&nbsp;`;
  }

  buttons += `</center>`;
  return buttons;
}

$('#tbl_payees').on('click', '.btn_toggle_active', function(e) {
  let button = $(this);
  let payeeId = button.data('id');
  let currentStatus = button.data('active');
  let newStatus = currentStatus == 1 ? 0 : 1;
  let action = 'toggleStatus';    

  $.ajax({
      url: "{{ route('utilities.payee.update', ':id') }}".replace(':id', payeeId),
      method: "PUT",
      data: JSON.stringify({
        id: payeeId,
        is_active: newStatus,
        action: action
      }),
      contentType: "application/json",
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (response) {
        button.data('active', newStatus);
        button.toggleClass('btn-success btn-danger');
        button.text(newStatus == 1 ? "Yes" : "No");

        let newTooltipText = newStatus == 1 ? "Click to inactive" : "Click to active";
        button.attr('title', newTooltipText).tooltip('dispose').tooltip();
        
        Swal.fire({
          position: 'top-end',  
          icon: 'success',
          title: response.message,
          showConfirmButton: false,
          timer: 1500
        }) 
      },        
  });
});

function view(id) {
  var request = $.ajax({
    method: "GET",
    url: '{{ route('utilities.payee.show', ':id') }}'.replace(':id', id),
    data: {
      '_token': '{{ csrf_token() }}',
      'id': id
    }
  });
  return request;
}

$('#btn_add').click(function(e) {
  e.preventDefault();
  $('.add').removeClass('d-none');
  $('.update').addClass('d-none');
  $('#payee_modal_header').html("Add Payee");
  togglePayeeFields(false);
  $('#parent_id').val("");
  $('#payee_parent_name').val("");
  $('#payee').val("");
  $('input[name="payee_type_id"]')
    .prop('disabled', false)
    .attr('readonly', false)
    .css({
      'pointer-events': 'auto',
      'opacity': '1'
    });
  $('input[name="payee_type_id"]').prop('checked', false);
  $('#payee_modal').modal('toggle');
});

$('#tbl_payees').on('click', '.btn_add_child', function(e) {
  e.preventDefault();
  var id = $(this).data('id');
  $('.add').removeClass('d-none');
  $('.update').addClass('d-none');
  $('#payee_modal_header').html("Add Payee");
  view(id).then(response => {
    Object.keys(response).forEach(key => {
      let field = $(`#${key}`);
      
      if (field.is(':checkbox')) {
        let isChecked = response[key] == 1;
        field.prop('checked', isChecked).bootstrapSwitch('state', isChecked, true);
      } 
      else if (field.is('select')) {
        field.val(response[key]).trigger('change');
      } 
      else {
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

    togglePayeeFields(false);
    $('#id').val(response.id); 
  });

  $('#payee_modal').modal('toggle');
});

$('#frm_payee').on('click', '.add', function(e) {
  $.ajax({
    method: 'POST',
    url: '{{ route('utilities.payee.store') }}',
    data: $('#frm_payee').serializeArray(),
    success: function(response) {
      loadRecords(currentAction);   
      $('#payee_modal').modal('toggle');
      Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: response.message,
        showConfirmButton: false,
        timer: 1500
      })
    },
    error: function(xhr) {
      var response = JSON.parse(xhr.responseText);

      $('.is-invalid').removeClass('is-invalid');
      $('.invalid-feedback').html('');

      $.each(response.errors, function(field, messages) {
        var element = $('#' + field);
        var feedbackElement = $('#' + field + '-feedback');

        if (element.length) {
          element.addClass('is-invalid');
          feedbackElement.html(messages[0]).show();
        }
      });

      var $firstErrorField = $('.is-invalid:first');
      if ($firstErrorField.length) {
        $('html, body').animate({
          scrollTop: $firstErrorField.offset().top - 100
        }, 'slow');
      }
    }
  });
});

$('#tbl_payees').on('click', '.btn_edit', function(e) {
  e.preventDefault();
  var id = $(this).data('id');  
  $('#payee_modal_header').html("Edit Payee");
  $('.add').addClass('d-none');
  $('.update').removeClass('d-none'); 
  view(id).then(response => {
    Object.keys(response).forEach(key => {
      let field = $(`#${key}`);
      
      if (field.is(':checkbox')) {
        let isChecked = response[key] == 1;
        field.prop('checked', isChecked).bootstrapSwitch('state', isChecked, true);
      } 
      else if (field.is('select')) {
        field.val(response[key]).trigger('change');
      } 
      else {
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

    togglePayeeFields(false);
    $('#payee_parent_name').val(response.parent_payee.payee); 
    $('#parent_id').val(response.parent_id); 
    $('#id').val(response.id);     
  });
  $('#payee_modal').modal('toggle');
});

$('#frm_payee').on('click', '.update', function(e) {
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
        $.ajax({
          method: 'PATCH',
          url: '{{ route('utilities.payee.update', ':id') }}'.replace(':id', id),
          data: $('#frm_payee').serializeArray().concat([
              { name: 'action', value: action },
          ]),
          success:function(response) {   
              loadRecords(currentAction);
              $('#payee_modal').modal('toggle');                                     
              Swal.fire({
                position: 'top-end',  
                icon: 'success',
                title: response.message,
                showConfirmButton: false,
                timer: 1500
              })  
          }, 
          error: function(xhr) {
            var response = JSON.parse(xhr.responseText);

            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').html('');

            $.each(response.errors, function(field, messages) {
              var element = $('#' + field);
              var feedbackElement = $('#' + field + '-feedback');

              if (element.length) {
                element.addClass('is-invalid');
                feedbackElement.html(messages[0]).show();
              }
            });

            var $firstErrorField = $('.is-invalid:first');
            if ($firstErrorField.length) {
              $('html, body').animate({
                scrollTop: $firstErrorField.offset().top - 100
              }, 'slow');
            }
          }
        });
      }
    })
});

$('#tbl_payees').on('click', '.btn_view', function(e) {
  e.preventDefault();
  var id = $(this).data('id');
  $('#payee_modal_header').html("View Payee");
  $('.save-buttons').addClass('d-none');
  view(id).then(response => {
    Object.keys(response).forEach(key => {
      let field = $(`#${key}`);
      
      if (field.is(':checkbox')) {
        let isChecked = response[key] == 1;
        field.prop('checked', isChecked).bootstrapSwitch('state', isChecked, true);
      } 
      else if (field.is('select')) {
        field.val(response[key]).trigger('change');
      } 
      else {
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

    togglePayeeFields(false);
    $('#payee_parent_name').val(response.parent_payee.payee); 
    $('#parent_id').val(response.parent_id); 
    $('#id').val(response.id);    
  });

  $('#payee_modal').modal('toggle');
});

$('#tbl_payees').on('click', '.btn_delete', function(e) {
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
          data: {
            id: id
          },
          success: function(response) {
            loadRecords(currentAction);
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: response.message,
              showConfirmButton: false,
              timer: 1500
            })
          },
          error: function(xhr, status, error) {
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
