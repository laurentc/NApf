<?php
/**
 * Created by JetBrains PhpStorm.
 * User: laurentc
 * Date: 23/06/11
 * Time: 16:37
 * To change this template use File | Settings | File Templates.
 */
header("HTTP/1.0 " . \napf\core\ServletResponse::SC_NOT_FOUND);
header("Status: " . \napf\core\ServletResponse::SC_NOT_FOUND);
?>
<table>
    <tr>
        <td>
            <h1>404</h1>

            <h3>Page Introuvable</h3>
        </td>
        <td><input type="image" src="napf.jpg"></td>
    </tr>
</table>

