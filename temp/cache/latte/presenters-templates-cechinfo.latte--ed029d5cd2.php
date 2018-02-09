<?php
// source: D:\Programy\xampp\htdocs\foe\app\presenters\templates\cechinfo.latte

use Latte\Runtime as LR;

class Templateed029d5cd2 extends Latte\Runtime\Template
{

	function main()
	{
		extract($this->params);
?>

	<div>
        <h1>Cech: <?php echo LR\Filters::escapeHtmlText($cech['nazov_cechu']) /* line 3 */ ?> (<?php echo LR\Filters::escapeHtmlText($cech['server']) /* line 3 */ ?>)</h1><br>
        <table class="table table-striped">
            <tr>
                <th class="bunka"> Úroveň: </th>
                <th class="bunka"> Počet členov: </th>
                <th class="bunka"> Počet VB hvezdáreň: </th>
                <th class="bunka"> Počet VB atomium: </th>
                <th class="bunka"> Počet VB oblúk: </th>
            </tr>
            <tr>
                <td class="bunka"><?php echo LR\Filters::escapeHtmlText($cech['uroven']) /* line 13 */ ?></td>
                <td class="bunka"><?php echo LR\Filters::escapeHtmlText($pocet_clenov) /* line 14 */ ?></td>
                <td class="bunka"><?php echo LR\Filters::escapeHtmlText($hvezdaren_pocet) /* line 15 */ ?></td>
                <td class="bunka"><?php echo LR\Filters::escapeHtmlText($atomium_pocet) /* line 16 */ ?></td>
                <td class="bunka"><?php echo LR\Filters::escapeHtmlText($obluk_pocet) /* line 17 */ ?></td>
            </tr>
            <tr>
                <th>Informačná tabuľa:</th>
                <td colspan="4" title="Pre odriadkovanie vložte <br>."><?php echo $cech['info'] /* line 21 */ ?></td>
            </tr>
<?php
		if (!($is_role_clen)) {
?>            <tr>
                <th>Poznámka:</th>
                <td colspan="4" title="Pre odriadkovanie vložte <br>."><?php echo $cech['poznamka'] /* line 25 */ ?></td>
            </tr>
<?php
		}
?>
        </table>
    </div>
<?php
		if ($is_role_admin) {
?>    <div class="menu_box_left">
		<a class="btn btn-primary btn-sm active" role="button" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("User:create")) ?>">Pridadanie nového člena</a>
		<a class="btn btn-primary btn-sm active" role="button" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Cech:editCech")) ?>">Uprav cechové údaje</a>
                <a class="btn btn-primary btn-sm active" role="button" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Prispevok:hromadnyPrispevok")) ?>">Hromadné príspevky</a>
	</div>
<?php
		}
?>
    <br>


<?php
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}

}
