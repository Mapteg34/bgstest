<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<table id="books_list">
	<thead>
		<tr>
			<th>ID</th>
			<th>NAME</th>
			<th>AUTHOR</th>
			<th colspan="2">RATING</th>
		</tr>
	</thead>
	<tbody>
		<?foreach($arResult["BOOKS"] as $arBook):?>
			<tr data-bookid="<?=htmlspecialcharsEx($arBook["ID"])?>">
				<td><?=htmlspecialcharsEx($arBook["ID"])?></td>
				<td><?=htmlspecialcharsEx($arBook["NAME"])?></td>
				<td><?=htmlspecialcharsEx($arBook["AUTHOR"])?></td>
				<td class="avg"><?=htmlspecialcharsEx($arBook["RATING_AVG"])?></td>
				<td>
					<input type="button" value="1" />
					<input type="button" value="2" />
					<input type="button" value="3" />
					<input type="button" value="4" />
					<input type="button" value="5" />
				</td>
			</tr>
		<?endforeach?>
	</tbody>
</table>