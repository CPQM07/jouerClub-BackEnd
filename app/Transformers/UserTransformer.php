<?php

namespace App\Transformers\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    { // array para transformar los indices de la BD
        return [
            'identificador'      => (int)$user->id,
            'nombre'             => (string)$user->name,
            'apellido'           => (string)$user->lastname,
            'alias'              => (string)$user->nickname,
            'correo'             => (string)$user->email,
            'celular'            => (string)$user->phone,
            'contraseña'         => (string)$user->password,
            'avatar'             => (string)$user->avatar,
            'estado'             => (string)$user->status,
            'tipo'               => (string)$user->type,
            'codigoVerificacion' => (string)$user->code_verification,
            'fechaCreacion'      => (string)$user->created_at,
            'fechaActualizacion' => (string)$user->updated_at,
            'fechaEliminacion'   => isset($user->deleted_at) ? (string)$user->deleted_at : null,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'identificador' => 'id',
            'nombre' => 'name',
            'apellido' => 'lastname',
            'alias' => 'nickname',
            'correo' => 'email',
            'celular' => 'phone',
            'contraseña' => 'password',
            'avatar' => 'avatar',
            'estado' => 'status',
            'tipo' => 'type',
            'codigoVerificacion' => 'code_verification',
            'fechaCreacion' => 'created_at',
            'fechaActualizacion' => 'updated_at',
            'fechaEliminacion' => 'deleted_at'
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id'                => 'identificador',
            'name'              => 'nombre',
            'lastname'          => 'apellido',
            'nickname'          => 'alias',
            'email'             => 'correo',
            'phone'             => 'celular',
            'password'          => 'contraseña',
            'avatar'            => 'avatar',
            'status'            => 'estado',
            'type'              => 'tipo',
            'code_verification' => 'codigoVerificacion',
            'created_at'        => 'fechaCreacion',
            'updated_at'        => 'fechaActualizacion',
            'deleted_at'        => 'fechaEliminacion'
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
