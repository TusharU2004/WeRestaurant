<?php
$getSettings = mysqli_query($conn, "SELECT * FROM `settings` WHERE 1");
$fetchSettings = mysqli_fetch_array($getSettings);
if($fetchSettings['isgst'] == 1) {
?>
	<input type="hidden" id="applyTotalTax" value="<?php echo ($fetchSettings['taxpercentage1']+$fetchSettings['taxpercentage2']); ?>" />
<?php } else { ?>
	<input type="hidden" id="applyTotalTax" value="0" />
<?php } ?>
<footer class="app-footer">
<a href="http://wcodez.com">WebcodeZ Infoway</a> © <?php echo date('Y'); ?>
<span class="float-right">Developed by <a href="http://wcodez.com">WebcodeZ Infoway</a>
</span>
</footer>