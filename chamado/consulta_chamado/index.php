<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";
require "../../conexoes/conexao_pdo.php";
require "sql1.php";

$id_usuario = $_SESSION['id'];

$sql_captura_dados =
    "SELECT
pue.empresa_id as empresaID,
pu.pessoa_id as pessoaID
FROM
portal_user_empresa as pue
left join
portal_user as pu
on
pu.id = pue.usuario_id
WHERE
pue.usuario_id = '$id_usuario'
";

$result_cap_dados = mysqli_query($mysqli, $sql_captura_dados);
$dados = mysqli_fetch_assoc($result_cap_dados);
$empresaID = $dados['empresaID'];
$pessoaID = $dados['pessoaID'];

$lista_chamados =
    "SELECT
ch.id as id_chamado,
ch.assuntoChamado as assunto,
ch.atendente_id as id_atendente,
ch.data_abertura as dataAbertura,
ch.in_execution as inExecution,
ch.status_id as id_status,
cs.status_chamado as statusChamado,
tc.tipo as tipoChamado,
emp.fantasia as fantasia,
p.nome as atendente
FROM
chamados as ch
LEFT JOIN
empresas as emp 
ON
ch.empresa_id = emp.id
LEFT JOIN
tipos_chamados as tc
ON
ch.tipochamado_id  = tc.id
LEFT JOIN
chamados_status as cs
ON
cs.id = ch.status_id
LEFT JOIN
pessoas as p
ON
p.id = ch.atendente_id
WHERE
ch.empresa_id LIKE '$empresaID'
ORDER BY
ch.data_abertura DESC
";
?>

<style>
    #closed:hover {
        cursor: pointer;
        background-color: #a9a9a9;
    }

    #open:hover {
        cursor: pointer;
        background-color: #c1f8f8;
    }

    #inExecution:hover {
        background-color: #7efb7e;
    }

    .closed {
        background-color: #c8c8c8;
        border-color: black;
    }

    .open {
        background-color: #ecfefe;
        border-color: black;
    }

    .inExecution {
        background-color: #a5fba5;
        border-color: black;
    }
</style>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Listagem de chamados</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">

                    <div class="card-body">

                        <div class="container">
                            <div class="row">
                                <div class="col-9">
                                    <h5 class="card-title">Chamados</h5>
                                </div>
                                <div class="col-3">
                                    <div class="card">
                                        <button style="margin-top: 15px" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#basicModal">
                                            Abrir novo chamado
                                        </button>
                                    </div>
                                </div>

                                <div class="modal fade" id="basicModal" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Novo chamado</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="card-body">
                                                    <form id="abrirChamado" method="POST" class="row g-3">

                                                        <span id="msg"></span>

                                                        <input hidden id="solicitante" name="solicitante" value="<?= $pessoaID ?>"></input>
                                                        <input hidden id="empresaChamado" name="empresaChamado" value="<?= $empresaID ?>"></input>

                                                        <div class="col-6">
                                                            <label for="tipoChamado" class="form-label">Tipo de chamado</label>
                                                            <select class="form-select" id="tipoChamado" name="tipoChamado" required>
                                                                <option disabled selected value="">Selecione o tipo de chamado</option>
                                                                <?php
                                                                $resultado = mysqli_query($mysqli, $sql_lista_tipos_chamados);
                                                                while ($tipos = mysqli_fetch_object($resultado)) :
                                                                    echo "<option value='$tipos->id'> $tipos->tipo</option>";
                                                                endwhile;
                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div class="col-6"></div>

                                                        <div class="col-6">
                                                            <label for="assuntoChamado" class="form-label">Assunto</label>
                                                            <input type="text" class="form-control" id="assuntoChamado" name="assuntoChamado" required>
                                                        </div>

                                                        <div class="col-12">
                                                            <label for="relatoChamado" class="form-label">Descreva a situação</label>
                                                            <textarea id="relatoChamado" name="relatoChamado" class="form-control" maxlength="1000" required></textarea>

                                                        </div>

                                                        <hr class="sidebar-divider">

                                                        <div class="col-4"></div>

                                                        <div class="col-4" style="text-align: center;">
                                                            <input id="btnSalvar" name="btnSalvar" type="button" value="Abrir chamado" class="btn btn-danger"></input>
                                                            <a href="/chamado/consulta_chamado/index.php"> <input type="button" value="Voltar" class="btn btn-secondary"></input></a>
                                                        </div>

                                                        <div class="col-4"></div>
                                                    </form><!-- End Horizontal Form -->
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
                            $resultado = mysqli_query($mysqli, $lista_chamados) or die("Erro ao retornar dados");

                            $cont = 1;

                            while ($campos = $resultado->fetch_array()) {
                                $id_chamado = $campos['id_chamado'];

                                if (empty($campos['atendente'])) {
                                    $atendente = "Sem atendente";
                                } else {
                                    $atendente = $campos['atendente'];
                                }

                                if ($campos['inExecution'] == 1) {
                                    $Color = "inExecution";
                                } else if ($campos['id_status'] == 3) {
                                    $Color = "closed";
                                } else {
                                    $Color = "open";
                                }

                                $calc_tempo_total =
                                    "SELECT SUM(seconds_worked) as secondsTotal
                                from chamado_relato
                                where chamado_id = $id_chamado";

                                $seconds_total = mysqli_query($mysqli, $calc_tempo_total);
                                $res_second = $seconds_total->fetch_array();

                            ?>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-heading<?= $cont ?>">
                                        <button class="accordion-button collapsed <?= $Color ?>" id="<?= $Color ?>" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?= $cont ?>" aria-expanded="false" aria-controls="flush-collapse<?= $cont ?>">
                                            Chamado #<?= $id_chamado ?> - <?= $campos['tipoChamado']; ?> - <?= $campos['assunto']; ?>
                                        </button>
                                    </h2>
                                    <div id="flush-collapse<?= $cont ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?= $cont ?>" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body <?= $Color ?> ">
                                            <div class="row justify-content-between">
                                                <div class="col-5">
                                                    <b>Chamado: </b><?= $id_chamado ?><br>
                                                    <b>Tipo de chamado: </b><?= $campos['tipoChamado']; ?><br>
                                                    <b>Cliente: </b><?= $campos['fantasia']; ?><br>
                                                    <b>Atendente: </b><?= $atendente ?><br>


                                                </div>
                                                <div class="col-5">
                                                    <b>Data abertura: </b><?= $campos['dataAbertura']; ?><br>
                                                    <b>Status: </b><?= $campos['statusChamado']; ?><br><br>

                                                    <b>Tempo total atendimento: </b> <?= gmdate("H:i:s", $res_second['secondsTotal']); ?>
                                                </div>
                                                <div class="col-2">
                                                    <a href="/chamado/consulta_chamado/view.php?id=<?= $id_chamado ?>" title="Visualizar">
                                                        <button type="button" class="btn btn-danger">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                                            </svg>
                                                            Ver chamado
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php $cont++;
                            } ?>
                        </div>

                        <!-- End Table with stripped rows -->
                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php
require "../../scripts/abrir_chamado.php";
require "../../includes/footer.php";
?>