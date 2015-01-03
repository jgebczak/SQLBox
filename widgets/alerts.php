    <!-- =========================================================================================================== -->
    <!-- MESSAGE (ACTION CONFIRMATION) -->

    <?php if ($_REQUEST['msg']): ?>
        <div class='alert_box success'>
            <?=$_REQUEST['msg']?>
        </div>
        <BR>
    <?php endif ?>

    <?php if ($_REQUEST['error']): ?>
        <div class='alert_box error'>
            <?=$_REQUEST['error']?>
        </div>
        <BR>
    <?php endif ?>
    <div class="clear"></div>