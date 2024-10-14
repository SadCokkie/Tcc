<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu float-start" style="margin-top: 0;">
    <div class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li><a href="/" class="waves-effect"><span>Dashboard</span></a></li>
                <li>
                    <a href="javascript: void(0);" class="waves-effect has-arrow"><span>Rotinas</span></a>
                    <ul>
                        <li><a href=<?php echo site_url("Movimentacoes/?Entrada=0");?>>Entrada de Materiais</a></li>
                        <li><a href=<?php echo site_url("Movimentacoes/?Entrada=1");?>>Baixa de Materiais</a></li>
                        <li><a href=<?php echo site_url("Movimentacoes/?Entrada=2");?>>Transferência de Materiais</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="waves-effect has-arrow"><span>Suprimentos</span></a>
                    <ul>
                        <li><a href=<?php echo site_url("Materiais/");?>>Materiais</a></li>
                        <li><a href=<?php echo site_url("Cas/");?>>Centros de Armazenagem</a></li>
                        <li><a href=<?php echo site_url("Grupos/");?>>Grupos de Materiais</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="waves-effect has-arrow"><span>Configurações</span></a>
                    <ul>
                        <li><a href=<?php echo site_url("Usuarios/");?>>Usuários</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="waves-effect has-arrow"><span>Relatórios</span></a>
                    <ul>
                        <li><a href=<?php echo site_url("Relatorios/estoque");?>>Estoque</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->