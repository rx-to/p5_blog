<?php

namespace Blog\Controllers;

require_once 'models/ContactManager.php';
require_once 'PHPMailer.php';

use \Blog\Models\Model;
use \Blog\Models\ContactManager;
use \Blog\Tools\Util;
use \PHPMailer\PHPMailer\PHPMailer;

class ControllerContact extends Controller
{
    function __construct()
    {
        if (isset($_POST) && !empty($_POST)) {
            switch (filter_var($_POST['action'], FILTER_SANITIZE_STRING)) {
                case 'sendContact':
                    $data = [
                        'last_name'  => filter_var($_POST['last_name'], FILTER_SANITIZE_STRING),
                        'first_name' => filter_var($_POST['first_name'], FILTER_SANITIZE_STRING),
                        'email'      => filter_var($_POST['email'], FILTER_SANITIZE_STRING),
                        'subject'    => filter_var($_POST['subject'], FILTER_SANITIZE_STRING),
                        'message'    => filter_var($_POST['message'], FILTER_SANITIZE_STRING)
                    ];
                    $json['alert'] = $this->sendContact($data);
                    break;
            }
            echo json_encode($json);
        }
    }

    /**
     * Sends contact form.
     * @param  array $data
     * @return string
     */
    private function sendContact($data)
    {
        $errors = [];
        if (!Util::checkStrLen($data['last_name'], 3, 255))                                                   $errors[] = 'Veuillez saisir un nom de famille compris entre 3 et 255 caractères.';
        if (!Util::checkStrLen($data['first_name'], 3, 255))                                                  $errors[] = 'Veuillez saisir un prénom compris entre 3 et 255 caractères.';
        if (!Util::checkStrLen($data['email'], 3, 255) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Veuillez saisir une adresse e-mail valide.';
        if (!Util::checkStrLen($data['subject'], 3, 255))                                                     $errors[] = 'Veuillez saisir un sujet compris entre 3 et 255 caractères.';
        if (!Util::checkStrLen($data['message'], 10, 1000))                                                   $errors[] = 'Veuillez saisir un message compris entre 10 et 1 000 caractères.';
        if (count($errors) == 0) {
            $contactManager = new ContactManager();
            if (!$contactManager->insertContact($data) || !$this->sendEmail($data)) $errors[] = 'Une erreur est survenue, veuillez réessayer ou contacter un administrateur si le problème persiste.';
        }
        return Util::generateAlert($errors, "Votre demande de contact a bien été transmise.");
    }

    /**
     * Sends email.
     * @param array $data
     * @return bool
     */
    private function sendEmail($data)
    {
        $mail = new PHPMailer(true);

        // Encoding
        $mail->CharSet  = 'UTF-8';
        $mail->Encoding = 'base64';

        // Recipients
        $mail->setFrom('contact-efblog@ecfransoa.com', 'EF Blog');
        $mail->addAddress('contact@ecfransoa.com', 'François ESPIASSE');
        $mail->addReplyTo($data['email'], ucfirst($data['first_name']) . ' ' . strtoupper($data['last_name']));
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject  = $data['subject'];

        $mail->Body     = "<p>Vous venez de recevoir une demande de contact sur votre blog :</p>";
        $mail->Body    .= '<ul style="list-style: none; padding: 0;">';
        $mail->Body    .=     "<li><strong>De :</strong> " . ucfirst($data['first_name']) . " " . strtoupper($data['last_name']) . ' &lt;<a href="mailto:' . strtolower($data['email']) . '">' . strtolower($data['email']) . "</a>&gt;</li>";
        $mail->Body    .=     "<li><strong>Objet :</strong> " . $data['subject'] . "</li>";
        $mail->Body    .=     "<li><strong>Message :</strong> " . $data['message'] . "</li>";
        $mail->Body    .= "</ul>";

        $mail->AltBody  = 'Vous venez de recevoir une demande de contact sur votre blog de la part de ' . ucfirst($data['first_name']) . " " . strtoupper($data['last_name']) . ' <' . strtolower($data['email']) . ">.\r\n";
        $mail->AltBody .= "Objet : " . $data['subject'] . "\r\n";
        $mail->AltBody .= "Message : " . $data['message'];

        return $mail->send();
    }

    /**
     * Returns contactlist.
     * @return mixed
     */
    private function getContactList()
    {
        $contactManager = new ContactManager();
        return $contactManager->selectContacts();
    }

    /**
     * Returns contactlist.
     * @return mixed
     */
    private function getContact($id)
    {
        $model = new Model();
        return $model->selectFrom('contact', 'id', $id);
    }

    /**
     * Returns current page data.
     * @param  string $visibility
     * @param  string $slug
     * @param  int    $id
     * @return array
     */
    protected function getPageData($visibility, $slug, $id = null)
    {
        $data          = $id ? $this->getContact($id) : $this->getContactList();
        $data['page']  = parent::getPageData($visibility, $slug)['page'];
        return $data;
    }
}
