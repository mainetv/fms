{{-- table start --}}
	function fill_datatable_form9(fiscal_year=''){
		var bp_form9_table = $('#bp_form9_table').DataTable({
		processing: true,
		serverSide: true,
		responsive: true,
		lengthChange: false,
		autoWidth: false,
		stateSave: true,
		dom: 'Bfrtip',
		ajax: {
				url: "{{ route('bp_form9.table') }}",
				method: "GET",
				data :  {
				'_token': '{{ csrf_token() }}',
				fiscal_year,
				}      
		},    
		columns: [      
				{data: 'description', name: 'description'},
				{data: 'quantity', name: 'quantity'},
				{data: 'unit_cost', name: 'unit_cost'},
				{data: 'total_cost', name: 'total_cost'},
				{data: 'organizational_deployment', name: 'organizational_deployment'}, 
				{data: 'justification', name: 'justification'}, 
				{data: 'action', orderable: false, searchable: false}          
		],
		buttons: [
				{
				extend: 'copyHtml5',
				exportOptions: {
						columns: [ 1, 2, 3, 4, 5 ]
				}
				},
				{
				extend: 'excelHtml5',
				exportOptions: {
						columns: [ 1, 2, 3, 4, 5 ]
				}
				},
				{
				extend: 'pdfHtml5',
				exportOptions: {
						columns: [ 1, 2, 3, 4, 5 ]
				}
				},
				{
				extend: 'print',
				exportOptions: {
						columns: [ 1, 2, 3, 4, 5 ]
				}
				},
				'colvis'
		]
		});
	}

	$('#fiscal_year').change(function(){
		var fiscal_year = $('#fiscal_year').val();
		$('#bp_form9_year').val(fiscal_year);
		if(fiscal_year !=''){
			$('#bp_form9_table').DataTable().destroy();
			fill_datatable_form9(fiscal_year);      
		}
		else{
			fill_datatable_form9();
		}
	});
{{-- table end --}}

{{-- modal start --}}
	$('#bp_form9_modal').on('hide.bs.modal', function(){     
		clear_attributes();
		clear_fields();
 	});  
{{-- modal end --}}

{{-- view start --}}   
	function init_view_bp_form9(){
		$('.dost-form9-field')
		.val('')
		.attr('disabled', true);

		$('.save-buttons')
		.removeClass('d-inline')
		.addClass('d-none')
		.attr('disabled', true);
	}

	function view_bp_form9(bp_form9_id){
		var request = $.ajax({
		method: "GET",
		url: "{{ route('bp_form9.show') }}",
		data: {
			'_token': '{{ csrf_token() }}',
			'id' : bp_form9_id
		}
		});
		return request;
	}

	$('#bp_form9_table').on('click', '.view-bp-form9', function(e){     
		$('#bp_form9_modal_header').html("View DOST Form No. 9");     
		bp_form9_id = $(this).parents('tr').data('id');
		init_view_bp_form9();   
		var request = view_bp_form9(bp_form9_id);   
		request.then(function(data) {
			if(data['status'] == 1){
				$('#bp_form9_division_id').val(data['bp_form9']['division_id']) 
				$('#bp_form9_year').val(data['bp_form9']['year']) 
				$('#bp_form9_description').val(data['bp_form9']['description']) 
				$('#bp_form9_quantity').val(data['bp_form9']['quantity']) 
				$('#bp_form9_unit_cost').val(data['bp_form9']['unit_cost']) 
				$('#bp_form9_total_cost').val(data['bp_form9']['total_cost']) 
				$('#bp_form9_organizational_deployment').val(data['bp_form9']['organizational_deployment']) 
				$('#bp_form9_justification').val(data['bp_form9']['justification']) 
				$('#bp_form9_remarks').val(data['bp_form9']['remarks'])
			}                          
		})
		$('#bp_form9_modal').modal('toggle');
	})  
{{-- view end --}}

{{-- add start --}}
	function init_add_bp_form9(){
		$('.dost-form9-field')
			.attr('disabled', false);
			
		$('#add_bp_form9.save-buttons')
			.addClass('d-inline')
			.removeClass('d-none')
			.attr('disabled', false);      
	}

	$('#add_new_bp_form9').on('click', function(){     
		init_add_bp_form9();         
		$('#bp_form9_modal_header').html("Add DOST Form No. 9");
		$('#bp_form9_modal').modal('toggle')       
	})

	$('#add_bp_form9').on('click', function(event){        
		event.prevenDefault;  
		clear_attributes();
		$.ajax({
			method: "POST",
			url: "{{ route('bp_form9.store') }}",
			data: {
				'_token': '{{ csrf_token() }}',
				'division_id' : $('#bp_form9_division_id').val(),
				'year' : $('#year_selected').val(),
				'description' : $('#bp_form9_description').val(),
				'quantity' : $('#bp_form9_quantity').val(),
				'unit_cost' : $('#bp_form9_unit_cost').val(),
				'total_cost' : $('#bp_form9_total_cost').val(),
				'organizational_deployment' : $('#bp_form9_organizational_deployment').val(),
				'justification' : $('#bp_form9_justification').val(),
				'remarks' : $('#bp_form9_remarks').val(),
			},
			success:function(data) {
			console.log(data);
			if(data.errors) {         
				if(data.errors.description){
					$('#bp_form9_description').addClass('is-invalid');
					$('#dost-form9-description-error').html(data.errors.description[0]);
				}   
				if(data.errors.quantity){
					$('#bp_form9_quantity').addClass('is-invalid');
					$('#dost-form9-quantity-error').html(data.errors.quantity[0]);
				} 
				if(data.errors.unit_cost){
					$('#bp_form9_unit_cost').addClass('is-invalid');
					$('#dost-form9-unit-cost-error').html(data.errors.unit_cost[0]);
				} 
				if(data.errors.total_cost){
					$('#bp_form9_total_cost').addClass('is-invalid');
					$('#dost-form9-total-cost-error').html(data.errors.total_cost[0]);
				} 
				if(data.errors.organizational_deployment){
					$('#bp_form9_organizational_deployment').addClass('is-invalid');
					$('#dost-form9-organizational-deployment-error').html(data.errors.organizational_deployment[0]);
				} 
				if(data.errors.justification){
					$('#bp_form9_justification').addClass('is-invalid');
					$('#dost-form9-justification-error').html(data.errors.justification[0]);
				}                                
			}
			if(data.success) {
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'DOST Form No. 9 has been successfully added.',
					showConfirmButton: false,
					timer: 1500
				}) 
				$('#bp_form9_modal').modal('toggle')
				$('#bp_form9_table').DataTable().ajax.reload();
			}
			},
		});
	})
{{-- add end--}}

{{-- update start --}}
	function init_update_bp_form9(){
		init_view_bp_form9()
		$('.dost-form9-field')
			.attr('disabled', false);

		$('#update_bp_form9.save-buttons')
			.addClass('d-inline')
			.removeClass('d-none')
			.attr('disabled', false);
	}

	$('#update_bp_form9').on('click', function(event){
		event.preventDefault();
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
			url: "{{ route('bp_form9.update') }}",
			data: {
				'_token': '{{ csrf_token() }}',
				'id' : bp_form9_id,
				'division_id' : $('#bp_form9_division_id').val(),
				'year' : $('#year_selected').val(),
				'description' : $('#bp_form9_description').val(),
				'quantity' : $('#bp_form9_quantity').val(),
				'unit_cost' : $('#bp_form9_unit_cost').val(),
				'total_cost' : $('#bp_form9_total_cost').val(),
				'organizational_deployment' : $('#bp_form9_organizational_deployment').val(),
				'justification' : $('#bp_form9_justification').val(),
				'remarks' : $('#bp_form9_remarks').val(),
			},
			success:function(data) {
			console.log(data);
			if(data.errors) {         
				if(data.errors.description){
					$('#bp_form9_description').addClass('is-invalid');
					$('#dost-form9-description-error').html(data.errors.description[0]);
				}   
				if(data.errors.quantity){
					$('#bp_form9_quantity').addClass('is-invalid');
					$('#dost-form9-quantity-error').html(data.errors.quantity[0]);
				} 
				if(data.errors.unit_cost){
					$('#bp_form9_unit_cost').addClass('is-invalid');
					$('#dost-form9-unit-cost-error').html(data.errors.unit_cost[0]);
				} 
				if(data.errors.total_cost){
					$('#bp_form9_total_cost').addClass('is-invalid');
					$('#dost-form9-total-cost-error').html(data.errors.total_cost[0]);
				} 
				if(data.errors.organizational_deployment){
					$('#bp_form9_organizational_deployment').addClass('is-invalid');
					$('#dost-form9-organizational-deployment-error').html(data.errors.organizational_deployment[0]);
				} 
				if(data.errors.justification){
					$('#bp_form9_justification').addClass('is-invalid');
					$('#dost-form9-justification-error').html(data.errors.justification[0]);
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
				$('#bp_form9_modal').modal('toggle')
				$('#bp_form9_table').DataTable().ajax.reload();
			}                      
			}                             
			});                                
			}       
		})   
	})      

	$('#bp_form9_table').on('click', '.update-bp-form9', function(e){
		$('#bp_form9_modal_header').html("Update DOST Form No. 9");        
		init_update_bp_form9();
		bp_form9_id = $(this).parents('tr').data('id');
		var request = view_bp_form9(bp_form9_id);
		request.then(function(data) {
			if(data['status'] == 1){     
				$('#bp_form9_division_id').val(data['bp_form9']['division_id']) 
				$('#bp_form9_year').val(data['bp_form9']['year']) 
				$('#bp_form9_description').val(data['bp_form9']['description']) 
				$('#bp_form9_quantity').val(data['bp_form9']['quantity']) 
				$('#bp_form9_unit_cost').val(data['bp_form9']['unit_cost']) 
				$('#bp_form9_total_cost').val(data['bp_form9']['total_cost']) 
				$('#bp_form9_organizational_deployment').val(data['bp_form9']['organizational_deployment']) 
				$('#bp_form9_justification').val(data['bp_form9']['justification']) 
				$('#bp_form9_remarks').val(data['bp_form9']['remarks'])
			}           
		})
		$('#bp_form9_modal').modal('toggle')            
	})
{{-- update end--}}

{{-- delete start --}}
	$('#bp_form9_table').on('click', '.delete-bp-form9', function(e){
		bp_form9_id = $(this).parents('tr').data('id');
		delete_bp_form9(bp_form9_id);
	})
 
	function delete_bp_form9(bp_form9_id){
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
			url: "{{ route('bp_form9.delete') }}",
			data: {
				'_token': '{{ csrf_token() }}',
				'id' : bp_form9_id
			},
			success: function(data) {      
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'Record has been successfully deleted.',
					showConfirmButton: false,
					timer: 1500
				}) 
				$('#bp_form9_table').DataTable().ajax.reload();     
			}             
			})    
		}       
	})
	}
{{-- delete end --}} 