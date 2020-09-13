<?php

namespace App\Presenters;

use Nette\Application\UI\Form;
use Nette\DI\Container;
use Nette\Mail\Message;
use Nette\Mail\SendmailMailer;

class HomepagePresenter extends BasePresenter
{
    private $container;
    public function __construct(Container $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    public function createComponentContactForm(string $name): Form
    {
        $form = new Form();

        $form->addEmail('email')
            ->setRequired(true)
            ->setHtmlAttribute('placeholder', 'E-mail');
        $form->addTextArea('content')
            ->setHtmlAttribute('placeholder', 'Message');
        $form->addSubmit('submit');

        $form->onSuccess[] = [$this, 'contactFormSucceeded'];
        return $form;
    }

    public function contactFormSucceeded(Form $form): void
    {
        $values = $form->getValues();

        foreach($values as &$value) {
            $value = strip_tags($value);
        }

        $mail = new Message;
            $mail->setFrom($values['email'])
                ->addReplyTo($values['email'])
                ->addTo('hanzlovci@gmail.com')
                ->setSubject('Zpráva z webu')
                ->setBody($values['content'] . '

Zpráva odeslaná z webu.');


        $mailer = new SendmailMailer;
        $mailer->send($mail);

        $this->flashMessage('E-mail byl úspěšně odeslán.', 'success');
        $this->redirect('this');
    }
}
