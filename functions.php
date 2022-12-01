<?php


function inputFields($placeholder,$name,$value,$type){
	$element="
					<div class=\"form-group my-4\">
						<input type='$type' name='$name' placeholder='$placeholder'
						 class=\"form-control\" value='$value' autocomplete='off'>
					</div>
	
	";
	echo $element;
}



?>
