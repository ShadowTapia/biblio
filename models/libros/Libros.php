<?php

namespace app\models\libros;

use yii\db\ActiveRecord;
use app\models\autor\Autor;
use app\models\categorias\Categorias;
use app\models\editorial\Editorial;
use app\models\temas\Temas;
use app\models\numejem\Numejem;
use app\models\ejemplar\Ejemplar;

/**
 * This is the model class for table "libros".
 *
 * @property string $idLibros
 * @property int|null $isbn
 * @property string|null $titulo
 * @property string|null $subtitulo
 * @property string|null $descripcion
 * @property int|null $numpag
 * @property int|null $ano
 * @property string|null $idioma
 * @property string|null $formato
 * @property int $idcategoria
 * @property int $ideditorial
 * @property string $idautor
 * @property int $idtemas
 * @property string|null $imagen
 *
 * @property Ejemplar[] $ejemplars
 * @property Autor $idautor0
 * @property Categorias $idcategoria0
 * @property Editorial $ideditorial0
 * @property Temas $idtemas0
 * @property Numejem $numejem
 * @property Reserva[] $reservas
 */
class Libros extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'libros';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'idcategoria', 'ideditorial', 'idautor'], 'required','message' => 'Campo requerido'],
            [['isbn', 'numpag', 'ano', 'idcategoria', 'ideditorial','idtemas'], 'integer','message' => 'Sólo se aceptan valores númericos'],
            ['isbn','validaISBN'],
            [['idioma', 'formato','idautor'], 'string'],
            [['imagen'],'file',
                'extensions'=>'jpg,png,gif',
                'skipOnEmpty' => true,
                'maxSize' => 1024*1024*1, //1MB
                'tooBig' => 'El tamaño máximo permitido es 1MB',
                'wrongExtension' => 'El archivo {file} no contiene una extensión permitida'
                ],
            [['idLibros'], 'string', 'max' => 15],
            [['titulo'], 'string', 'max' => 60],
            [['subtitulo'], 'string', 'max' => 80],
            [['descripcion'], 'string', 'max' => 400],
//            [['idautor'], 'exist', 'skipOnError' => true, 'targetClass' => Autor::className(), 'targetAttribute' => ['idautor' => 'idautor']],
//            [['idcategoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categorias::className(), 'targetAttribute' => ['idcategoria' => 'idcategoria']],
//            [['ideditorial'], 'exist', 'skipOnError' => true, 'targetClass' => Editorial::className(), 'targetAttribute' => ['ideditorial' => 'ideditorial']],
//            [['idtemas'], 'exist', 'skipOnError' => true, 'targetClass' => Temas::className(), 'targetAttribute' => ['idtemas' => 'idtemas']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idLibros' => 'Id',
            'isbn' => 'ISBN',
            'titulo' => 'Titulo',
            'subtitulo' => 'Subtitulo',
            'descripcion' => 'Descripción',
            'numpag' => 'Páginas',
            'ano' => 'Año',
            'idioma' => 'Idioma',
            'formato' => 'Formato',
            'idcategoria' => 'Categoría',
            'ideditorial' => 'Editorial',
            'idautor' => 'Autor',
            'idtemas' => 'Temas',
            'imagen' => 'Imagen Libro',
        ];
    }

    /**
     * Gets query for [[Ejemplars]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEjemplars()
    {
        return $this->hasMany(Ejemplar::class, ['idLibros' => 'idLibros']);
    }

    /**
     * Gets query for [[Idautor0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdautor0()
    {
        return $this->hasOne(Autor::class, ['idautor' => 'idautor']);
    }

    /**
     * Gets query for [[Idcategoria0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdcategoria0()
    {
        return $this->hasOne(Categorias::class, ['idcategoria' => 'idcategoria']);
    }

    /**
     * Gets query for [[Ideditorial0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdeditorial0()
    {
        return $this->hasOne(Editorial::class, ['ideditorial' => 'ideditorial']);
    }

    /**
     * Gets query for [[Idtemas0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdtemas0()
    {
        return $this->hasOne(Temas::class, ['idtemas' => 'idtemas']);
    }

    /**
     * Gets query for [[Numejem]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNumejem()
    {
        return $this->hasOne(Numejem::class, ['idLibros' => 'idLibros']);
    }

    /**
     * Gets query for [[Reservas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReservas()
    {
        return $this->hasMany(Reserva::class, ['idLibros' => 'idLibros']);
    }

    /**
     * @param $attribute
     * @return int
     */
    public function validaISBN($attribute)
    {
        $regex = '/\b(?:ISBN(?:: ?| ))?((?:97[89])?\d{9}[\dx])\b/i';

        if (preg_match($regex, str_replace('-', '', $this->isbn), $matches)) {
            return (10 === strlen($matches[1]))
                ? 1   // ISBN-10
                : 2;  // ISBN-13
        }else{
            $this->addError($attribute,"ISBN Invalido");
        }
        return null;
    }
}
