<?php
// source: D:\Programy\xampp\htdocs\foe\app\presenters\templates\Cech\spotreba_surovin_CE.latte

use Latte\Runtime as LR;

class Template767de381e6 extends Latte\Runtime\Template
{

	function main()
	{
		extract($this->params);
?>
<div>
    <table class="table table-striped">
        <tr>
            <th>Éra</th>
            <th class="bunka">Suroviny na 2. kolo</th>
            <th class="bunka">Suroviny na 3. kolo</th>
            <th class="bunka">Suroviny na 4. kolo</th>
            <th class="bunka">Suroviny spolu</th>
        </tr>
		
<?php
		$pocet_sur = 0;
?>
		
<?php
		$iterations = 0;
		foreach ($iterator = $this->global->its[] = new LR\CachingIterator($ery) as $era) {
?>	<tr>

            <?php
			$iter = count($ery)-$iterator->counter+1;
?> 
<?php
			if ($iter == 3 || $iter == 4) {
				$pocet_sur = 2;
			}
			if ($iter == 5) {
				$pocet_sur = 3;
			}
			if ($iter == 6 || $iter == 7) {
				$pocet_sur = 4;
			}
			if ($iter > 7 && $iter < 13) {
				$pocet_sur = 5;
			}
			if ($iter > 12) {
				$pocet_sur = 6;
			}
			?>            <td><?php echo LR\Filters::escapeHtmlText($ery[$iter]['nazov']) /* line 31 */ ?></td>
            <td class="bunka"><?php
			if ((array_key_exists($iter, $cechove_VB) && $cechove_VB [$iter]['hraci'] > 0)) {
				?><span><?php echo LR\Filters::escapeHtmlText($cechove_VB [$iter]['hraci'] * $pocet_sur) /* line 32 */ ?> z každej suroviny</span><?php
			}
?>
</td>
            <td class="bunka"><?php
			if ((array_key_exists($iter, $cechove_VB) && $cechove_VB [$iter]['hraci'] > 0)) {
				?><span><?php echo LR\Filters::escapeHtmlText($cechove_VB [$iter]['hraci'] * ($pocet_sur * 2)) /* line 33 */ ?> z každej suroviny</span><?php
			}
?>
</td>
            <td class="bunka"><?php
			if ((array_key_exists($iter, $cechove_VB) && $cechove_VB [$iter]['hraci'] > 0)) {
				?><span><?php echo LR\Filters::escapeHtmlText($cechove_VB [$iter]['hraci'] * ($pocet_sur * 4)) /* line 34 */ ?> z každej suroviny</span><?php
			}
?>
</td>
            <td class="bunka"><?php
			if ((array_key_exists($iter, $cechove_VB) && $cechove_VB [$iter]['hraci'] > 0)) {
				?><span><?php echo LR\Filters::escapeHtmlText($cechove_VB [$iter]['hraci'] * (($pocet_sur)+($pocet_sur * 2)+($pocet_sur * 4))) /* line 35 */ ?> z každej suroviny</span><?php
			}
?>
</td>
        </tr>
<?php
			$iterations++;
		}
		array_pop($this->global->its);
		$iterator = end($this->global->its);
?>
    </table>
</div><?php
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['era'])) trigger_error('Variable $era overwritten in foreach on line 13');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}

}
