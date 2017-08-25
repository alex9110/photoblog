<?php 	
	//если кто то напряьу решит вызвать футер
	require_once("../includes/functions.php"); 
	if ( login_test() ) {
	}else{redirects();}
	require_once("../includes/main.php"); 
 ?>
		<footer>
			<a id="author" target="_blank" href="https://www.facebook.com/AleksandrLychyk">
				<p>сайт от Aleksandr Lychyk</p>
				<img src="../../img/external.png" alt="" style="width: 10px; height: auto; margin-left: 4px;">
			</a>
		</footer>
	</div>

	<script src="../../js/libs.min.js"></script>
	<script src="../../js/admin.js"></script>
</body>
</html>