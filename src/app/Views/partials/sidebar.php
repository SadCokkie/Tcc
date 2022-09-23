<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu float-start" style="margin-top: 0;">
    <div class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <?php foreach ($sidebar as $m_key => $menu_0) {
                        if (isset($menu_0['filhos'])) { ?>
                        <li>
                            <a href="javascript: void(0);" class="waves-effect has-arrow"><span><?= $menu_0['Nome'] ?></span></a>
                            <?php foreach ($menu_0['filhos'] as $key_0 => $menu_1) { ?>
                                <ul class="sub-menu" aria-expanded="true">
                                    <?php if (isset($menu_1['filhos'])) { ?>
                                        <li><a href="javascript: void(0);" class="has-arrow"><?= $menu_1['Nome'] ?></a>
                                            <ul class="sub-menu" aria-expanded="true">
                                                <?php foreach ($menu_1['filhos'] as $key_1 => $menu_2) { ?>
                                                    <li><a href="/<?= $menu_2['Rota'] ?>"><?= $menu_2['Nome'] ?></a></li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                    <?php } else { ?>
                                        <li><a href="/<?= $menu_1['Rota'] ?>"><?= $menu_1['Nome'] ?></a></li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </li>
                    <?php } else { ?>
                        <li><a href="/<?= $menu_0['Rota'] ?>" class="waves-effect"><span><?= $menu_0['Nome'] ?></span></a></li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->