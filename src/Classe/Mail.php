<?php
namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

Class Mail
{

    private $apiKey = '7b57eafe17fb2be2b750f81d607196c1';
    private $apiKeySecret = '0fee9ed5aa0aefbe07bca29ed6f433b9';


    public function Send($to_email, $to_name, $subject, $title, $content, $button)
    {
        $mj = new Client($this->apiKey, $this->apiKeySecret, true, ['version' => 'v3.1']);

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "pictoPictoEcam@gmail.com",
                        'Name' => "PictoPicto"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'LastName' => $to_name
                        ]
                    ],
                    'TemplateID' => 2701797,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'title' => $title,
                        'content' => $content,
                        'button' => $button
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();

    }
}
