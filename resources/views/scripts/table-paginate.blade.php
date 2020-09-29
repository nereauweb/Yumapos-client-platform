<script>
	$(document).ready(function(){
		$("#paginate").change(function(e){
			e.preventDefault();
			window.location.href = window.location.href+(window.location.href.indexOf('?') == -1 ? '?' : '&')+"paginate="+$("#paginate").val();
		});
	});
</script>