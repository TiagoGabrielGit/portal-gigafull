<?php
require "../../includes/menu.php";
require "../../conexoes/conexao.php";


$usuario_id = $_SESSION['id'];
require "sql.php";

?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Abrir novo chamado</h1>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Novo chamado</h5>
                        <!-- Horizontal Form -->
                        <form id="abrirChamado" method="POST" class="row g-3">

                            <span id="msg"></span>

                            <input hidden id="solicitante" name="solicitante" value="<?= $_SESSION['id']; ?>"></input>


                            <div class="col-3">
                                <label for="empresaChamado" class="form-label">Empresa</label>
                                <select class="form-select" id="empresaChamado" name="empresaChamado" required>
                                    <option disabled selected value="">Selecione a empresa</option>
                                    <?php
                                    $resultado = mysqli_query($mysqli, $sql_lista_empresas);
                                    while ($tipos = mysqli_fetch_object($resultado)) :
                                        echo "<option value='$tipos->id_empresa'> $tipos->fantasia_empresa</option>";
                                    endwhile;
                                    ?>
                                </select>
                            </div>

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

                            <div class="col-3"></div>

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
                                <input id="btnSalvar" name="btnSalvar" type="button" value="Salvar" class="btn btn-primary"></input>
                                <button type="reset" class="btn btn-secondary">Limpar</button>
                            </div>

                            <div class="col-4"></div>
                        </form><!-- End Horizontal Form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php
require "scripts/abrir_chamado.php";
require "../../includes/footer.php";
?>