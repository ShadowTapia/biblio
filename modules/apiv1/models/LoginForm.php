<?php

namespace app\modules\apiv1\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{

    public $userrun;
    public $password;

    const EXPIRE_TIME = 604800; //token expiration time, 7 days valid


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['userrun', 'password'], 'required', 'message' => 'Campo requerido'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @param $attribute
     */
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Yii::$app->session->setFlash('error', 'Run o contraseña incorrecto.', $removeAfterAccess = true));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {

            //return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
            if ($this->getUser()) {
                $accessToken = $this->_user->generateAccessToken();
                $this->_user->expire_at = time() + static::EXPIRE_TIME;
                $this->_user->save();
                Yii::$app->user->login($this->_user, static::EXPIRE_TIME);
                return $accessToken;
            }
        }
        return false;
    }


    /**
     * @param $attribute
     */
    public function validarRut($attribute)
    {
        $rut = $this->userrun; //recibo el rut
        $rut_sin_puntos = str_replace('.', "", $rut); //le quito los puntos
        $data = explode('-', $rut_sin_puntos); //separo rut de dv
        $verificador = strtolower($data[1]); //asigno valor de dv
        $numeros = strrev($data[0]); //separo rut de dv
        $count = strlen($numeros); //asigno la longitud del string en este caso 8
        $count = $count - 1; //resto 1 al contador para comenzar el ciclo ya que las posiciones empiezan en 0
        $suma = 0;
        $recorreString = 0;
        $multiplo = 2;
        for ($i = 0; $i <= $count; $i++) //inicio mi ciclo hasta la posición 7
        {
            $resultadoM = $numeros[$recorreString] * $multiplo; //recorro String y multiplico
            $suma = $suma + $resultadoM; //se suma resultado de multiplicación por ciclo
            if ($multiplo == 7) {
                $multiplo = 1;
            }
            $multiplo++;
            $recorreString++;
        }
        $resto = $suma % 11;
        $dv = 11 - $resto;
        if ($dv == 11) {
            $dv = 0;
        }
        if ($dv == 10) {
            $dv = 'k';
        }
        if ($verificador != $dv) {
            $this->addError($attribute, "Rut Inválido");
        }
    }
}
