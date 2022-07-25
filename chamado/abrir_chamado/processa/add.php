<?php
require "../../../conexoes/conexao_pdo.php";

$assuntoChamado = $_POST['assuntoChamado'];
$tipochamado_id = $_POST['tipoChamado'];
$solicitante_id = $_POST['solicitante'];
$empresa_id = $_POST['empresaChamado'];
$relato = $_POST['relatoChamado'];

$cont_insert = false;

$sql = "INSERT INTO chamados (assuntoChamado, tipochamado_id, solicitante_id, empresa_id, status_id, data_abertura)
        VALUES (:assuntoChamado, :tipochamado_id, :solicitante_id, :empresa_id, '1', NOW())";
$stmt1 = $pdo->prepare($sql);
$stmt1->bindParam(':assuntoChamado', $assuntoChamado);
$stmt1->bindParam(':tipochamado_id', $tipochamado_id);
$stmt1->bindParam(':solicitante_id', $solicitante_id);
$stmt1->bindParam(':empresa_id', $empresa_id);

if ($stmt1->execute()) {
    $cont_insert = true;
    $id_chamado = $pdo->lastInsertId();
} else {
    $cont_insert = false;
}

if ($id_chamado && $cont_insert) {
    $sql_relato = "INSERT INTO chamado_relato (chamado_id, relato, relato_hora_inicial, relato_hora_final)
    VALUES (:chamado_id, :relato, NOW(), NOW())";

    $stmt2 = $pdo->prepare($sql_relato);
    $stmt2->bindParam(':chamado_id', $id_chamado);
    $stmt2->bindParam(':relato', $relato);

    $stmt2->execute();
}

if ($cont_insert) {
    echo "<p style='color:green;'>Chamado aberto com sucesso. Chamado $id_chamado</p>";
} else {
    echo "<p style='color:red;'>Erro ao abrir chamado.</p>";
}
