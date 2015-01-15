<?php

namespace Caravans\BackendModule\Controls;

/**
 * @author Bruno Puzják
 * @package caravans_backend_controls
 */
class ArticlePreviewControl extends \Nette\Application\UI\Control {

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
        $articles = $this->articleManager->getAllAdmin(null, true);
        array_map(function($data){
            $data->kategorie = \Caravans\Model\CategoryTranslator::translate($data->kategorie);
        }, $articles);
        
        $this->template->articles = $articles;
        $httpRequest = $this->presenter->context->getService('httpRequest');
        $view = $httpRequest->getPost("view");
        if ($view == 0)
            $this->template->render(__DIR__ . "/table.latte");
        else{
            $this->template->render(__DIR__ . "/view.latte");
        }
    }

    public function handleEdit($id,$jazyk) {
        $this->presenter->redirect("edit", $id, $jazyk);
    }

    public function handleView($id, $jazyk) {
        $this->presenter->redirect("view", $id, $jazyk);
    }

    public function handleDelete($id, $jazyk) {
        $this->articleManager->delete($id, $jazyk);
        $this->flashMessage("Aktualita byla úspěšně odstraněna", \FlashMessageTypes::OK);
        $this->redirect("this");
    }
}

?>