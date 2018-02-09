<?php
// source: D:\Programy\xampp\htdocs\foe\app\presenters/templates/Prispevok/showall.latte

use Latte\Runtime as LR;

class Templateaec7063611 extends Latte\Runtime\Template
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
		if (isset($this->params['prispevok'])) trigger_error('Variable $prispevok overwritten in foreach on line 2');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
		$iterations = 0;
		foreach ($prispevky as $prispevok) {
?>    <div>
        <p><?php echo LR\Filters::escapeHtmlText($prispevok['bodyVB']) /* line 3 */ ?></p>
        <p><?php echo LR\Filters::escapeHtmlText($prispevok['CE']) /* line 4 */ ?></p>        
    </div>
<?php
			$iterations++;
		}
?>

<?php
	}

}
