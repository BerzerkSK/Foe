<?php
namespace App\Presenters;

use Nette;
use Nette\Database\Context;
use Nette\Security\User;
use Nette\Application\UI\Form;

/**
 * Description of PrispevokPresenter
 *
 * @author Peter
 */
class PrispevokPresenter extends BasePresenter{
    protected $database;
    protected $id = null;
    protected $week = null;
    protected $year = null;
    protected $exist_prispevky = null;
    protected $exist_prispevky2 = null;
    protected $termin2 = null;

    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;
    }
    
    public function createComponentHromadnyPrispevokForm() {

        if($this->termin2 === null) {
            $rok = strftime('%Y', Time());
            $tyzden = strftime('%W', Time());
        }
        else {
            $tyzden = substr($this->termin2,0,2);
            $rok = substr($this->termin2,3,4);
        }
        
        for($i=2017; $i<=strftime('%Y', Time()); $i++) {
            $year[] = $i;
        }
        
        for($f=1; $f<53; $f++) {
            if($f < 10) {
                $ff = '0'.$f;
            }
            else {
                $ff = $f;
            }
            $week[] = $ff;
        }

	$form = new Form();
        
        $this->week = $week;
        $this->year = $year;
        
        $form->addSelect('termin', 'Týždeň:', $this->week)
				->setItems($week, FALSE)
                                ->setAttribute('onchange', 'submit()');
        $form->addSelect('rok', 'Rok:', $this->year)
				->setItems($year, FALSE)
                                ->setAttribute('onchange', 'submit()');
		
        $in_array = array_search($tyzden, $week);
        $in_array2 = array_search($rok, $year);
		
        if($in_array !== FALSE) {
            $form->setDefaults(['termin' => $tyzden]);
	}

        if($in_array2 !== FALSE) {
            $form->setDefaults(['rok' => $rok]);
	}
        
        $form->addSubmit('sendHromadnyPrispevok', 'Uložiť')
			->setAttribute('class', 'btn btn-primary btn-sm active')
			->setAttribute('role', 'button');
        $form->onSuccess[] = [$this, 'hromadnyPrispevokSucceeded'];
        
        return $form;
    }
    
    public function hromadnyPrispevokSucceeded(Nette\Application\UI\Form $form, $values) {

        $dataCE = $form->getHttpData($form::DATA_LINE, 'dataCE[]');
        $dataVB = $form->getHttpData($form::DATA_LINE, 'dataVB[]');
        $this->template->termin = $termin = $values['termin'].'/'.$values['rok'];
   
        $obj_exist_prispevky = $this->database->table('prispevky')
                    ->where('cech LIKE ?', $this->getUser()->getIdentity()->cech)
                    ->where('termin LIKE ?', $termin)
                    ->fetchAll();
        if($obj_exist_prispevky === NULL) { $this->exist_prispevky = NULL; }

        foreach ($obj_exist_prispevky as $key => $prispevky) {
            $this->exist_prispevky[$key]['id'] = $prispevky['id'];
            $this->exist_prispevky[$key]['user_id'] = $prispevky['user_id'];
            $this->exist_prispevky[$key]['termin'] = $prispevky['termin'];
            $this->exist_prispevky[$key]['cech'] = $prispevky['cech'];
            $this->exist_prispevky[$key]['bodyVB'] = $prispevky['bodyVB'];
            $this->exist_prispevky[$key]['CE'] = $prispevky['CE'];
            $this->exist_prispevky[$key]['suroviny'] = $prispevky['suroviny'];
            $data1[$key] = $prispevky['user_id'];
        }

        $this->template->exist_prispevky = $this->exist_prispevky;

        //priprava dat pre INSERT a UPDATE
        $insert = NULL; $i=0;
        foreach ($this->users_cech as $user) {
            if(!isset($data1)) {
                $data1 = [];
            }
            if(!array_search($user->userid, $data1) == FALSE) {
                $upgrade[array_search($user->userid, $data1)] = 
                        ['CE' => $dataCE[$i],
                         'bodyVB' => $dataVB[$i]
                        ];
            }
            else {
                $insert[] = ['cech' => $user->cech,
                             'user_id' => $user->userid,
                             'termin' => $termin,
                             'CE' => $dataCE[$i],
                             'bodyVB' => $dataVB[$i],
                             'suroviny' => '0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0'
                             ];
            }
            $i++;
        }
        
        if($this->termin2 <> $termin) {
            $this->redirect('Prispevok:hromadnyPrispevok', $termin);
        }
        else {
            //vlozenie do DB inserty aj updaty - ak existuju
        if(isset($insert)) {
            $this->database->table('prispevky')->insert($insert);
        }
        if(isset($upgrade)) {
            foreach ($upgrade as $key => $value) {
                $this->database->table('prispevky')->where('id LIKE ?', $key)->update($upgrade[$key]);
            }
        }
        $this->flashMessage('Hromadný príspevok bol uložený.');
        $this->redirect('Cech:showAll');
        }
    }
     
    public function createComponentAddPrispevokForm($id) {
        $tyzden_obj = $this->database->table('prispevky')
                ->where('user_id LIKE ?', $this->getParam('id'))
                ->where('cech LIKE ?', $this->getUser()->getIdentity()->cech)
                ->order('termin');
        
        //vyhodi z dat tyzdne, ktore uz ma evidovane - format je MM/RRRR, kde MM je mesiac a RRRR je rok
        $rok = strftime('%Y', Time());
	$tyzden = strftime('%W', Time());
        
        for($f=1; $f<53; $f++) {
            if($f < 10) {
                $ff = '0'.$f;
            }
            else {
                $ff = $f;
            }
            $week[] = $ff.'/'.$rok;
        }

	foreach ($tyzden_obj as $row) {
            for($f = 1; $f < count($week); $f++) {
		if($week[$f-1] == $row['termin']) {
                    array_splice($week, $f-1, 1);
                }
            }
        }
		
	$form = new Form();

        $this->week = $week;
        
        $form->addSelect('termin', 'Týždeň:', $this->week)
				->setItems($week, FALSE);
		
        $in_array = array_search($tyzden.'/'.$rok, $week);
		
        if($in_array !== FALSE) {
			$form->setDefaults(['termin' => $tyzden.'/'.$rok]);
		}
		
        $form->addText('bodyVB', 'Príspevok do VB: ')
                ->setRequired()
				->setAttribute('style', "width: 50px")
                ->addRule(Form::INTEGER, 'Zadaj celé číslo')
                ->setDefaultValue(0);
        
        $form->addText('CE', 'CE - vyhraté zrážky: ')
                ->setRequired()
                ->setAttribute('style', "width: 50px")
                ->addRule(Form::INTEGER, 'Zadaj celé číslo')
                ->addRule(Form::RANGE, 'Zadaj číslo v rozsahu 0 až 64',[0,64])
                ->setDefaultValue(0);
        
        $form->addSubmit('sendAddPrispevok', 'Uložiť')
			->setAttribute('class', 'btn btn-primary btn-sm active')
			->setAttribute('role', 'button');
        $form->onSuccess[] = [$this, 'addPrispevokSucceeded'];
        
        return $form;
    }
    
    public function addPrispevokSucceeded(Nette\Application\UI\Form $form, $values) {
        $values_sur = $form->getHttpData($form::DATA_LINE, 'sur[]');
        foreach ($values_sur as $key => $value) {
            if ($value == "") { $values_sur[$key] = 0; }
        }
        $values['suroviny'] = implode(',', $values_sur);
        $values['user_id'] = $this->id;
        $values['cech'] = $this->getUser()->getIdentity()->cech;
        
        //ulozenie prispevku do DB
        $user = $this->database->table('prispevky')->insert($values);
        
        $this->flashMessage('Nový záznam o príspevokoch bol pridaný.');
        $this->redirect('Prispevok:vypisVsetko', $this->id);
    }
    
    public function createComponentEditPrispevokForm() {
        $id = $this->getParam('id');
        
        $prispevok = $this->database->table('prispevky')
                ->where('id LIKE ?', $id)
                ->fetchAll();
        
        $this->template->prispevok_sur = explode(',', $prispevok[$id]['suroviny']);

        $form = new Form();
        
        $form->addText('termin', 'Týždeň:')
                ->setDisabled(TRUE)
                ->setDefaultValue($prispevok[$id]['termin']);
        
        $form->addText('bodyVB', 'Príspevok do VB: ')
                ->setRequired()
                ->setAttribute('style', "width: 50px")
                ->addRule(Form::INTEGER, 'Zadaj celé číslo')
                ->setDefaultValue($prispevok[$id]['bodyVB']);
        
        $form->addText('CE', 'CE - vyhraté zrážky: ')
                ->setRequired()
                ->setAttribute('style', "width: 50px")
                ->addRule(Form::INTEGER, 'Zadaj celé číslo')
                ->addRule(Form::RANGE, 'Zadaj číslo v rozsahu 0 až 64',[0,64])
                ->setDefaultValue($prispevok[$id]['CE']);
        
        $form->addSubmit('sendEditPrispevok', 'Uložiť')
			->setAttribute('class', 'btn btn-primary btn-sm active')
			->setAttribute('role', 'button');
        $form->onSuccess[] = [$this, 'editPrispevokSucceeded'];
        
        return $form;
    }
    
    public function editPrispevokSucceeded(Nette\Application\UI\Form $form, $values) {
        $values_sur = $form->getHttpData($form::DATA_LINE, 'sur[]');
        foreach ($values_sur as $key => $value) {
            if ($value == "") { $values_sur[$key] = 0; }
        }
        $values['suroviny'] = implode(',', $values_sur);
        
        //ulozenie prispevku do DB
        $data = $this->database->table('prispevky')->get($this->template->id);
        $data->update($values);
         
        $this->flashMessage('Príspevok bol upravený.');
        $this->redirect('Prispevok:vypisVsetko', $this->id);
    }
    
    public function actionEditPrispevok($id, $id_user) {
        BasePresenter::menuRule();
        //testovanie podhodenia editacie prispevku ineho clena, ak je FALSE, bol podhodeny prispevok ineho clena
        $clen_prispevok_test = $this->database->table('prispevky')
                                                    ->where('id LIKE ?', $id)
                                                    ->where('user_id LIKE ?', $id_user)
                                                    ->where('cech LIKE ?', $this->getUser()->getIdentity()->cech)
                                                    ->fetch();

        if($this->logged){
            if(($this->is_role_clen && $id_user == $this->user_id) || !$clen_prispevok_test) {
                // pre zapnutie editacie prispevkov clenom odstranit tento if
		$this->flashMessage('S aktuálnymi oprávneniami nemôžeš upravovať príspevky iných členov.');
                $this->redirect('Prispevok:vypisVsetko', $this->getUser()->getIdentity()->userid);
            }
            elseif(($this->is_role_clen && $id_user <> $this->user_id) || !$clen_prispevok_test) {
                $this->flashMessage('S aktuálnymi oprávneniami nemôžeš upravovať príspevky iných členov.');
                $this->redirect('Prispevok:vypisVsetko', $this->user_id);
            }
            else {
                $this->template->id = $id;
                $this->id = $this->template->id_user = $id_user;

                $prispevok = $this->database->table('prispevky')
                    ->where('id LIKE ?', $id)
                    ->fetchAll();
                $this->template->prispevok_sur = explode(',', $prispevok[$id]['suroviny']);
            }
        }
        else {
            $this->flashMessage('Pre prístup k cechovým informáciám sa prihlás.');
            $this->redirect('Sign:in');
        }
    }
    
    public function renderEditPrispevok($id, $id_user) {
        BasePresenter::menuRule();
        $ery_obj = $this->ery;
        $suroviny_obj = $this->suroviny;

        foreach ($ery_obj as $row) {
            $ery[$row['id']] = $row['nazov'];
        }
        // otocenie nazvov er od najnovsej po najstarsiu
        $ery = array_reverse($ery, TRUE);
        
        foreach ($suroviny_obj as $row) {
            $suroviny[$row['id']]['era'] = $row['era'];
            $suroviny[$row['id']]['nazov'] = $row['nazov'];
        }
        
        for($f = 1; $f < count($ery); $f++) {
            for($i = 1; $i <= count($suroviny); $i++) {
                if($suroviny[$i]['era'] == $f) {
                    $surovina[$f][] = $suroviny[$i]['nazov'];
                }
            }
        }

        $this->template->suroviny = $surovina;
        $this->template->ery = $ery;
        $this->template->user_edited = $this->database->table('user')->where('userid LIKE ?', $id_user);
    }
    
    public function actionAddPrispevok($id) {
        BasePresenter::menuRule();
        if($this->logged){
            $this->id = $this->template->id = $id;
        }
        else {
            $this->flashMessage('Pre prístup k cechovým informáciám sa prihlás.');
            $this->redirect('Sign:in');
        }
    }
    
    public function renderAddPrispevok($id) {
        BasePresenter::menuRule();
        
        $ery_obj = $this->ery;
        $suroviny_obj = $this->suroviny;

        foreach ($ery_obj as $row) {
            $ery[$row['id']] = $row['nazov'];
        }
        // otocenie nazvov er od najnovsej po najstarsiu
        $ery = array_reverse($ery, TRUE);
        
        foreach ($suroviny_obj as $row) {
            $suroviny[$row['id']]['era'] = $row['era'];
            $suroviny[$row['id']]['nazov'] = $row['nazov'];
        }
        
        for($f = 1; $f < count($ery); $f++) {
            for($i = 1; $i <= count($suroviny); $i++) {
                if($suroviny[$i]['era'] == $f) {
                    $surovina[$f][] = $suroviny[$i]['nazov'];
                }
            }
        }

        $this->template->suroviny = $surovina;
        $this->template->ery = $ery;
	$this->template->user_edited = $this->database->table('user')->where('userid LIKE ?', $id);
    }
    
    public function actionHromadnyPrispevok($termin = null) {
        BasePresenter::menuRule();
        if($termin === null) {
            $termin = strftime('%W', Time()).'/'.strftime('%Y', Time());
        }
        $this->template->termin = $this->termin2 = $termin;
        
        if($this->logged){
            $obj_exist_prispevky = $this->database->table('prispevky')
                    ->where('cech LIKE ?', $this->getUser()->getIdentity()->cech)
                    ->where('termin LIKE ?', $termin)
                    ->fetchAll();
            if($obj_exist_prispevky === NULL) { $this->exist_prispevky = NULL; }

            foreach ($obj_exist_prispevky as $key => $prispevky) {
                $this->exist_prispevky[$key] = ['id' => $prispevky['id'],
                                                'user_id' => $prispevky['user_id'],
                                                'termin' => $prispevky['termin'],
                                                'cech' => $prispevky['cech'],
                                                'bodyVB' => $prispevky['bodyVB'],
                                                'CE' => $prispevky['CE'],
                                                'suroviny' => $prispevky['suroviny']];
                
                $this->exist_prispevky2[$prispevky['user_id']] = ['bodyVB' => strval($prispevky['bodyVB']),
                                                                  'CE' => strval($prispevky['CE'])];
            }

            foreach ($this->users_cech as $user) {
                if(!isset($this->exist_prispevky2[$user->userid])) {
                    $this->exist_prispevky2[$user->userid] = ['bodyVB' => 0, 'CE' => 0];
                }
            }
            
            $this->template->exist_prispevky = $this->exist_prispevky;
            $this->template->exist_prispevky2 = $this->exist_prispevky2;
        }
        else {
            $this->flashMessage('Pre prístup k cechovým informáciám sa prihlás.');
            $this->redirect('Sign:in');
        }
    }
    
    public function renderHromadnyPrispevok($termin = null) {
        BasePresenter::menuRule();
    }
    
    public function actionVypisVsetko($id) {
        BasePresenter::menuRule();
// ak treba spustit prehlad prispevkov pre clenov, odstranit z podmienky vsetko za && vratane
	if($this->logged && !$this->is_role_clen){
            $this->id = $this->template->id = $id;
        }
        else {
            $this->flashMessage('Pre prístup k cechovým informáciám nemáš dostatočné práva.');
            $this->redirect('Cech:showAll');
        }
        
        // vlozi do sablony nick editovaneho clena
        $this->template->user_edited = $this->database->table('user')->where('userid LIKE ?', $id);
        $this->template->id_user = $id;
    }
    
    public function renderVypisVsetko($id) {
        
        $prispevky = $this->database->table('prispevky')
                ->where('user_id LIKE ?', $id)
                ->where('cech LIKE ?', $this->getUser()->getIdentity()->cech)
                ->order('termin')
		->fetchAll();
        
        $this->id = $id; // v $this->id je id usera, ktoreho prispevok sa edituje
		
//      zoradenie prispevkov podla terminu - najnovsi navrchu
		foreach($prispevky as $prispevok) {
			$Week = substr($prispevok['termin'],0,2);
			$Year = substr($prispevok['termin'],3,4);
			$iterator = $Year.$Week;
			$data[$iterator] = $prispevok;
		}
		ksort($data);
		$data = array_reverse($data);
//		koniec zoradovania prispevkov
		
		$prispevky = $data;

		$this->template->prispevky = $prispevky;

        foreach ($prispevky as $prispevok) {
            $prispevok_suroviny = explode(',', $prispevok['suroviny']);
            $prispevok_sum[] = array_sum($prispevok_suroviny);
        }
        
        if(isset($prispevok_sum)) {
            $this->template->prispevok_sum = $prispevok_sum;
        }
        else {
            $this->flashMessage('Nenašli sa žiadne príspevky ...');
        }
    }
}
