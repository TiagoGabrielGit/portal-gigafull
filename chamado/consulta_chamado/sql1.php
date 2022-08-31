<?php
$sql_lista_tipos_chamados =
"SELECT
tipo.id as id,
tipo.tipo as tipo
FROM
tipos_chamados as tipo
WHERE
tipo.active = 1
";