<?php

namespace App\Presenters;

use Nette;
use App\Model;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    public $hvezdaren_info = [0,3,4,4,5,6,6,7,7,8,8];
    public $atomium_info = [0,6,7,8,9,11,12,13,14,15,17];
    public $obluk_info = [0,9,10,12,13,15,16,18,19,21,22];
    public $ery = null;
    public $users_all = null;
    public $users = null;
    public $users_cech = null;
    public $server = ['Arvahall' => 'Arvahall',
                        'Brisgard' => 'Brisgard',
                        'Cirgard' => 'Cirgard',
                        'Dinegu' => 'Dinegu'];


    public function menuRule() {
        if($this->getUser()->loggedIn) {
            $this->template->users = $this->users = $this->users_all = $this->database->table('user');
            $this->template->ery = $this->ery = $this->database->table('era');
            $this->template->suroviny = $this->database->table('suroviny');
            $this->template->users_cech = $this->users_cech = $this->database->table('user')
										->where('cech LIKE ?', $this->getUser()->getIdentity()->cech)
										->order('era DESC');
            
            $this->template->logged = $this->getUser()->loggedIn;
            $this->template->role = $this->getUser()->getIdentity()->role;
            $this->template->nick = $this->getUser()->getIdentity()->nick;
            $this->template->user_id = $this->getUser()->getIdentity()->userid;
			$this->template->last_login = $this->getUser()->getIdentity()->last_login;

            $this->template->is_role_clen = FALSE;
            $this->template->is_role_admin = FALSE;
            $this->template->is_role_superadmin = FALSE;

            switch ($this->getUser()->getIdentity()->role) {
            case 'clen':
                $this->template->is_role_clen = TRUE;
                break;
            case 'admin':
                $this->template->is_role_admin = TRUE;
                break;
            case 'superadmin':
                $this->template->is_role_superadmin = TRUE;
                break;
            }
            
            // vlozenie udajov o cechu do sablony
            $this->template->cech = $this->database->table('cech')->where('id LIKE ?', $this->getUser()->getIdentity()->cech)->fetch();
            $hvezdaren_obj = $this->database->table('user')->where('cech LIKE ?', $this->getUser()->getIdentity()->cech)->where('hvezdaren > ?',0);
            $atomium_obj = $this->database->table('user')->where('cech LIKE ?', $this->getUser()->getIdentity()->cech)->where('atomium > ?',0);
            $obluk_obj = $this->database->table('user')->where('cech LIKE ?', $this->getUser()->getIdentity()->cech)->where('obluk > ?',0);
            $this->template->hvezdaren_pocet = count($hvezdaren_obj);
            $this->template->atomium_pocet = count($atomium_obj);
            $this->template->obluk_pocet = count($obluk_obj);
            $this->template->pocet_clenov = count($this->template->users_cech);
        }
        else {
            $this->template->logged = FALSE;
            $this->template->role = FALSE;
            $this->template->nick = FALSE;
            $this->template->is_role_clen = FALSE;
            $this->template->is_role_admin = FALSE;
            $this->template->is_role_superadmin = FALSE;
            
            $this->flashMessage('Pre prístup k cechovým informáciám sa prihlás.');
//            $this->redirect('Sign:in');
        }
    }
}
