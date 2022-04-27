<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

    trait ApiResponser
    {
        private function successResponse($data, $code)
        {
            return response()->json($data, $code);
        }
        protected function errorResponse($mensaje, $codigo)
        {
            return response()->json(['error' => $mensaje, 'codigo' => $codigo], $codigo);
        }
        protected function showAll(Collection $coleccion, $codigo = 200)
        {
            return $this->successResponse($coleccion, $codigo);
        }
        protected function showOne(Model $instancia, $codigo = 200)
        {
            return $this->successResponse($instancia, $codigo);
        }
        protected function showMessage($mensaje, $codigo = 200)
        {
            return $this->successResponse(['mensaje' => $mensaje], $codigo);
        }
    }

?>