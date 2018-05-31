<script>
	$(function() {
		$( '<?=$id?>' ).datepicker();
	});
</script>
<?if($caption!='' && $type!='hidden'):?><label><?=$caption?><?if($required):?> <em>*</em><?endif;?></label><?endif;?>
<input id="<?=$id?>" class="<?=$class?> <?=$required?> input-xxlarge" type="<?=$type?>" value="<?=htmlspecialchars($value)?>" name="<?=$name?>" placeholder="<?=$placeholder?>"
<?if($minlength):?> minlength="<?=$minlength?>"<?endif;?>>
<br>
