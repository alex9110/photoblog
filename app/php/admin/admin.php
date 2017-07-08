<?php 
	require_once("header_ad.php"); 
	require_once("../includes/functions.php"); 
	require_once("../includes/config.php"); 

?>

<div class="content">
	
	<ul>
		<?php 
			$config = config();
			$table = $config['contacts'];
			$data = get_data($table);
			$li = '';
			for ($i=0; $i < count($data); $i++) { 
				$name = $data[$i]['name'];
				$value = $data[$i]['value'];
				$li .= '<li class="contacts"><p>'.$name.'</p><input name="'.$name.'" type="text" value="'.$value.'" class="cont_input"></li>';
			}
			echo $li;
		 ?>
	</ul>
	 <input type="button" class="but" value="сохранить">
</div>
<?php require_once("footer_ad.php"); ?>
<script>
	$(".but").click(function(evt){
		var value = $(".cont_input");
		var val;
		var name;
		var data = {};
		for (var i = 0; i < value.length; i++) {
			 name = $(value[i]).attr('name');
			 val = $(value[i]).val();
			 val = $.trim(val);

			 data[name] = val;

			
		}
		// console.log(data);
		    $.ajax({
		        url: '../includes/main.php?contacts_change',
		        type: 'POST',
		        data: data,
		       	dataType: 'json',
		        success: function( data, textStatus, jqXHR ){
		            // Если все ОК
		            if( typeof data.error === 'undefined' ){
		                // если Файлы успешно загружены
		              	var status = data.status;
		              	 console.log(status);
		              	 console.log(data);
		              	 //location.reload();	
		            }
		            else{
		                console.log('ОШИБКИ ОТВЕТА сервера: ' + data.error );
		            }
		        },
		        error: function( jqXHR, textStatus, errorThrown ){
		            console.log('ОШИБКИ AJAX запроса: ' + textStatus );
		        }
		    });
		
	})
</script>