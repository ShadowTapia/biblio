<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required', 'message' => 'Campo requerido'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Código de verificación',
        ];
    }

    public static function clean_string($string)
    {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");

        return str_replace($bad, "", $string);
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact($email_to)
    {
        $content = "Email: " . $this->email . "\n";
        $content .= "Nombre: " . $this->name . "\n";
        $content .= "Asunto: " . $this->subject . "\n";
        $content .= "Mensaje: " . $this->body . "\n";
        if ($this->validate()) {

            $headers = "From: " . $this->email . "\r\n" .

                "Reply-To: " . $this->email . "\r\n" .

                "X-Mailer: PHP/" . phpversion();

            @mail($email_to, $this->subject, $content, $headers);

            return true;
        }
        return false;
    }
}
