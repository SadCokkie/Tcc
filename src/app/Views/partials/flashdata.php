<?php if (session()->getFlashdata('sucesso')) { ?>
    <script type="text/javascript">
        $.bootstrapGrowl("<?php echo session()->getFlashdata('sucesso'); ?>", {
            ele: "body",
            type: "success",
            offset: {from: "bottom", amount: 50},
            align: "right",
            width: 300,
            delay: 5000,
            allow_dismiss: true,
            stackup_spacing: 10
        });
    </script>
<?php } elseif (session()->getFlashdata('erro')) { ?>
    <script type="text/javascript">
        $.bootstrapGrowl("<?php echo session()->getFlashdata('erro'); ?>", {
            ele: "body",
            type: "danger",
            offset: {from: "bottom", amount: 50},
            align: "right",
            width: 300,
            delay: 5000,
            allow_dismiss: true,
            stackup_spacing: 10
        });
    </script>
<?php } elseif (isset($error)) { ?>
    <script type="text/javascript">
        swal({
            allowEscapeKey: false,
            title: "Atenção!",
            text: "<?= $error; ?>",
            type: "warning",
            confirmButtonClass: "btn grey"
        },
            function (inputValue) {
                if (inputValue === false) {
                    return false;
                }
                window.close();
            }
        );
    </script>
<?php } ?>