<?php
require "../includes/menu.php";
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Changelog</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">

                        <!-- Default Accordion -->
                        <div class="accordion" id="accordionExample">

                            <!-- Versão 1.0 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading1-0">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1-0" aria-expanded="false" aria-controls="collapse1-0">
                                        Versão 1.0 - XX/07/2022
                                    </button>
                                </h2>
                                <div id="collapse1-0" class="accordion-collapse collapse" aria-labelledby="heading1-0" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <strong>Novas funcionalidades</strong><br>
                                        1. Lançada versão 1 onde permite abrir chamado e visualizar de forma macro;<br>

                                        <br><strong>Melhorias</strong><br>
                                        1. ;<br>

                                        <br><strong>Correções de BUG</strong><br>
                                        1. <br>

                                        <br><strong>Alterações banco de dados</strong><br>
                                        1. Criado a tabela tipos_chamados;<br>
                                        2. Criado a tabela portal_log_acesso;<br>
                                        3. Criado a tabela portal_user;<br>
                                        4. Criado a tabela chamados;<br>
                                        5. Criado a tabela chamados_status;<br>
                                        6. Criado a tabela chamado_relato;<br>
                                        7. Criado a tabela portal_user_empresa;<br>

                                        <br><strong>Previsto para próximas atualizações</strong><br>
                                        1. Poder relatar no chamado;<br>
                                        2. Ver os relatos do chamado;<br>
                                        3. Trocar senha do usuário;<br>

                                    </div>
                                </div>
                            </div>

                        </div><!-- End Default Accordion Example -->

                    </div>
                </div>

            </div>

        </div>
    </section>

</main><!-- End #main -->

<?php
require "../includes/footer.php";
?>