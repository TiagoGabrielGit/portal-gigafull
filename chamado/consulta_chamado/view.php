<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";

$id_chamado = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

require "sql.php";

$resut_chamado1 = mysqli_query($mysqli, $sql_chamado1);
$chamado = mysqli_fetch_assoc($resut_chamado1);

$resut_solicitante = mysqli_query($mysqli, $sql_solicitante);
$solicitante = mysqli_fetch_assoc($resut_solicitante);

$resut_atendente = mysqli_query($mysqli, $sql_atendente);
$atendente = mysqli_fetch_assoc($resut_atendente);

if (empty($atendente['atendente'])) {
    $atendente = "Sem atendente";
} else {
    $atendente = $atendente['atendente'];
}

$id_usuario = $_SESSION['id'];

$sql_captura_id_pessoa =
    "SELECT
u.pessoa_id as pessoaID
FROM
usuarios as u
WHERE
id = '$id_usuario'";

$result_cap_pessoa = mysqli_query($mysqli, $sql_captura_id_pessoa);
$pessoaID = mysqli_fetch_assoc($result_cap_pessoa);
?>

<style>
    .playColor {
        border-radius: 4px;
        background-color: #98FB98;
    }
</style>

<?php
if ($chamado['in_execution'] == 1) {
    $classeColor = "playColor";
} else {
    $classeColor = "";
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Chamado #<?= $id_chamado ?></h1>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="container">
                            <div class="row justify-content-between <?= $classeColor ?>">
                                <div class="col-5">

                                    <?php
                                    $calc_tempo_total =
                                        "SELECT SUM(seconds_worked) as secondsTotal
                                        from chamado_relato
                                        where chamado_id = $id_chamado";

                                    $seconds_total = mysqli_query($mysqli, $calc_tempo_total);
                                    $res_second = $seconds_total->fetch_array();
                                    ?>

                                    <h5 class="card-title">Tipo de atendimento: <?= $chamado['tipo']; ?> </h5>
                                    <b>Empresa:</b> <?= $chamado['empresa']; ?> <br>
                                    <b>Solicitante:</b> <?= $solicitante['solicitante']; ?><br>
                                    <b>Atendente:</b> <?= $atendente ?><br><br>
                                    <b>Tempo total de atendimento:</b> <?= gmdate("H:i:s", $res_second['secondsTotal']); ?> <br>
                                </div>

                                <div class="col-5">
                                    <h5 class="card-title"></h5><br>
                                    <b>Data abertura: </b><?= $chamado['abertura']; ?> <br>
                                    <b>Data fechamento: </b><?= $chamado['fechado']; ?> <br>
                                    <b>Status: </b><?= $chamado['status']; ?> <br><br>

                                </div>

                                <div class="col-2">
                                    <?php
                                    if ($chamado['status'] != "Fechado") { ?>
                                        <button style="margin-top: 15px" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#basicModal">
                                            Inserir um relato
                                        </button>
                                    <?php } ?>
                                </div>

                                <div class="modal fade" id="basicModal" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Novo relato</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <form method="POST" action="processa/newRelato.php" class="row g-3 needs-validation">

                                                        <input hidden id="chamadoID" name="chamadoID" value="<?= $id_chamado ?>"></input>

                                                        <input hidden id="relatorID" name="relatorID" value="<?= $pessoaID['pessoaID']; ?>"></input>

                                                        <input hidden id="startTime" name="startTime" value="<?= $chamado['in_execution_start']; ?>"></input>

                                                        <div class="col-12">
                                                            <label for="novoRelato" class="form-label">Relato</label>
                                                            <textarea id="novoRelato" name="novoRelato" class="form-control" maxlength="1000" rows="8" required></textarea>
                                                        </div>

                                                        <hr class="sidebar-divider">

                                                        <div class="text-center">
                                                            <button name="salvar" type="submit" class="btn btn-danger">Relatar</button>

                                                            <a href="/chamado/consulta_chamado/view.php?id=<?= $id_chamado ?>"> <input type="button" value="Voltar" class="btn btn-secondary"></input></a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <hr class="sidebar-divider">

                        <div class="accordion" id="accordionFlushExample">

                            <?php
                            $resultado_relatos = mysqli_query($mysqli, $sql_relatos)  or die("Erro ao retornar dados");

                            $cont = 1;

                            while ($campos = $resultado_relatos->fetch_array()) {
                                $id_relato = $campos['id_relato'];
                                $tempoAtendimento = gmdate("H:i:s", $campos['seconds_worked']);

                            ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-heading<?= $cont ?>"> <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $cont ?>" aria-expanded="false" aria-controls="flush-collapse<?= $cont ?>">Relato #<?= $id_relato ?> - <?= $campos['relatante']; ?></button></h2>
                                    <div id="flush-collapse<?= $cont ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $cont ?>" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <b>Relatante: </b> <?= $campos['relatante']; ?> <br>
                                            <b>Período: </b> <?= $campos['inicio']; ?> à <?= $campos['final']; ?><br>
                                            <b>Tempo de atendimento: </b> <?= $tempoAtendimento ?><br>

                                            <hr class="sidebar-divider">

                                            <b>Descrição: </b> <br><?= nl2br($campos['relato']); ?>
                                        </div>
                                    </div>
                                </div>


                            <?php $cont++;
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
require "../../includes/footer.php";
?>