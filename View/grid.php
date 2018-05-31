<?$php_self=$_SERVER['PHP_SELF'];?>
<div class="table_grid" rel="<?=$php_self?>?cut_object=<?=$name?>&model=<?=$prefix?>&<?=$prefix?>=1">
<p>
<?if ($allowAdd):?>
<a class="btn btn-primary grid_add" href="javascript:void(0)" rel="pagegrid.php?model=<?=$prefix?>&<?=$prefix?>_add=1">Добавить</a>
<?endif?>
<?if ($exportXLS):?>
<a class="btn btn-primary" href="?cut_objects=1&<?=$prefix?>=1&export=xls">XLS</a>
<?endif?>
<?if ($exportPDF):?>
<a class="btn btn-primary" href="?cut_objects=1&<?=$prefix?>=1&export=pdf">PDF</a>
<?endif?>
<?if ($exportCSV):?>
<a class="btn btn-primary" href="?cut_objects=1&<?=$prefix?>=1&export=csv">CSV</a>
<?endif?>
</p>
<?if ($filter):?>
<form class="navbar-search pull-right searchForm" method="post" action="<?=$php_self?>?model=<?=$prefix?>">
<input class="search-query" placeholder="Поиск" type="text" name="<?=$prefix?>_sword" value="<?=Input::remember($prefix.'_sword')?>">
<button class="btn" type="submit" name="<?=$prefix?>_search" option="1" value="search"><i class="icon-search"></i></button>
<button class="btn clearsearch " type="submit" name="<?=$prefix?>_clear" option="2" value="clear"><i class="icon-remove"></i></button>
</form>
<?endif?>
<div class="unit">
<table class="table table-striped">
<tr>
<?foreach ($headers as $header):?>
	<th>
    <?if ($header->sortable):?>
		<a href="javascript:void(0)" class="sortby" rel="<?=$prefix?>_sortby=<?=($_GET[$prefix.'_sortby']==$header->name ? '-' : '').$header->name?>"><?=$header->caption?></a>&nbsp;
		<?else:?>
		<?=$header->caption?>
	<?endif?>
	</th>
<?endforeach?>
<!--
<? if ($allowEdit) { ?> <th>edit</th> <? } ?>
<?if ($links):?>
	<?foreach ($links as $key => $value):?>
		<th>
			<?=$key?>
		</th>
	<?endforeach?>
<?endif?>
-->
</tr>
<?if ($rows): ?>
	<?foreach ($rows as $row):?>
	<tr>
		<?foreach ($row as $key => $value):?>
			<?if ($key == 'name' && ($allowEdit || $allowSelect || $links)):?>
				<td>
				<div class="btn-group">
					<a class="btn btn-link" data-toggle="dropdown" href="#"><span><?=$value?></span><span class="caret"></span></a>
				    <ul class="dropdown-menu <?if (strlen($value) > 20):?> pull-right <?endif?>">
				    	<? if ($allowSelect) { ?><li><a href="javascript:void(0)" class="grid_select" rel="pagegrid.php?selectoptions=<?=$row['id']?>&model=<?=$prefix?>"><i class="icon-ok"></i>выбрать</a></li><? } ?>
					    <? if ($allowEdit) { ?><li><a href="javascript:void(0)" class="grid_edit" rel="pagegrid.php?model=<?=$prefix?>&<?=$prefix?>_id=<?=$row[id]?>"><i class="icon-pencil"></i>редактировать</a></li><? } ?>
						<?if ($links):?>
							<li class="divider"></li>
							<?foreach ($links as $key => $value):?>
								<li><a href="javascript:void(0);" onclick="<?=$value?>"><?=$key?></a></li>
							<?endforeach?>
						<?endif?>
				    </ul>
			    </div>
			    </td>
			<?else:?>
				<td><?=$value?>&nbsp;</td>
			<?endif?>
		<?endforeach?>
		<!--
		<? if ($allowEdit) { ?><td><a href="javascript:void(0)" class="grid_edit" rel="pagegrid.php?model=<?=$prefix?>&<?=$prefix?>_id=<?=$row[id]?>">edit</a></td><? } ?>
		<? if ($allowSelect) { ?><td><a href="javascript:void(0)" class="grid_select" rel="pagegrid.php?selectoptions=<?=$row['id']?>&model=<?=$prefix?>">выбрать</a></td><? } ?>
		<?if ($links):?>
			<?foreach ($links as $key => $value):?>
				<td>
				<a href="javascript:void(0);" class="<?=$prefix?>_<?=$key?>_link"><?=$key?></a>
				</td>
			<?endforeach?>
		<?endif?>
		-->
	</tr>
	<?endforeach?>
<?endif?>

</table>

<?if ($pagenums):?>
<div class="pagination pagination-centered">
	<ul>
	<?foreach ($pagenums as $pagenum):?>
		<?if ($pagenum=='..' || $pagenum==$page):?>
			<li class="active"><a href="#"><?=$pagenum?></a></li>
			<?else:?>
			<li><a href="javascript:void(0)" class="page" rel="<?=$prefix?>_page=<?=$pagenum?>"><?=$pagenum?></a></li>
		<?endif?>
	<?endforeach?>
	</ul>
</div>
<?endif?>
</div>
<hr />
</div>
