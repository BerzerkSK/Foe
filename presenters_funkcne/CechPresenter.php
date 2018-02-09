<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Presenters;

use Nette;
use Nette\Database\Context;
use Nette\Application\UI\Form;

/**
 * Description of CechPresenter
 *
 * @author Peter
 */
class CechPresenter extends BasePresenter{
    protected $database;
    
    public function __construct(\Nette\Database\Context $database) {
        $this->database = $database;
    }
    
    public function createComponentEditCechForm() {
        $data_cech = $this->template->data_cech = $this->database->table('cech')
                                                    ->where('id LIKE ?', $this->getUser()->getIdentity()->cech)
                                                    ->fetch();
        
        $form = new Form();
        
        $form->addText('nazov_cechu', 'Názov cechu: ')
                ->setAttribute('class', 'form-control')
				->setRequired(TRUE);
        
        $form->addRadioList('server', 'Server: ', $this->server)
                ->getSeparatorPrototype();
        
        $form->addText('uroven', 'Úroveň cechu: ')
                ->setAttribute('class', 'form-control')
				->setRequired(TRUE)
                ->addRule(Form::INTEGER, 'Vležte číselnú hodnotu.');
        
        $form->addTextArea('info', 'Informačná tabuľa: ', 60, 5)
				->setAttribute('class', 'form-control');
        
        $form->addTextArea('poznamka', 'Poznámka: ', 60, 5)
				->setAttribute('class', 'form-control');
        
        $form->setDefaults(['nazov_cechu' => $data_cech['nazov_cechu'],
                            'uroven' => $data_cech['uroven'],
                            'server' => $data_cech['server'],
                            'poznamka' => $data_cech['poznamka'],
                            'info' => $data_cech['info']]);
        
        $form->addSubmit('sendEditCech', 'Uložiť')
			->setAttribute('class', 'btn btn-primary btn-sm active')
			->setAttribute('role', 'button');
        $form->onSuccess[] = [$this, 'editCechSucceeded'];
        return $form;
    }
    
    public function editCechSucceeded(Nette\Application\UI\Form $form, $values) {
        $data = $this->database->table('cech')
                        ->where('id LIKE ?', $this->getUser()->getIdentity()->cech);
        $data->update($values);
        
        $this->flashMessage('Cechové údaje boli upravené.');
        $this->redirect('Cech:showAll');
    }
    
    public function actionEditCech() {
        if($this->getUser()->loggedIn && !($this->getUser()->getIdentity()->role == 'clen')){
            BasePresenter::menuRule();
        }
        else {
            $this->flashMessage('Pre zmenu cechových údajov nemaš dostatočné práva.');
            $this->redirect('Cech:showAll');
        }
    }
    
    public function renderEditCech() {
        
    }
    
    public function createComponentBaseLawForm() {
        BasePresenter::menuRule();
        $rok = strftime('%Y', Time());
	$tyzden = strftime('%W', Time());
        $termin = $this->template->termin;
        $data = "";
        for($i = 1; $i < 54; $i++) {
            $data[$i] = $i.'/'.$rok;
        }
        
        $form = new Form();
        
        $form->addSelect('termin', 'Týždeň:')
                ->setItems($data, FALSE)
                ->setAttribute('onchange', 'submit()')
                ->setDefaultValue($termin);
        
        $form->onSuccess[] = [$this, 'baseLawFormSucceeded'];
        return $form;
    }
    
    public function baseLawFormSucceeded(Nette\Application\UI\Form $form, $values) {
        $this->redirect('Cech:showAll', 2, $values->termin);
    }
    
    public function actionShowAll($TAB = 0, $termin = null, $login_now = null) {
		BasePresenter::menuRule();

		if($login_now !== null) {
			$data = $this->database->table('user')->get($this->getUser()->getIdentity()->userid);
			$values['userid'] = $this->getUser()->getIdentity()->userid;
			$values['last_login'] = Time();
//			dump($values);
        	$data->update($values);
		}
		
		if(!$termin) {
            $rok = strftime('%Y', Time());
            $tyzden = strftime('%W', Time());
//$tyzden--;
            $this->template->termin = $termin = $tyzden.'/'.$rok;
        }
        else {
            $this->template->termin = $termin;
        }
	
	$data_obj = $this->database->table('prispevky')
                                        ->where('cech LIKE ?', $this->getUser()->getIdentity()->cech)
                                        ->where('termin LIKE ?', $termin);
	$data = array();
	$CE_spolu = 0;
	foreach($data_obj as $row) {
            if(!array_key_exists($row->user_id, $data)) {
                $data[$row->user_id]['bodyVB'] = $row->bodyVB;
                $data[$row->user_id]['CE'] = $row->CE;
                $sur_spolu = explode(",", $row->suroviny);
                $sur_spolu = array_sum($sur_spolu);
                $data[$row->user_id]['suroviny'] = $sur_spolu;
            }
            else {
                $data[$row->user_id]['bodyVB'] = $data[$row->user_id]['bodyVB'] + $row->bodyVB;
                $data[$row->user_id]['CE'] = $data[$row->user_id]['CE'] + $row->CE;
                $sur_spolu = explode(",", $row->suroviny);
                $sur_spolu = array_sum($sur_spolu);
                $data[$row->user_id]['suroviny'] = $data[$row->user_id]['suroviny'] + $sur_spolu;
            }
            $CE_spolu = $CE_spolu + $row->CE;
	}
	
        // spocitaj cechove VB a pocet hracov pre kazdu eru

        foreach ($this->ery as $era) {
            $cechove_VB[$era->id]['hvezdaren'] = 0;
            $cechove_VB[$era->id]['atomium'] = 0;
            $cechove_VB[$era->id]['obluk'] = 0;
            $cechove_VB[$era->id]['hraci'] = 0;
        }
        foreach ($this->users_cech as $clen) {
            if($clen->hvezdaren > 0) {
                $cechove_VB [$clen->era]['hvezdaren'] = $cechove_VB [$clen->era]['hvezdaren'] + 1;
            }
            if($clen->atomium > 0) {
                $cechove_VB [$clen->era]['atomium'] = $cechove_VB [$clen->era]['atomium'] + 1;;
            }
            if($clen->obluk > 0) {
                $cechove_VB [$clen->era]['obluk'] = $cechove_VB [$clen->era]['obluk'] + 1;;
            }
            $cechove_VB [$clen->era]['hraci'] = $cechove_VB [$clen->era]['hraci'] + 1;;
        }
        
        $this->template->data = $data;
        $this->template->cechove_VB = $cechove_VB;
        $this->template->CE_spolu = round($CE_spolu/(($this->template->pocet_clenov*48)/100), 2);
    }
    
    public function renderShowAll($TAB = 0) {
        $this->template->TAB = $TAB;
        if($this->getUser()->loggedIn) {
            $this->template->hvezdaren_info = $this->hvezdaren_info;
            $this->template->atomium_info = $this->atomium_info;
            $this->template->obluk_info = $this->obluk_info;
        } 
        else {
            $this->flashMessage('Pre prístup k cechovým informáciám sa prihlás.');
            $this->redirect('Sign:in');
        }
    }
}
