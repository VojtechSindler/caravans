<?php

namespace Caravans\Presenters;

use Nette,
	Caravans\Model;


/**
 * Homepage presenter.
 * 
 * @author Vladimír Antoš
 * @package caravans_presenters
 */
class HomepagePresenter extends BasePresenter
{

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}

}
