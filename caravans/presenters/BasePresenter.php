<?php

namespace Caravans\Presenters;

use Nette,
    Caravans\Model;

/**
 * Společný předek všech presenterů v aplikaci.
 * 
 * @author Vladimír Antoš
 * @package caravans_presenters
 * @abstract
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter {

    /** @persistent */
    public $locale;

    /** @var \Kdyby\Translation\Translator @inject */
    public $translator;

    public function startup() {
        parent::startup();
        $this->template->website = website;
        $this->template->navigation = array();
        $this->template->description = "Jsme oficiálním výrobcem a prodejcem malých obytných karavanů - minikaravanů v České republice. "
                . "V nabídce máme obytné verze, cargo verze i speciální verze. Zajišťujeme také financování našich minikaravanů.";
        $this->template->keywords = array("minikaravany", "malý karavan", "prodej minikaravanů", "prodej karavanů", "City karavan");
        $this->template->email = adminEmail;
        $this->template->lang = $this->languageString();
    }

    protected function createTemplate($class = NULL) {
        $template = parent::createTemplate($class);
        $this->translator->createTemplateHelpers()
                ->register($template->getLatte());
        return $template;
    }

    public function handleChangeLocale($locale) {
        $this->translator->setLocale($locale);
        $this->redirect('this');
    }

    public function setTitle($title) {
        $this->template->title = $title;
    }

    public function setFooterText($text) {
        $this->template->footerText = $text;
    }

    private function languageString(){
        return $this->locale == "cs" ? "cs_CZ" : "de_DE";
    }
}
