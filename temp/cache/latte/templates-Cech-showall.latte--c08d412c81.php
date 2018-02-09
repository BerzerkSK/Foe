<?php
// source: D:\Programy\xampp\htdocs\foe\app\presenters/templates/Cech/showall.latte

use Latte\Runtime as LR;

class Templatec08d412c81 extends Latte\Runtime\Template
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
		if (isset($this->params['clen'])) trigger_error('Variable $clen overwritten in foreach on line 9');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
		if ($users) {
?>    <div>
        <h2>Zoznam členov</h2>
        <div>
            <table>
                <tr>
                    <th>Nick</th><th>Éra</th><th>Hvezdaren</th><th>Atomium</th><th>Obluk</th>
                </tr>
<?php
			$iterations = 0;
			foreach ($users as $clen) {
?>                <tr>
                    <td><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("User:edit", [$clen->userid])) ?>"><?php
				echo LR\Filters::escapeHtmlText($clen->nick) /* line 10 */ ?></a></td>
                    <td><?php echo LR\Filters::escapeHtmlText($era[$clen->cech]['nazov']) /* line 11 */ ?></td>
                    <td><?php echo LR\Filters::escapeHtmlText($clen->hvezdaren) /* line 12 */ ?></td>
                    <td><?php echo LR\Filters::escapeHtmlText($clen->atomium) /* line 13 */ ?></td>
                    <td><?php echo LR\Filters::escapeHtmlText($clen->obluk) /* line 14 */ ?></td>
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
		
	}

}
