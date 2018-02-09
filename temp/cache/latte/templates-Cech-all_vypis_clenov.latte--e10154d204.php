<?php
// source: D:\Programy\xampp\htdocs\foe\app\presenters\templates\Cech\all_vypis_clenov.latte

use Latte\Runtime as LR;

class Templatee10154d204 extends Latte\Runtime\Template
{

	function main()
	{
		extract($this->params);
		if ($users_cech) {
?><div>
        <div>
            <table class="table table-striped">
                <tr>
                    <th>Hráč</th>
                    <th>Éra</th>
                    <th title="Chrám relikvií">ChR</th>
                    <th title="Alcatraz">ALC</th>
                    <th title="Hvezdáreň">HV</th>
                    <th title="Atómium">AT</th>
                    <th title="Oblúk">OB</th>
                    <th title="Suroviny z VB za 7 dní pri pravidelnom vyberaní (uvedený počet každej suroviny, nie spolu)">S/7D</th>
                    <th title="Príspevky hráča">Príspevky</th>
                </tr>
<?php
			$iterations = 0;
			foreach ($users_cech as $clen) {
?>                <tr 
				>
                    <td><?php
				if ($this->global->ifs[] = (($is_role_admin) || ($is_role_clen && $user_id == $clen->userid))) {
					?><a class="btn btn-default btn-sm active" role="button" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("User:edit", [$clen->userid])) ?>"><?php
				}
				echo LR\Filters::escapeHtmlText($clen->nick) /* line 25 */;
				if (array_pop($this->global->ifs)) {
					?></a><?php
				}
?>
</td>
					<td><?php echo LR\Filters::escapeHtmlText($ery[$clen->era]['nazov']) /* line 27 */ ?></td>
                    <td style="text-align: center"><?php
				if ($clen->relikvie > 0) {
					?><span title="Chrám relikvií"><?php echo LR\Filters::escapeHtmlText($clen->relikvie) /* line 28 */ ?></span><?php
				}
?>
</td>
                    <td style="text-align: center"><?php
				if ($clen->alcatraz > 0) {
					?><span title="Alcatraz"><?php echo LR\Filters::escapeHtmlText($clen->alcatraz) /* line 29 */ ?></span><?php
				}
?>
</td>
                    <td style="text-align: center"><?php
				if ($clen->hvezdaren > 0) {
					?><span title="Hvezdáreň"><?php echo LR\Filters::escapeHtmlText($clen->hvezdaren) /* line 30 */ ?></span><?php
				}
?>
</td>
                    <td style="text-align: center"><?php
				if ($clen->atomium > 0) {
					?><span title="Atómium"><?php echo LR\Filters::escapeHtmlText($clen->atomium) /* line 31 */ ?></span><?php
				}
?>
</td>
                    <td style="text-align: center"><?php
				if ($clen->obluk > 0) {
					?><span title="Oblúk"><?php echo LR\Filters::escapeHtmlText($clen->obluk) /* line 32 */ ?></span><?php
				}
?>
</td>
					
<?php
				$suroviny_spolu = 5*(($hvezdaren_info[$clen->hvezdaren] * 1)+($atomium_info[$clen->atomium] * 1)+($obluk_info[$clen->obluk] * 1));
?>
					
                    <td style="text-align: center"><?php
				if ($suroviny_spolu > 0) {
					?><span title="Suroviny celkom"><?php echo LR\Filters::escapeHtmlText($suroviny_spolu) /* line 36 */ ?></span><?php
				}
?>
</td>
                    <td>
<?php
				if (($is_role_admin)) {
					?>			<a class="btn btn-default btn-sm active" role="button" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Prispevok:vypisVsetko", [$clen->userid])) ?>">Príspevky</a>
<?php
				}
?>
                    </td>
<?php
				if (!($is_role_clen)) {
?>                    <tr>
			<td>Poznámka:</td>
			<td colspan="8"><?php
					if ($clen->last_login !== null) {
						?><p style="color: green">Posledné prihlásenie: <?php echo LR\Filters::escapeHtmlText(call_user_func($this->filters->date, $clen->last_login, '%d.%m.%Y - %H:%M:%S')) /* line 44 */ ?></p><?php
					}
					echo $clen->poznamka /* line 44 */ ?></td>
                    </tr>
<?php
				}
?>
                </tr>
<?php
				$iterations++;
			}
?>
            </table>
        </div>
    </div>
<?php
		}
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['clen'])) trigger_error('Variable $clen overwritten in foreach on line 16');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}

}
