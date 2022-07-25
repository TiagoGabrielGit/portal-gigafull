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

$sql_lista_empresas = 
"SELECT
emp.id as id_empresa,
emp.fantasia as fantasia_empresa
FROM
portal_user_empresa as empuser
LEFT JOIN
portal_user as puser
ON
empuser.usuario_id = puser.id
LEFT JOIN
empresas as emp
ON
emp.id = empuser.empresa_id
WHERE
empuser.usuario_id = '$usuario_id'
and
empuser.active = '1'
ORDER BY
emp.fantasia ASC
";
