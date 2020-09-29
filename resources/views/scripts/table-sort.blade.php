<script>
	$(document).ready(function(){			
		var field = "id";
		var orientation = "{{ app('request')->input('order_orientation')=='desc' ? 'asc' : 'desc' }}";
		$(".sortable").click(function(e){
			e.preventDefault();
			field = $(this).data("sort");
			//console.log("Field: "+field+"," + orientation);
			window.location.href = window.location.href+(window.location.href.indexOf('?') == -1 ? '?' : '&')+"order_field="+field+"&order_orientation="+orientation;
		});
	});
</script>