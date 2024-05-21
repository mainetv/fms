function clear_attributes(){
  $('.error').html("");
  $('.form-control').removeClass('is-invalid');
  $('.form-check-input').removeClass('is-invalid');
  $('.modal').removeClass('error');
}

function clear_fields(){ 
  $(".form-control").val('');
  $(".form-control").val('').change();
  $(".form-check-input").val('');
  $('input[type=checkbox]').not('#chk_fy').prop("checked", false);
}

function clear_select(){
  $("select").val('');
}

$('.notification_has_read').click(function(e) { 
  e.preventDefault(); 
  id = $(this).data("id");
  link = $(this).data("link");
  base_path = "{{ URL::to('') }}";
  $.ajax({
    method: "PATCH",
    url: "{{ route('notifications.update') }}",  
    data: {
      '_token': '{{ csrf_token() }}',
      id : id,
      is_read : '1',
      link : link,
    },     
    success:function(data) {      
      location.replace(base_path + "/" + link);          
    }            
  });
});

$('.all-notifications').click(function(e) { 
  e.preventDefault(); 
  base_path = "{{ URL::to('') }}";
  location.replace(base_path + "/notifications");      
});


{{-- fund bank account no dropdown --}}
    $('#bank_account_id').on('select2:opening', function(e){
      if($('#fund_id').val() == '' || $('#fund_id').val() == null){
        display_notification_content('Please select fund first!')
        return false;
      }
    })
    function view_bank_account_by_fund(fund_id, bank_account_id){
      $('#bank_account_id > option:not(:first-child):not(:nth-child(1))')
        .remove()
    
      var request_bank_account = show_bank_account_by_fund(fund_id);
      request_bank_account.then(function (data) {
        jQuery.each(data['bank_accounts'], function() {
          $('#bank_account_id').append('<option value="'+this.id+'">'+this.bank_account_no+'</option>')
        })      
        $('#fund_id').val(fund_id).change();
        $('#bank_account_id').val(bank_account_id).change();
      })
    }

    function show_bank_account_by_fund(fund_id){
      var request = $.ajax({
        method: "GET",
        url: "{{ route('show_bank_account_by_fund') }}",
        data: {
          '_token': '{{ csrf_token() }}',
          'fund_id' : fund_id
        }
      });
      return request;
    }
    $('#fund_id').on('select2:select', function(e){

      $('#bank_account_id')
        .val('')
        .change()
      $('#bank_account_id > option:not(:first-child):not(:nth-child(1))')
        .remove()
        fund_id = $('#fund_id').val();
        
      var request = view_bank_account_by_fund(fund_id);
      request.then(function(data) {
        jQuery.each(data['bank_accounts'], function() {
          $('#bank_account_id').append('<option value="'+this.id+'">'+this.bank_account_no+'</option>')
        })
        fund_id = '';
      })
    })
{{-- fund bank account no dropdown end--}}

{{-- activity subactivity dropdown --}}
  {{-- error checking for null values in filtering --}}
  $('#subactivity_id').on('select2:opening', function(e){
    if($('#activity_id').val() == '' || $('#activity_id').val() == null){
      display_notification_content('Please select activity first!')
      return false;
    }
  })
  function view_subactivity_by_activity_id(activity_id, subactivity_id){
    $('#subactivity_id > option:not(:first-child):not(:nth-child(1))')
      .remove()
  
    var request_subactivity = show_subactivity_by_activity_id(activity_id);
    request_subactivity.then(function (data) {
      jQuery.each(data['subactivities'], function() {
        $('#subactivity_id').append('<option value="'+this.id+'">'+this.subactivity+'</option>')
      })      
      $('#activity_id').val(activity_id).change();
      $('#subactivity_id').val(subactivity_id).change();
    })
  }

  function show_subactivity_by_activity_id(activity_id){
    var request = $.ajax({
      method: "GET",
      url: "{{ route('show_subactivity_by_activity_id') }}",
      data: {
        '_token': '{{ csrf_token() }}',
        'activity_id' : activity_id
      }
    });
    return request;
  }

  $('#activity_id').on('select2:select', function(e){
    $('#subactivity_id')
      .val('')
      .change()
    $('#subactivity_id > option:not(:first-child):not(:nth-child(1))')
      .remove()
      activity_id = $('#activity_id').val();
      
    var request = view_subactivity_by_activity_id(activity_id);
    request.then(function(data) {
      jQuery.each(data['subactivities'], function() {
        $('#subactivity_id').append('<option value="'+this.id+'">'+this.subactivity+'</option>')
      })
      activity_id = '';
    })
  })
{{-- activity subactivity dropdown end--}}

{{-- expense account expenditure dropdown --}}
  $('#object_expenditure_id').on('select2:opening', function(e){
    if($('#expense_account_id').val() == '' || $('#expense_account_id').val() == null){
      display_notification_content('Please select activity first!')
      return false;
    }
  })
  function view_object_expenditure_by_expense_account_id(expense_account_id, object_expenditure_id){
    $('#object_expenditure_id > option:not(:first-child):not(:nth-child(1))')
      .remove()

    var request_object_expenditure = show_object_expenditure_by_expense_account_id(expense_account_id);
    request_object_expenditure.then(function (data) {
      jQuery.each(data['object_expenditures'], function() {
        $('#object_expenditure_id').append('<option value="'+this.id+'">'+this.object_expenditure+'</option>')
      })      
      $('#expense_account_id').val(expense_account_id).change();
      $('#object_expenditure_id').val(object_expenditure_id).change();
    })
  }

  function show_object_expenditure_by_expense_account_id(expense_account_id){
    var request = $.ajax({
      method: "GET",
      url: "{{ route('show_object_expenditure_by_expense_account_id') }}",
      data: {
        '_token': '{{ csrf_token() }}',
        'expense_account_id' : expense_account_id
      }
    });
    return request;
  }

  $('#expense_account_id').on('select2:select', function(e){
    $('#object_expenditure_id')
      .val('')
      .change()
    $('#object_expenditure_id > option:not(:first-child):not(:nth-child(1))')
      .remove()
      expense_account_id = $('#expense_account_id').val();
      
    var request = view_object_expenditure_by_expense_account_id(expense_account_id);
    request.then(function(data) {
      jQuery.each(data['subactivities'], function() {
        $('#object_expenditure_id').append('<option value="'+this.id+'">'+this.object_expenditure+'</option>')
      })
      expense_account_id = '';
    })
  })  
{{-- expense account expenditure dropdown end--}}

{{-- expenditure specific dropdown --}}
  $('#object_specific_id').on('select2:opening', function(e){
    if($('#object_expenditure_id').val() == '' || $('#object_expenditure_id').val() == null){
      display_notification_content('Please select object expenditure first!')
      return false;
    }
  })
  function view_object_specific_by_object_expenditure_id(object_expenditure_id, object_specific_id){
    $('#object_specific_id > option:not(:first-child):not(:nth-child(1))')
      .remove()
  
    var request_object_specific = show_object_specific_by_object_expenditure_id(object_expenditure_id);
    request_object_specific.then(function (data) {
      jQuery.each(data['object_specifics'], function() {
        $('#object_specific_id').append('<option value="'+this.id+'">'+this.object_specific+'</option>')
      })      
      $('#object_expenditure_id').val(object_expenditure_id).change();
      $('#object_specific_id').val(object_specific_id).change();
    })
  }

  function show_object_specific_by_object_expenditure_id(object_expenditure_id){
    var request = $.ajax({
      method: "GET",
      url: "{{ route('show_object_specific_by_object_expenditure_id') }}",
      data: {
        '_token': '{{ csrf_token() }}',
        'object_expenditure_id' : object_expenditure_id
      }
    });
    return request;
  }

  $('#object_expenditure_id').on('select2:select', function(e){      
    $('#object_specific_id')
      .val('')
      .change()
    $('#object_specific_id > option:not(:first-child):not(:nth-child(1))')
      .remove()
      object_expenditure_id = $('#object_expenditure_id').val();
      
    var request = view_object_specific_by_object_expenditure_id(object_expenditure_id);
    request.then(function(data) {
      jQuery.each(data['object_specifics'], function() {
        $('#object_specific_id').append('<option value="'+this.id+'">'+this.object_specific+'</option>')
      })
      object_expenditure_id = '';
    })
  })
{{-- expenditure specific dropdown end--}}  

{{-- modal start --}}
  $("#comment_modal").on("hidden.bs.modal", function(){ 
    $('.director_comments_tbody tr').remove();
    $('.fad_budget_comments_tbody tr').remove();
    $('.bpac_comments_tbody tr').remove();
  });
{{-- modal end --}}


