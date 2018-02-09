<?php
// source: D:\Programy\xampp\htdocs\foe\app\presenters/templates/Prispevok/vypisVsetko.latte

use Latte\Runtime as LR;

class Templatebed02051a8 extends Latte\Runtime\Template
{
	public $blocks = [
		'content' => 'blockContent',
	];

	public $blockTypes = [
		'content' => 'html',
	];


	function main()
	{
		extract($this->params);
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('content', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['prispevok'])) trigger_error('Variable $prispevok overwritten in foreach on line 21');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
?>
<div>
    <br>
    <div class="menu_box_left">
	<a class="btn btn-primary btn-sm active" role="button" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Cech:showAll")) ?>">Späť na prehľad cechu</a>
	<a  class="btn btn-primary btn-sm active" role="button" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Prispevok:addPrispevok", [$id])) ?>">Nový príspevok</a>
    </div>
    
<?php
		/* line 9 */
		$this->createTemplate('../cechinfo.latte', $this->params, "include")->renderToContentType('html');
		?>    <h2>Úprava príspevkov hráča: <?php echo LR\Filters::escapeHtmlText($user_edited->fetchField('nick')) /* line 10 */ ?></h2>
    
<?php
		if (isset($prispevok_sum)) {
?>    <div>
        <table class="table table-striped">
            <tr>
                <th style="text-align: center">Týždeň</th>
                <th style="text-align: center">Suroviny celkom</th>
                <th style="text-align: center">Body do VB</th>
                <th style="text-align: center">CE</th>
                <th style="text-align: center">Upraviť</th>
            </tr>
<?php
			$iterations = 0;
			foreach ($iterator = $this->global->its[] = new LR\CachingIterator($prispevky) as $prispevok) {
?>            <tr>
                <td style="text-align: center"><?php echo LR\Filters::escapeHtmlText($prispevok['termin']) /* line 22 */ ?></td>
                <td style="text-align: center"><?php echo LR\Filters::escapeHtmlText($prispevok_sum[$iterator->counter - 1]) /* line 23 */ ?></td>
                <td style="text-align: center"><?php echo LR\Filters::escapeHtmlText($prispevok['bodyVB']) /* line 24 */ ?></td>
                <td style="text-align: center"><?php echo LR\Filters::escapeHtmlText($prispevok['CE']) /* line 25 */ ?></td>
<?php
				if (!$is_role_clen || $id == $user_id) {
?>                <td style="text-align: center">
                    <a class="btn btn-default btn-sm active" role="button" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Prispevok:editPrispevok", [$prispevok['id'], $id_user])) ?>">Upraviť</a>
		</td>
<?php
				}
?>
            </tr>
<?php
				$iterations++;
			}
			array_pop($this->global->its);
			$iterator = end($this->global->its);
?>
        </table>
    </div>
<?php
		}
?>
</div>

<?php
	}

}
