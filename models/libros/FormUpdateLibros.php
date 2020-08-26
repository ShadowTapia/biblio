<?php
/**
 * Created by PhpStorm.
 * User: chelo
 * Date: 17-08-2020
 * Time: 23:34
 */
namespace app\models\libros;

use yii\base\model;

class FormUpdateLibros extends model
{
    public $idLibros;
    public $isbn;
    public $titulo;
    public $subtitulo;
    public $descripcion;
    public $numpag;
    public $ano;
    public $idioma;
    public $formato;
    public $idcategoria;
    public $ideditorial;
    public $idautor;
    public $idtemas;
    public $imagen;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'idcategoria', 'ideditorial', 'idautor'], 'required','message' => 'Campo requerido'],
            [['isbn', 'numpag', 'ano', 'idcategoria', 'ideditorial','idtemas'], 'integer','message' => 'Sólo se aceptan valores númericos'],
            [['idioma', 'formato','idautor'], 'string'],
            [['imagen'],'file',
                'extensions'=>'jpg,png,gif',
                'maxSize' => 1024*1024*1, //1MB
                'tooBig' => 'El tamaño máximo permitido es 1MB',
                'wrongExtension' => 'El archivo {file} no contiene una extensión permitida'
            ],
            [['titulo'], 'string', 'max' => 60],
            [['subtitulo'], 'string', 'max' => 80],
            [['descripcion'], 'string', 'max' => 400],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
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

}