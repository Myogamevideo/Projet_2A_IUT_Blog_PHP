<?php
function getBanni($bdd, $pseudo, $statu)
{
    if (isset($statu) and $statu == 'banni') {
        header('location: affichagebanni.php');
    }
}
