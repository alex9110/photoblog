<?php 	
	//если кто то напряьу решит вызвать футер
	require_once("../includes/functions.php"); 
	if ( login_test() ) {
	}else{redirects();}
	require_once("../includes/main.php"); 
 ?>
		<footer>
			<p><span><a target="_blank" href="https://www.facebook.com/AlexLychyk">сайт от Aleksandr Lychyk</a></span></p>
		</footer>
	</div>

	<script src="../../js/libs.min.js"></script>
	<script src="../../js/admin.js"></script>
</body>
</html>