<?php
// source: D:\Programy\xampp\htdocs\foe\app\presenters/templates/@layout.latte

use Latte\Runtime as LR;

class Templatec4f57b128e extends Latte\Runtime\Template
{
	public $blocks = [
		'head' => 'blockHead',
		'scripts' => 'blockScripts',
	];

	public $blockTypes = [
		'head' => 'html',
		'scripts' => 'html',
	];


	function main()
	{
		extract($this->params);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

	<title><?php
		if (isset($this->blockQueue["title"])) {
			$this->renderBlock('title', $this->params, function ($s, $type) {
				$_fi = new LR\FilterInfo($type);
				return LR\Filters::convertTo($_fi, 'html', $this->filters->filterContent('striphtml', $_fi, $s));
			});
			?> | <?php
		}
?>Forge of empires - cech</title>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 13 */ ?>/3rd/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 14 */ ?>/css/style.css">
	<?php
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('head', get_defined_vars());
?>
</head>

<body>

	<div id="banner">
            <h1>Forge of empires - cech</h1>
        </div>
        
        <div id="content">
            <div id="menu">

                    <div class="menu_box_right">
<?php
		if (!$logged) {
			?>                        <a class="btn btn-primary btn-sm active" role="button" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Sign:in")) ?>">Prihlásenie</a>
<?php
		}
?>
                        
<?php
		if ($logged) {
			?>                        <a style = "align: left" class="btn btn-primary btn-sm active" role="button" href="<?php
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Homepage:")) ?>">Prehľad cechu</a>
<?php
		}
		if ($logged) {
			?>                        <a style = "align: left" class="btn btn-primary btn-sm active" role="button" href="<?php
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Cech:showAll", [501])) ?>">Návody</a>
<?php
		}
		if ($nick) {
			?>                        <span style = "align: right"><strong>Prihlásený:</strong> <?php echo LR\Filters::escapeHtmlText($nick) /* line 32 */ ?> <?php
			if ($logged) {
				?><a class="btn btn-primary btn-sm active" role="button" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Sign:out")) ?>">Odhlásiť</a><?php
			}
?>
</span>
<?php
		}
?>
                    </div>
 
            </div>
<?php
		$iterations = 0;
		foreach ($flashes as $flash) {
			?>            <div<?php if ($_tmp = array_filter(['flash', $flash->type])) echo ' class="', LR\Filters::escapeHtmlAttr(implode(" ", array_unique($_tmp))), '"' ?>><?php
			echo LR\Filters::escapeHtmlText($flash->message) /* line 36 */ ?></div>
<?php
			$iterations++;
		}
		$this->renderBlock('content', $this->params, 'html');
?>
        </div>

<?php
		$this->renderBlock('scripts', get_defined_vars());
?>
</body>
</html>

<style>
    .menu_box_left {
        display: block;
		padding: 9.5px;
		margin: 0 0 10px;
		font-size: 13px;
		line-height: 1.42857143;
		color: #333;
		word-break: break-all;
		word-wrap: break-word;
		background-color: #f5f5f5;
		border: 1px solid #ccc;
		border-radius: 4px;
        text-align: left;
    }
	
	.menu_box_right {
        display: block;
		padding: 9.5px;
		margin: 0 0 10px;
		font-size: 13px;
		line-height: 1.42857143;
		color: #333;
		word-break: break-all;
		word-wrap: break-word;
		background-color: #f5f5f5;
		border: 1px solid #ccc;
		border-radius: 4px;
        text-align: right;
    }
	
	.foe_radius {
		display: block;
		padding: 9.5px;
		margin: 0px;
		font-size: 13px;
		line-height: 1.42857143;
		word-break: break-all;
		word-wrap: break-word;
		border: 1px solid #ccc;
		border-radius: 4px;
	}
	
	.bunka {
        text-align: center;
    }

</style><?php
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['flash'])) trigger_error('Variable $flash overwritten in foreach on line 36');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockHead($_args)
	{
		
	}


	function blockScripts($_args)
	{
		extract($_args);
?>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="https://nette.github.io/resources/js/netteForms.min.js"></script>
	<script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 43 */ ?>/js/main.js"></script>
	<script src="<?php echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 44 */ ?>/3rd/bootstrap/js/bootstrap.js"></script>
<?php
	}

}
