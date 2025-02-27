
{{-- START --}}
  {{-- delete start --}}
  $('#rs_table').on('click', '.btn_delete', function(e){
      id = $(this).data('id')
      delete_rs(id);
    })
    function delete_rs(id){
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
            url: "{{ route('rs.delete') }}",
            data: {
              '_token': '{{ csrf_token() }}',
              'id' : id,
              'delete_rs' : 1,
            },
            success: function(data) {      
              Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'BURS-LC has been successfully deleted.',
              showConfirmButton: false,
              timer: 1500
              }) 
              $('#rs_table').DataTable().ajax.reload(); 
            }             
        })    
        }       
      })
    }
  {{-- delete end --}} 

  {{-- print start --}}
    $('.print').on('click', function(e){ 
      var rs_id = $('#rs_id').val();
      window.open("{{ url('/request_and_status/print_rs_page1') }}/" + rs_id);
    })      
  {{-- print end --}}  
{{-- END --}}