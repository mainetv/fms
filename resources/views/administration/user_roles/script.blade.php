{{-- table start --}}
  var user_roles_table = $('#user_roles_table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    lengthChange: false,
    autoWidth: false,
    stateSave: true,
    dom: 'Bfrtip',
    ajax: {
      url: "{{ route('administration.user_roles.table') }}",
      method: "GET",
      data : {
      '_token': '{{ csrf_token() }}'
      }
    },    
    columns: [      
      {data: 'name', name: 'name'},     
      {data: 'is_active', name: 'is_active',
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

