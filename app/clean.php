<?php

function clean($link,$data){
	return htmlentities(strip_tags(mysqli_real_escape_string($link,$data)));
}
function cleanh($link,$data){
	return htmlentities(mysqli_real_escape_string($link,$data));
}


?>