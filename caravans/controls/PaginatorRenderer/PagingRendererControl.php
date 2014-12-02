<?php

namespace Caravans\Controls;

use Nette\Application\UI;
use Nette\Utils\Paginator;

class PagingRendererControl extends UI\Control{
        const Normal = "";
        const Large = "pagination-large";
        const Small = "pagination-mini";
        const Center = "pagination-centered";
        const Right = "pagination-right";
    
    	/** @var Nette\Utils\Paginator */
	private $paginator;

	/** @persistent */
	public $page = 1;

        private $boxStyle = self::Center;

        public function setPagingBoxStyle($style){
           $this->boxStyle = $style;
           return $this;
        }
        
        /**
	 * @return Nette\Utils\Paginator
	 */
	public function getPaginator()
	{
		if (!$this->paginator) {
			$this->paginator = new Paginator;
		}

		return $this->paginator;
	}


	/**
	 * Renders paginator.
	 * @param array $page
	 * @return void
	 */
	public function render($page = NULL)
	{
		$paginator = $this->getPaginator();

		if (NULL !== $page) {
			$paginator->setItemCount($page['count']);
			$paginator->setItemsPerPage($page['pageSize']);
		}

		$page = $paginator->page;

		if ($paginator->pageCount < 2) {
			$steps = array($page);

		} else {
			$arr = range(max($paginator->firstPage, $page - 3), min($paginator->lastPage, $page + 3));
			$count = 4;
			$quotient = ($paginator->pageCount - 1) / $count;
			for ($i = 0; $i <= $count; $i++) {
				$arr[] = round($quotient * $i) + $paginator->firstPage;
			}
			sort($arr);
			$steps = array_values(array_unique($arr));
		}

		$this->template->steps = $steps;
		$this->template->paginator = $paginator;
                $this->template->boxStyle = $this->boxStyle;
                        $this->template->length = $this->paginator->length;
        $this->template->offset = $this->paginator->offset;
        $this->template->count = $this->paginator->ItemCount;
		$this->template->setFile(__DIR__ . '/pagingrenderer.latte');
		$this->template->render();
	}


	/**
	 * Loads state informations.
	 * @param  array
	 * @return void
	 */
	public function loadState(array $params)
	{
		parent::loadState($params);
		$this->getPaginator()->page = $this->page;
	}
}
