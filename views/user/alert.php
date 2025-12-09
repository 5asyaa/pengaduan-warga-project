<?php if (!empty($success)) : ?>
<script>
    alert("<?= $success ?>");
    window.location.href = "dashboard.php";
</script>
<?php endif; ?>
