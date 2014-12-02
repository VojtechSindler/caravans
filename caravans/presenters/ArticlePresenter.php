<?php

namespace Caravans\Presenters;

use Nette,
    Caravans\Model;

/**
 * @author Vladimír Antoš
 * @version 1.0
 */
class ArticlePresenter extends BasePresenter {

    /**
     *
     * @var Model\ArticleManager @inject
     */
    public $article;

    public function renderShowAll($what = "all") {

        switch ($what) {
            case 'all': $articles = $this->article->getAll(null, Model\Language::convertToInt($this->locale));
                break;
            case 'news': $articles = $this->article->getNews(Model\Language::convertToInt($this->locale));
                break;
            case 'articles': $articles = $this->article->getArticles(Model\Language::convertToInt($this->locale));
                break;
            default:
                break;
        }
        $this->template->articles = $articles;
    }

    public function renderView($id, $title) {
        $this->article->id = $id;
        $articles = $this->article->getNewArticles(5, Model\Language::convertToInt($this->locale));
        $this->template->news = $articles;
        $article = $this->article->getAll($id, Model\Language::convertToInt($this->locale));
        if (isset($article[0])) {
            $this->template->article = $article[0];
        }else{
            $this->redirect("Article:showAll");
        }
    }

    public function renderVystavy() {
        $this->template->articles = $this->article->getExhibitions(Model\Language::convertToInt($this->locale));
    }

}
