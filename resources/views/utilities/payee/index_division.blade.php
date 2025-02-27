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
					<label for="search" class="col-form-label" data-toggle="tooltip" data-placement='auto' title="Search Payee by Bank Account Numnber"><i class="fa-solid fa-magnifying-glass"></i> Bank Account Number:</label>
					<div class="col-sm-3 float-right">
						<input type="text" id="search" name="search" class="form-control" placeholder="Bank Account Number">
					</div>
					<div class="col-sm-1 float-left">
						<button id="btn_search" class="btn btn-primary">Search</button>
					</div>
					<label id="no_records_message" class="text-danger d-none col-form-label">No records found.</label>&emsp;
					<button id="btn_add" class="btn btn-success d-none">Add Payee</button>
				</div>
			</div>
			<div class="card-body">
				<div class="row py-2">
					<div class="col table-responsive">
						<table id="tbl_payees" class="table table-sm table-bordered data-table table-hover table-responsive-sm d-none" style="width: 100%;">
							<thead>
								<th width="40%">Payee Name</th>
								{{-- <th>TIN</th> --}}
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
		$(document).ready(function(){
			@include('scripts.common_script')

			$('#btn_search').click(function() {
				loadRecords();
			});

			$("#first_name").autocomplete({
				source: function (request, response) {
						$.ajax({
									url: "{{ route('searchPayeeFirstName') }}",
									dataType: "json",
									data: { term: request.term }, // Send full input
									success: function (data) {
										console.log("Filtered Data:", data); // Debugging
										response(data);
									}
						});
				},
				minLength: 1,
				select: function (event, ui) {
						alert(ui.item.parent_id)
						$("#first_name").val(ui.item.value); // Set input field value
						$("#parent_id").val(ui.item.parent_id); // Store parent_id in hidden field
						console.log("Selected Parent ID:", ui.item.parent_id);
				}
			});
			
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
				$('#payee_type_id').removeClass('is-invalid'); // Remove red border
				$('#payee_type_id-feedback').html('');
			});

			$('input[name="payee_type_id"]').prop('disabled', false);

			$('#payee_modal').on('show.bs.modal', function () {
				$('.is-invalid').removeClass('is-invalid');
				$('.invalid-feedback').html('');
			});

			const requiredFields = [
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
						buttons += `&nbsp;<button type="button" class="btn_edit btn btn-xs1 btn-outline-success" data-id="${id}" title="Edit Payee"
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
						data : {
							'_token': '{{ csrf_token() }}',
							'bank_account_number' : bank_account_number,
						},
						dataSrc: function(json) {
							if (json.data.length === 0) {
								$('#tbl_payees').addClass('d-none'); // Hide the table
								$('#btn_add').removeClass('d-none'); // Show the "Add" button
								$('#no_records_message').removeClass('d-none').text('No records found.');
							} else {
								$('#tbl_payees').removeClass('d-none'); // Show the table
								$('#btn_add').addClass('d-none'); // Hide the "Add" button
								$('#no_records_message').addClass('d-none'); // Hide message
							}
							return json.data;
						}
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
				$('#payee_modal_header').html("Add Payee");
				$('#is_active').prop('checked', true);
				togglePayeeFields(false);
				$('#parent_id').val("");
				$('#payee').val("");
				$('input[name="payee_type_id"]')
					.prop('disabled', false)
					.attr('readonly', false)
					.css({
								'pointer-events': 'auto', // Allow clicking
								'opacity': '1' // Make fully visible
					});
				$('input[name="payee_type_id"]').prop('checked', false);
				$('#payee_modal').modal('toggle');
			});

			$('#tbl_payees').on('click', '.btn_add_child', function (e) {
				e.preventDefault();
				var id = $(this).data('id');
				$('.add').removeClass('d-none');
				$('.update').addClass('d-none');
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
							'pointer-events': 'none',
							'opacity': '0.5'
						});
					});

					togglePayeeFields(false);
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
							$('html, body').animate({ scrollTop: $firstErrorField.offset().top - 100 }, 'slow');
						}
					}
				});
			});

			$('#tbl_payees').on('click', '.btn_edit', function (e) {
				e.preventDefault();
				var id = $(this).data('id');
				$('#payee_modal_header').html("Edit Payee");
				$('.add').addClass('d-none');
				$('.update').removeClass('d-none');
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
									title: 'Payee saved successfully.',
									showConfirmButton: false,
									timer: 1500
								})
							},
							error: function (xhr) {
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
									$('html, body').animate({ scrollTop: $firstErrorField.offset().top - 100 }, 'slow');
								}
							}
						});
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
		})
	</script>
@endsection

