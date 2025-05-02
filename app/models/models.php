<?php
function FiltroAno($conn, $ano)
{
    $sql = "SELECT DISTINCT TB00043_ESTADO Estado FROM TB00043";

    $stmt = sqlsrv_query($conn, $sql);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }


    $opcao = "";

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $opcao .= "<div data-value='$row[Estado]'>$row[Estado]</div>";

    }
    return print ($opcao);
}