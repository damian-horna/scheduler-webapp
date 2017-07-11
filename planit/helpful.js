window.onload = loadfirst;

function loadfirst(){
	$('document').ready(
						function(){ 
							        	$.post('searching.php',{search: ""},function(response){
									            $('#cont').html(response);
									        });	
							        });						
}