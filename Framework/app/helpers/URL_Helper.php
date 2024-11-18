<?php

function Redirect($page)
{
header('Location: ' .URLROOT.'/'.$page);
exit;
}
?>