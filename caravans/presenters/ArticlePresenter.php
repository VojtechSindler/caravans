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

    public function renderShowAll($what="all") {
        switch ($what) {
            case 'all': $this->template->articles = $this->article->getAll();
                break;
            case 'news': $this->template->articles = $this->article->getNews();
                break;
            case 'articles': $this->template->articles = $this->article->getArticles();
                break;
            default:
                break;
        }
       
        $this->template->footerText = 'Doporučujeme:';
    }

    public function renderView($id) {
        $articles=$this->article->getAll($id);
        $this->template->article=$articles[0];
        
       $this->template->footerText='<span style="float:left;margin-left:10px;">Publikováno: '.$articles[0]['datum'].'</span><font style="float:right;margin-right:10px">'.$articles[0]['jmeno'].' '.$articles[0]['prijmeni'].'</font><br>';
    }

}
