<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";
require "../../conexoes/conexao_pdo.php";

$usuario_id = $_SESSION['id'];
require "sql.php";

$query = $pdo->query($empresa_id);
$return = $query->fetch();

$empresa = $return['empresa_id'];


$lista_chamados =
    "SELECT
ch.id as id_chamado,
ch.assuntoChamado as assunto,
ch.data_abertura as dataAbertura,
cs.status_chamado as statusChamado,
tc.tipo as tipoChamado,
emp.fantasia as fantasia
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
WHERE
ch.empresa_id = $empresa
ORDER BY
ch.data_abertura DESC
";
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Listagem de chamados</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">

                    <div class="card-body">

                        <hr class="sidebar-divider">

                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th style="text-align: center;" scope="col">Número</th>
                                    <th style="text-align: center;" scope="col">Empresa</th>
                                    <th style="text-align: center;" scope="col">Tipo chamado</th>
                                    <th style="text-align: center;" scope="col">Assunto</th>
                                    <th style="text-align: center;" scope="col">Data abertura</th>
                                    <th style="text-align: center;" scope="col">Status</th>
                                    <th style="text-align: center;" scope="col">Visualizar chamado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $resultado = mysqli_query($mysqli, $lista_chamados) or die("Erro ao retornar dados");
                                while ($campos = $resultado->fetch_array()) {
                                    $id = $campos['id_chamado'];
                                    echo "<tr>";
                                ?>
                                    </td>
                                    <td style="text-align: center;"><?= $campos['id_chamado']; ?></td>
                                    <td style="text-align: center;"><?= $campos['fantasia']; ?></td>
                                    <td style="text-align: center;"><?= $campos['tipoChamado']; ?></td>
                                    <td style="text-align: center;"><?= $campos['assunto']; ?></td>
                                    <td style="text-align: center;"><?= $campos['dataAbertura']; ?></td>
                                    <td style="text-align: center;"><?= $campos['statusChamado']; ?></td>
                                    <td style="text-align: center;">
                                        <a class="bi bi-eye-fill" href="view.php?id=<?= $campos['id_chamado']; ?>"></a>
                                    </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php
require "../../includes/footer.php";

?>