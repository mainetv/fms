@extends('layouts.app')

@section('content')
  {{ csrf_field() }}
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Payees</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/fms/public">Home</a></li>
            <li class="breadcrumb-item active">Payees</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="card text-center">
      <div class="card-header">
        <div class="row">
          <label for="search" class="col-form-label" data-toggle="tooltip" data-placement='auto'
            title="Search Payee Bank Account Number: Press 'Enter' or click the 'Search' button"><i class="fa-solid fa-magnifying-glass"></i> Bank Account Number:</label>
          <div class="col-sm-3 float-right">
            <input type="text" id="search" name="search" class="form-control" placeholder="Search Bank Account No. (Press 'Enter')">
          </div>
          <div class="col-sm-2 float-left">
            <button id="btn_search" class="btn btn-primary" value="search">Search</button>
            <button id="btn_clear_search" class="btn btn-danger" data-toggle="tooltip" data-placement='auto' title="Clear Search"  value="clear">X</button>
          </div>
          <label id="no_records_message" class="text-danger d-none col-form-label">No records found.</label>&emsp;
          <button id="btn_add" class="btn btn-success">Add Payee</button>
        </div>
      </div>
      <div class="card-body">
        <div class="row py-2">
          <div class="col table-responsive">
            <table id="tbl_payees" class="table table-sm table-bordered data-table table-hover table-responsive-sm"
              style="width: 100%;">
              <thead>
                <th width="40%">Payee Name</th>
                <th>TIN</th>
                <th>Bank Name</th>
                <th>Bank Account Name</th>
                <th>Bank Account Number</th>
                <th>Verified</th>
                <th>Active</th>
                <th></th>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>

  @include('utilities.payee.modal')
@endsection

@section('jscript')
  <script type="text/javascript">
    $(document).ready(function() {
      @include('scripts.common_script')        
      @include('utilities.payee.script')

      function loadRecords(action) {
        currentAction = action; 
        var bank_account_number = $('#search').val();

        var tbl_payees = $('#tbl_payees').DataTable({
          destroy: true,
          info: false,
          dom: 't',
          fixedColumns: true,
          processing: true,
          responsive: true,
          ajax: {
            url: "{{ route('listPayeesByBankAccountNo') }}",
            method: "GET",
            data: {
              '_token': '{{ csrf_token() }}',
              'bank_account_number': bank_account_number,
              'action': action,
            },
            complete: function() {
              disableButtons(false);
              hideLoader();
            },
            beforeSend: function() {
              showLoader();
            }, 
            dataSrc: function(json) {
              if (json.data.length === 0) {
                $('#btn_add').removeClass('d-none');
                $('#no_records_message').removeClass('d-none').text('No records found.');
              } else {
                $('#btn_add').addClass('d-none');
                $('#no_records_message').addClass('d-none');
              }
              return json.data; // This will either be empty [] or populated.
            }

          },
          rowId: 'id',
          columns: [{
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

      loadRecords(action);
    })
  </script>
@endsection
