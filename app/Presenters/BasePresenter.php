<?php

namespace App\Presenters;

use Latte\Engine;
use Latte\Macros\MacroSet;
use Nette\Application\UI\Presenter;

abstract class BasePresenter extends Presenter
{
    public function __construct()
    {
        parent::__construct();
    }

    public function beforeRender()
    {
        parent::beforeRender();
        $this->addMacros();
    }

    private function addMacros(): void
    {
        $set = new MacroSet($this->template->getLatte()->getCompiler());
        $set->addMacro(
            'svg',
            function ($node, $writer) {
                $svgPath = APP_PATH . '/resources/svg/';
                return $writer->write('include \'' . $svgPath . $node->args . '.svg\';');
            }
        );
    }
}
