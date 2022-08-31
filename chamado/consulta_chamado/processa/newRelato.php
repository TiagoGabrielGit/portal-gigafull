<?php
require "../../../conexoes/conexao.php";
require "../../../conexoes/conexao_pdo.php";

#Recebe os parametros do relato
$chamadoID = $_POST['chamadoID'];
$relatorID = $_POST['relatorID'];
$novoRelato = $_POST['novoRelato'];


#Prepara a a insercao do relato no chamado
$sql1 = "INSERT INTO chamado_relato (chamado_id, relator_id, relato, relato_hora_inicial, relato_hora_final, seconds_worked)
        VALUES (:chamado_id, :relator_id, :relato, NOW(), NOW(), '0')";
$stmt1 = $pdo->prepare($sql1);
$stmt1->bindParam(':chamado_id', $chamadoID);
$stmt1->bindParam(':relator_id', $relatorID);
$stmt1->bindParam(':relato', $novoRelato);


    $data = [
        'seconds_worked' => $total_seconds_worked,
        'status_id' => 2,
        'in_execution' => 0,
        'in_execution_atd_id' => 0,
    ];

    $sql2 = "UPDATE chamados SET seconds_worked=:seconds_worked, status_id=:status_id, in_execution=:in_execution, in_execution_atd_id=:in_execution_atd_id, in_execution_start=NULL WHERE id=$chamadoID";
    $stmt2 = $pdo->prepare($sql2);


#Executa o insert
if ($stmt1->execute() && $stmt2->execute($data)) {
    header("Location: /chamado/consulta_chamado/view.php?id=" . $chamadoID);
} else {
    header("Location: /chamado/consulta_chamado/view.php?id=" . $chamadoID);
}
