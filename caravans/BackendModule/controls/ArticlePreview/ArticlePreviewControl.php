<?php

namespace Caravans\BackendModule\Controls;

use Nette\Application\UI;

/**
 * @author Bruno Puzják
 * @package caravans_backend_controls
 */
class ArticlePreviewControl extends UI\Control {

    /** @var \Caravans\Model\ArticleManager */
    private $articleManager;

    /**
     * @var Nette\Application\Request
     */
    private $request;
    private $isEdit;

    public function __construct(\Caravans\Model\ArticleManager $am, \Nette\Application\Request $r) {
        parent::__construct();
        $this->articleManager = $am;
        $this->request = $r;
    }

    public function render() {
        $articles = $this->articleManager->getArticles();
        $this->template->articles = $articles;
        $httpRequest = $this->presenter->context->getService('httpRequest');
        $view = $httpRequest->getPost("view");
        if ($view == 0)
            $this->template->render(__DIR__ . "/table.latte");
        else
            $this->template->render(__DIR__ . "/view.latte");
    }

    public function handleEdit($id) {
        $this->presenter->redirect("edit", $id);
    }

    public function handleView($id) {
        $this->presenter->redirect("view", $id);
    }

    public function handleDelete($id) {
        $this->articleManager->delete($id);
        $this->flashMessage("Článek byl úspěšně odstraněn", \FlashMessageTypes::OK);
        $this->redirect("this");
    }

}

?>