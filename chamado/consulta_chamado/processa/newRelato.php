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


#Executa o insert
if ($stmt1->execute()) {
    header("Location: /chamado/consulta_chamado/view.php?id=" . $chamadoID);
} else {
    header("Location: /chamado/consulta_chamado/view.php?id=" . $chamadoID);
}
