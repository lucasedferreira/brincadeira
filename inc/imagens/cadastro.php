<div class="container">
    <div class="card text-white bg-dark mb-3 border-light">
        <h5 class="card-header">Cadastro</h5>
        <div class="card-body">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link text-info active" id="nav-normal-tab" data-toggle="tab" href="#nav-normal" role="tab" aria-controls="nav-normal" aria-selected="true">Normal</a>
                    <a class="nav-item nav-link text-info" id="nav-rapido-tab" data-toggle="tab" href="#nav-rapido" role="tab" aria-controls="nav-rapido" aria-selected="false">Rápido</a>
                    <a class="nav-item nav-link text-info" id="nav-lento-tab" data-toggle="tab" href="#nav-lento" role="tab" aria-controls="nav-lento" aria-selected="false">Lento</a>
                    <a class="nav-item nav-link text-info" id="nav-varias-tab" data-toggle="tab" href="#nav-varias" role="tab" aria-controls="nav-varias" aria-selected="false">Várias Imagens</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-normal" role="tabpanel" aria-labelledby="nav-normal-tab">
                    <?php include_once('inc/imagens/normal.php'); ?>
                </div>
                <div class="tab-pane fade" id="nav-rapido" role="tabpanel" aria-labelledby="nav-rapido-tab">
                    <?php include_once('inc/imagens/rapido.php'); ?>
                </div>
                <div class="tab-pane fade" id="nav-lento" role="tabpanel" aria-labelledby="nav-lento-tab">
                    <?php include_once('inc/imagens/lento.php'); ?>
                </div>
                <div class="tab-pane fade" id="nav-varias" role="tabpanel" aria-labelledby="nav-varias-tab">
                    <?php include_once('inc/imagens/varias.php'); ?>
                </div>
            </div>
        </div>
    </div>
</div>