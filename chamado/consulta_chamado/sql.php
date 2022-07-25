<?php
$empresa_id =
"SELECT
pue.empresa_id
FROM
portal_user_empresa as pue
WHERE
pue.usuario_id = '$usuario_id'
and
active = '1'
";
