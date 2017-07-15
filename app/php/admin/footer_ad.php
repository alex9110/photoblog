<?php 	
	//если кто то напряьу решит вызвать футер
	require_once("../includes/functions.php"); 
	if ( login_test() ) {
	}else{redirects();}
	require_once("../includes/main.php"); 
 ?>
		<footer
			<p><span>copyright</span></p>
		</footer>
	</div>

	<script src="../../js/libs.min.js"></script>
	<script src="../../js/common2.js"></script>
</body>
</html>