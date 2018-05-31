<?$i=$_GET['index']?>
<div class="input-append" rel=<?=$model?>>
<select name="<?=$name?>[<?=$i?>]">
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
</div>
