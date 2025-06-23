<?php

namespace App\Traits;

trait AdminHelpers
{
    protected function getAdminUserData()
    {
        $session = session();
        return [
            'id' => $session->get('id'),
            'nombre' => $session->get('nombre'),
            'apellido' => $session->get('apellido'),
            'email' => $session->get('email'),
            'rol' => $session->get('rol')
        ];
    }
    protected function sendJsonResponse($success, $message, $data = null, $statusCode = 200)
    {
        $response = [
            'success' => $success,
            'message' => $message
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        // Usar el servicio de response si no está disponible en el controlador
        $responseService = $this->response ?? service('response');
        return $responseService->setStatusCode($statusCode)->setJSON($response);
    }
    protected function validateAjaxRequest()
    {
        try {
            // Intentar obtener el request desde el controlador o desde el servicio
            $request = $this->request ?? service('request');

            if (!$request) {
                return null; // Si no hay request, permitir continuar
            }

            if (!$request->isAJAX()) {
                $responseService = $this->response ?? service('response');
                return $responseService->setStatusCode(404);
            }
            return null;
        } catch (\Exception $e) {
            log_message('error', 'Error validating AJAX request: ' . $e->getMessage());
            // En caso de error, permitir continuar en lugar de bloquear
            return null;
        }
    }

    protected function handleException(\Exception $e, $defaultMessage = 'Error inesperado')
    {
        log_message('error', $e->getMessage());

        try {
            return $this->sendJsonResponse(false, $defaultMessage . ': ' . $e->getMessage());
        } catch (\Exception $responseError) {
            // Si falla todo, devolver respuesta básica
            log_message('error', 'Error creating JSON response: ' . $responseError->getMessage());
            $responseService = service('response');
            return $responseService->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => $defaultMessage
            ]);
        }
    }
}
