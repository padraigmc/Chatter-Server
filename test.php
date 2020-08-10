<?php

$password_regex = "/^(?=.*[a-z])[a-z\d@$!%*#?&]{4,}$/"; 
    
if (preg_match($password_regex, "password")) { 
    echo 1; 
} else { 
    echo 0; 
} 

?>