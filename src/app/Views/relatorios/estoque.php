<?= $this->include('partials/header') ?>
    <div style="margin-left: 0; margin-right: 0; padding-left: 0;">
        <div id="layout-wrapper">
            <?= $this->include('partials/menu') ?>
            <div class="main-content">
                <div class="page-content">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <!-- ============================================================== -->
                                <!-- Start Content here -->
                                <!-- ============================================================== -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <h4 class="card-title"><?= $titulo ?></h4>
                                        </div>
                                    </div>
                                    
                            <?php foreach ($estoque['material'] as $key => $value):?>
                                <table class="table table-hover table-condensed table-striped" id="tabela_atividade" width="100%">
                                    <thead>
                                        <tr>
                                            <td><b>Material</b> : <?= $value['Descricao']?></td>
                                            
                                        </tr>
                                        <tr>
                                            <td align='center' width="35%"><b>Movimentação</b></td>
                                            <td align='center'><b>CA</b></td>
                                            <td align='center'><b>Grupo</b></td>
                                            <td align='center'><b>Quantidade</b></td>
                                            <td align='center'><b>Data</b></td>
                                        </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($estoque['data'] as $row) {
                                        switch ($row['Entrada']) {
                                            case 'Entrada':
                                                $total_entrada = $row['Total_entrada'];
                                                break;
                                            case 'Baixa':
                                                $total_saida = $row['Total_saida'];
                                                break;
                                            case 'Transferência':
                                                $total_transferencia = $row['Total_transferencia'];
                                                break;
                                            
                                        }
                                        ?>
                                        <tr>
                                            <td align='center'> <?php echo $row['Entrada']; ?> </td>
                                            <td align='center'> <?php echo $row['Ca']; ?> </td>
                                            <td align='center'> <?php echo $row['Nome']; ?> </td>
                                            <td align='center'> <?php echo $row['Movimentacao']; ?> </td>
                                            <td align='center'> <?php echo $row['data']; ?> </td>
                                        </tr>
                                    <?php
                                    
                                    }
                                    ?>
                                    <!-- <tr>
                                        <td colspan="3" align='right'> <b>Total Entradas:</b> </td>
                                        <td align='center'> <?php //echo $total_entrada; ?> </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align='right'> <b>Total Baixas:</b> </td>
                                        <td align='center'> <?php //echo $total_saida; ?> </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align='right'> <b>Total Transferências:</b> </td>
                                        <td align='center'> <?php //echo $total_transferencia; ?> </td>
                                    </tr> -->
                                    				
                                </tbody>				
                            </table>
                            <br>
                            <?php endforeach;?>

                                    
                                </div>
                                <!-- ============================================================== -->
                                <!-- END Content here -->
                                <!-- ============================================================== -->
                            </div>
                        </div>
                    </div>
                </div>
                <?= $this->include('partials/footer') ?>
            </div>
        </div>
    </div>
    <!-- SCRIPTS -->
    <?= $this->include('partials/scripts') ?>

    <script type="text/javascript">
        
    </script>
</body>

</html>