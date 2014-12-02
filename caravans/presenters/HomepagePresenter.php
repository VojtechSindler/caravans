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
class HomepagePresenter extends BasePresenter {

    /**
     *
     * @var Model\ArticleManager @inject
     */
    public $article;

    public function startup() {
        parent::startup();
        $this->setLayout("layout");
    }

    public function renderDefault() {
        $this->article->id=1;
        $articles = $this->article->getNewArticles(3,Model\Language::convertToInt($this->locale));
        $this->template->news = $articles;
    }

}
