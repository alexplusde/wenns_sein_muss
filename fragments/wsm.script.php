<script type="text/plain"
	data-category="<?= $this->getVar('category') ?>"
	data-service="<?= rex_string::normalize($this->getVar('service')) ?>">
	<?= preg_replace(
    '#<script[^>]*>([^<]+)</script>#',
    '$1',
    $this->getVar('script')
) ?>
</script>
