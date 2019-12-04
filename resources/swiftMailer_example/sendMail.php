<?php

require_once './vendor/autoload.php';
require_once './config.php';

/**
 * @param string $messages
 */
function sendMail(array $swiftMailerConfig, array $messages = ['Привет, это тестовое письмо. Дальше будет веселее!']){
    // Create the Transport
    $transport = (new Swift_SmtpTransport($swiftMailerConfig['domain'], $swiftMailerConfig['port']))
        ->setUsername($swiftMailerConfig['user_name'])
        ->setPassword($swiftMailerConfig['password'])
        ->setEncryption($swiftMailerConfig['smtp_encryption'])
    ;

    // Create the Mailer using your created Transport
    $mailer = new Swift_Mailer($transport);

    // Create a message
    $message = (new Swift_Message('Wonderful Subject'))
        ->setFrom([$swiftMailerConfig['user_name'] => 'MGerman'])
        ->setTo(['iduso@mail.ru' => 'hi there!'])
        ->setBody($messages[0]);

    // Send the message
    try {
        $result = $mailer->send($message);
    } catch (Exception $e) {
        $result = ['success' => 0, 'message' => $e->getMessage() ];
    }
    return $result;
}

/**
 * @param array $config
 * @return array|int
 */
function mailSendMessage(array $config, array $body)
{
    try {
        // Create the SMTP Transport
        $transport = (new Swift_SmtpTransport($config['host'], $config['port']))
            ->setUsername( $config['username'])
            ->setPassword( $config['password2'])
            ->setEncryption($config['encryption']);

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

        // Create a message
        $message = (new Swift_Message($config['subject']))
            ->setFrom([$config['username'] => $config['userCaption']])
            ->setTo([$config['to'] => 'hi there!'])
            ->setBody($body[0]);

        // Send the message
        $result = $mailer->send($message);

    } catch (Exception $e) {
        $result = ['success' => 0, 'message' => $e->getMessage() ];
    }
    return $result;
}

//$rs = sendMail($yandMailConfig,["ok. hellow. приехали!"]); // без русских символов сообщение не отправляет, очень умно!
$rs = mailSendMessage($yandSwiftMailerConfig1, ['Ну, что сказать, было весело, ага!']);
echo "<pre>";
var_dump($rs);
echo "</pre>";

