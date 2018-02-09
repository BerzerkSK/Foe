<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\Passwords;

/**
 * Description of UserPresenter
 *
 * @author Peter
 */

class UserPresenter extends BasePresenter{
    /** @var Nette\Database\Context */
    protected $database;
    
    public function __construct(Nette\Database\Context $database) {
        $this->database = $database;
    }
    
    protected function createComponentCreateForm() {
        
// vyber a priprav data do selectov
        $era_data = $this->database->table('era')->order('id')->fetchPairs('id', 'nazov');
        $cechy_obj = $this->database->table('cech');
        $nicks = $this->database->table('user');

        $user['role'] = $this->getUser()->getIdentity()->role;
        $user['cech'] = $this->getUser()->getIdentity()->cech; // simulacia cechu prihlaseneho hraca

        foreach ($nicks as $row) {
            $nick[] = $row->nick;
        }
        
        $cechy[0] = 'Bez cechu';
        $i = 1;
        foreach ($cechy_obj as $row) {
            if($user['role'] == 'superadmin') { //UPRAVIT PODMIENKU na test superusera -> ak je prihlaseny superuser, napln vsetky ery, inak iba eru prihlaseneho usera
                $cechy[$i] = $row['nazov_cechu'];
            }
            elseif ($i == $user['cech']) {
                $cechy[$user['cech']] = $row['nazov_cechu'];
            }
            $i++;
        }
        
        $form = new Form();
        
        $form->addText('nick', "Meno:")
                ->setRequired("Zadajte prosím meno.")
                ->addRule(Form::IS_NOT_IN, 'Nick už existuje - zadaj iný.', $nick);
        
        $form->addSelect('cech', 'Cech:', $cechy)
                ->setDisabled(FALSE)
                ->setDefaultValue($user['cech']);
        
        $form->addPassword('password', "Heslo:")
                ->setRequired("Zadajte prosím heslo.");

        $form->addPassword('passwordVerify', "Heslo pre kontrolu:")
                ->setOmitted(TRUE)
                ->setRequired("Zadajte prosím heslo pre kontrolu.")
                ->addRule(Form::EQUAL, 'Heslá sa nezhodujú.', $form['password']);
        
        switch ($user['role']) {
            case 'superadmin':
                $pravidla['superadmin'] = 'Superadmin';
            case 'admin':
                $pravidla['admin'] = 'Admin';
            default:
                $pravidla['clen'] = 'Člen';
        }
        
        $form->addRadioList('role', "Práva:", $pravidla);
        
        $form->addSelect('era', 'Éra:', $era_data);
        
        $form->addTextArea('poznamka', 'Poznámka:', 60, 5);
        
        $form->addText('hvezdaren', 'Hvezdáreň:', 1, 2)
                ->setRequired(TRUE)
                ->addRule($form::RANGE, 'Hodnota musí byť v rozsahu od %d do %d.',[0,count($this->hvezdaren_info)]); // ak zmenim max lvl, treba zmenit hodnoty v CechPresenter
        
        $form->addText('atomium', 'Atómium:', 1, 2)
                ->setRequired(TRUE)
                ->addRule($form::RANGE, 'Hodnota musí byť v rozsahu od %d do %d.',[0,count($this->atomium_info)]); // ak zmenim max lvl, treba zmenit hodnoty v CechPresenter
        
        $form->addText('obluk', 'Oblúk:', 1, 2)
                ->setRequired(TRUE)
                ->addRule($form::RANGE, 'Hodnota musí byť v rozsahu od %d do %d.',[0,count($this->obluk_info)]); // ak zmenim max lvl, treba zmenit hodnoty v CechPresenter

        $form->setDefaults(['role' => 'clen', 'era' => 1, 'hvezdaren' => 0,
                            'atomium' => 0, 'obluk' => 0]);
        
        if($user['role'] <> 'clen') {
			$form->addSubmit('sendCreate', 'Uložiť')
				->setAttribute('class', 'btn btn-primary btn-sm active')
				->setAttribute('role', 'button'); 
		}
        $form->onSuccess[] = [$this, 'newUserSucceeded'];
        return $form;
    }
    
    protected function createComponentEditForm() {
        
        $era_data = $this->database->table('era')->order('id')->fetchPairs('id', 'nazov');
        $user_id2 = $this->getParameter('user_id');
        $user_edited = $this->database->table('user')->get($user_id2);
        $cechy_obj = $this->database->table('cech');
        if($this->getUser()->loggedIn) {
            $user['role'] = $this->getUser()->getIdentity()->role;
            $user['cech'] = $this->getUser()->getIdentity()->cech;
        }
        
        $form = new Form;

// vyber a uloz data editovaneho uzivatela
        if (isset($user_edited)) {
            foreach ($user_edited as $key => $value) {
                $user_data[$key] = $value;
            }

        }
        else {
            $this->error('Užívateľ nebol nájdený.');
        }        

        $cechy[0] = 'Bez cechu';
        $i = 1;
        foreach ($cechy_obj as $row) {
            if($user['role'] == 'superadmin') {
                $cechy[$i] = $row['nazov_cechu'];
            }
            elseif ($i == $user['cech']) {
                $cechy[$user['cech']] = $row['nazov_cechu'];
            }
            $i++;
        }

//        $form->setMethod('GET');
        
		
        if($user['role'] !== 'clen') {
			$form->addText('nick', "Meno:")
                ->setRequired(TRUE);
			$form->addSelect('cech', 'Cech:', $cechy)
            	    ->setDefaultValue($user_data['cech']);
		}
		else {
			$form->addText('nick', "Meno:")
				->setDisabled(TRUE)
                ->setRequired(TRUE);
		}

        $form->addPassword('password', "Heslo:")
                ->setRequired(FALSE);

        $form->addPassword('passwordVerify', "Heslo pre kontrolu:")
                ->setOmitted(TRUE)
                ->addRule(Form::EQUAL, 'Heslá sa nezhodujú.', $form['password'])
                ->setRequired(FALSE);
        
        switch ($user['role']) {
            case 'superadmin':
                $pravidla['superadmin'] = 'Superadmin';
            case 'admin':
                $pravidla['admin'] = 'Admin';
            default:
                $pravidla['clen'] = 'Člen';
        }

	if($user['role'] !== 'clen') {
            if($user_data['role'] !== 'superadmin') {
		$form->addRadioList('role', "Práva:", $pravidla);
            }
	}
        
        $form->addSelect('era', 'Éra:', $era_data);
        
        if($user['role'] !== 'clen') {
			$form->addTextArea('poznamka', 'Poznámka:', 70, 5);
		}
        
        $form->addText('hvezdaren', 'Hvezdáreň:', 1, 2)
                ->setRequired(TRUE)
                ->addRule($form::RANGE, 'Hodnota musí byť v rozsahu od %d do %d.',[0,count($this->hvezdaren_info)]); // ak zmenim max lvl, treba zmenit hodnoty v CechPresenter
        
        $form->addText('atomium', 'Atómium:', 1, 2)
                ->setRequired(TRUE)
                ->addRule($form::RANGE, 'Hodnota musí byť v rozsahu od %d do %d.',[0,count($this->atomium_info)]); // ak zmenim max lvl, treba zmenit hodnoty v CechPresenter
        
        $form->addText('obluk', 'Oblúk:', 1, 2)
                ->setRequired(TRUE)
                ->addRule($form::RANGE, 'Hodnota musí byť v rozsahu od %d do %d.',[0,count($this->obluk_info)]); // ak zmenim max lvl, treba zmenit hodnoty v CechPresenter

        if($user_data['role'] == 'superadmin') { $user_data['role'] = 'clen'; }
        $form->setDefaults(['role' => $user_data['role'],
                                'era' => $user_data['era'],
                                'hvezdaren' => $user_data['hvezdaren'],
                                'atomium' => $user_data['atomium'],
                                'obluk' => $user_data['obluk'],
                                'nick' => $user_data['nick'],
                                'poznamka' => $user_data['poznamka']]);
        
        $form->addSubmit('sendEdit', 'Uložiť')
			->setAttribute('class', 'btn btn-primary btn-sm active')
			->setAttribute('role', 'button');
        $form->onSuccess[] = [$this, 'editUserSucceeded'];

        return $form;
    }
    
    public function newUserSucceeded(Nette\Application\UI\Form $form, $values){

        if (!$this->getUser()->isLoggedIn()) {
            $this->error('Pre editovanie sa musíte prihlásiť.');
        }
        $values['password'] = Passwords::hash($values['password']);

        $user = $this->database->table('user')->insert($values);
        $this->flashMessage('Nový užívateľ bol pridaný.');
        $this->redirect('this');
    }
    
    public function editUserSucceeded(Nette\Application\UI\Form $form, $values){

        if (!$this->getUser()->isLoggedIn()) {
            $this->error('Pre editovanie sa musíte prihlásiť');
        }
        if(strlen($values['password']) > 0) {
            $values['password'] = Passwords::hash($values['password']);
        }
        else {
            unset($values['password']);
        }

        $data = $this->database->table('user')->get($this->getParameter('user_id'));
        $data->update($values);
        $this->flashMessage('Údaje boli upravené.');
        $this->redirect('Cech:showAll');
    }
        
    public function renderCreate($user_id = NULL) {
        BasePresenter::menuRule();
    }
    
    public function actionCreate() {
        if(!$this->getUser()->loggedIn) {
            $this->flashMessage('Pre pridávanie členov do cechu sa musíš prihlásiť.');
            $this->redirect('Sign:in');
        }
        elseif($this->getUser()->getIdentity()->role == 'clen') {
            $this->flashMessage('Nemáš dostatočné práva na pridávanie nových členov do cechu.');
            $this->redirect('Cech:showAll');
        }
    }
        
    public function renderEdit($user_id = NULL) {
        
    }
    
    public function actionEdit($user_id = NULL) {
        BasePresenter::menuRule();
        $user_edited = $this->database->table('user')->get($user_id);

        if($this->getUser()->loggedIn) {
            $user['role'] = $this->getUser()->getIdentity()->role;
            $user['cech'] = $this->getUser()->getIdentity()->cech;

            if($user['role'] == 'admin' && $user_edited['role'] == 'superadmin') {
                $this->flashMessage('S aktuálnymi oprávneniami nemôžeš zvoleného užívateľa upravovať.');
                $this->redirect('Homepage:');
            }
            if($user['role'] == 'clen' && $user_id <> $this->getUser()->getIdentity()->userid){
                $this->flashMessage('S aktuálnymi oprávneniami nemôžeš upravovať členov.');
                $this->redirect('Cech:showAll');
            }
        }
        else {
            $this->flashMessage('Pre úpravu členov sa prosím prihlás.');
            $this->redirect('Sign:in');
        }
    }
}

