{{-- FYI: Datatables do not support colspan or rowpan --}}

<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
		$('.data-table thead tr').clone(true).appendTo( '.data-table thead' );
		$('.data-table thead tr:eq(1) th').each( function (i) {
			if($(this).hasClass('no-search')){
				$(this).html('');
			} else {				
				var title = $(this).text();
				$(this).html( '<input type="text" placeholder="Filtra '+title+'" />' );
		 
				$( 'input', this ).on( 'keyup change', function () {
					if ( table.column(i).search() !== this.value ) {
						table
							.column(i)
							.search( this.value )
							.draw();
					}
				} );
			}
		} );
		$('.data-table-2 thead tr').clone(true).appendTo( '.data-table-2 thead' );
		$('.data-table-2 thead tr:eq(1) th').each( function (i) {
			if($(this).hasClass('no-search')){
				$(this).html('');
			} else {				
				var title = $(this).text();
				$(this).html( '<input type="text" placeholder="Filtra '+title+'" />' );
		 
				$( 'input', this ).on( 'keyup change', function () {
					if ( table.column(i).search() !== this.value ) {
						table
							.column(i)
							.search( this.value )
							.draw();
					}
				} );
			}
		} );
        var table = $('.data-table,.data-table-2').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
			@if(isset($datatables_order_by))
				{!! $datatables_order_by !!}
			@endif
            "info": true,
            "autoWidth": true,
			"orderCellsTop": true,
			"fixedHeader": true,
            "dom": 'T<"clear">lfrtip',
            "sPaginationType": "full_numbers",
            'aoColumnDefs': [{
                'bSortable': false,
                'searchable': false,
                'aTargets': ['no-search'],
                'bTargets': ['no-sort']
            }],
			"aaSorting": [ ],
			"language": {
				"sEmptyTable":     "Nessun dato presente nella tabella",
				"sInfo":           "Vista da _START_ a _END_ di _TOTAL_ elementi",
				"sInfoEmpty":      "Vista da 0 a 0 di 0 elementi",
				"sInfoFiltered":   "(filtrati da _MAX_ elementi totali)",
				"sInfoPostFix":    "",
				"sInfoThousands":  ".",
				"sLengthMenu":     "Visualizza _MENU_ elementi",
				"sLoadingRecords": "Caricamento...",
				"sProcessing":     "Elaborazione...",
				"sSearch":         "Cerca:",
				"sZeroRecords":    "La ricerca non ha portato alcun risultato.",
				"oPaginate": {
					"sFirst":      "Inizio",
					"sPrevious":   "&lt;",
					"sNext":       "&gt;",
					"sLast":       "Fine"
				},
				"oAria": {
					"sSortAscending":  ": attiva per ordinare la colonna in ordine crescente",
					"sSortDescending": ": attiva per ordinare la colonna in ordine decrescente"
				}
			}
        });
    });
</script>
