<fieldset>
<?if($caption!='' && $type!='hidden'):?><label><?=$caption?></label><?endif;?>
<div class="hasmany">

<?
///	$model = $>model;
	if (is_array($linked_records)) :
	foreach ($linked_records as $record) : ?>

<?

//print_r($linked_records);
//$name = $record['name'];
$options = $record['options'];
$value = $record['value'];
//$option_fields = $record['option_fields'];
//$option_separator = $record['option_separator'];

?>
<div class="input-append" rel="<?=$model?>">
<!--<?if($label!='' && $type!='hidden'):?><label><?=$label?></label><?endif;?>
<input id="<?=$id?>" class="<?=$class?>" type="text" value="<?=$value?>" name="<?=$name?>" placeholder="<?=$placeholder?>">-->
<select name="<?=$name?>[<?=++$i?>]">
<!--<select name="hasmany_<?=$model?>[<?//=++$i?>]">-->
  <?foreach ($options as $option):?>
  <option value="<?=$option['id']?>" <?if($value == $option['id']):?>selected<?endif?>>
  <?
  $Arr = array();
  foreach ($option_fields as $field) {
	  $Arr[] = $option[$field];
  }
  echo implode($option_separator, $Arr);
  ?>
  </option>
  <?endforeach;?>
</select>
<a href="javascript:void(0)" class="btn find_hasmany" rel="pagegrid.php?model=<?=$model?>">найти</a>
<a href="javascript:void(0)" class="btn del_hasmany">удалить</a>
<!--<a href="javascript:void(0)" class="btn" onClick="openDialog('pagegrid.php?model=<?=$model?>&<?=$model?>input_name=hasmany_<?=$model?>[<?=$i?>]');">найти</a>-->
</div>
<?
	endforeach;
	endif;
?>
</div>
<a href="javascript:void(0)" class="btn add_hasmany" rel="fieldselect.php?model=<?=$model?>&fieldname=<?=$name?>">Добавить</a>
</fieldset>
<br>

