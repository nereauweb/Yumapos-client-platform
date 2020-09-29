<script>
	$(document).ready(function(){
		function search(){			
			window.location.href = window.location.href+(window.location.href.indexOf('?') == -1 ? '?' : '&')+"search_term="+$("#search_term").val()+"&page=1"; 
		}
		$("#request-search").click(function(e){
			e.preventDefault();
			search();
		});
		$( "#search-form" ).submit(function(e) {
			e.preventDefault();
			search();
		});
		$("#reset-search").click(function(e){
			e.preventDefault();
			window.location.href = window.location.href+(window.location.href.indexOf('?') == -1 ? '?' : '&')+"search_term=&page=1";
		});
	});
</script>