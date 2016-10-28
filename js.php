		

	<script type="text/javascript" src="js/jquery-3.1.0.min.js"></script>

	<script type="text/javascript" src="jquery-ui-1.12.0/jquery-ui-1.12.0/jquery-ui.js"></script>

	<script type="text/javascript" src="js/bootstrap.min.js"></script>

	<script>
		
	$(document).ready(function(){

		$(".btn-delete").on("click", function() {

			var selected = $(this).attr("id");

			var expense_id = selected.split("_")[1];

			var confirmed = confirm("Are you sure you want to delete the item?");

			if(confirmed == true){

				$.get("ajax/expenses.php?id=" + expense_id);

				$("#row_" + expense_id).remove();

			}	

		})

		/*$(".timebox").on("change", function() {

			//var month = $(this).val();

			var date = $("#y-box").val() + "-" + $("#m-box").val() + "-" + $("#d-box").val();

			//var expense_id = selected.split("_")[1];

			$.get("ajax/date.php?date=" + date);

			//$("#row_" + expense_id).remove();

		})*/

	})

		

	</script>