<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Message;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MailerController extends AbstractController
{
    /**
     * @Route("/callback_form", name="callback_form")
     */
    public function callback_form(Request $request, MailerInterface $mailer){
        $token = "2102312578:AAF6iR_1pAUR4GY1Vg8TwgF3CsIBCKWQyBg";
        $chat_id = "-1001677654724";# Заявки VAG-PIK

        $arr = array(
            "Заявка с" => " с формы сайта https://audi.pikms.ru/ ",
            "Телефон" => $request->get('phone'),
           "Имя" => $request->get('name'),
        );
        /*Цикл по массиву (собираем сообщение) */
        $txt = '';
        foreach($arr as $key => $value) {
            $txt .= "<b>".$key."</b>: ".htmlspecialchars($value)."\n";
        }
        $sendTextToTelegram = file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&parse_mode=html&text=".rawurlencode($txt))."\n";
        if (!$sendTextToTelegram){
            return new JsonResponse(['error'=>'<p>Ошибка при отправке в Telegram</p>']);
        }

       /* $to = 'info@piksp.ru';

        $email = (new Email())
            ->from('info@my-side.online')
            ->to((string)$to)
            ->subject('Новая заявка с сайта Piksp.ru')
            ->html('<p>Новая заявка с сайта Piksp.ru</p>
            <p>Телефон отправителя: ' . $request->get('phone') . '</p>'
            );
        $mailer->send($email);*/


        return new JsonResponse(['success'=>'<p>Спасибо! Ваша заявка отправлена.</p>']);
    }
}
