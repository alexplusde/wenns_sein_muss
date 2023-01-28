<script type="text/plain" data-category="<?= $this->getVar('category') ?>" data-service="<?= $this->getVar('service') ?>">
    <?= preg_replace("/<script.*?>(.*)<\/script>/s", "", $this->getVar('script')) ?>
</script>
