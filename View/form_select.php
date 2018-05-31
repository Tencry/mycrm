<?if($caption!='' && $type!='hidden'):?><label><?=$caption?></label><?endif;?>
<div class="input-append" rel="<?=$model?>">
<select name="<?=$name?>">
  <?foreach ($options as $option):?>
<?echo '<pre>';
print_r($option);
echo '</pre>';?>
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
	<a href="javascript:void(0)" class="btn find_reference" rel="pagegrid.php?model=<?=$model?>">найти</a>
</div>
