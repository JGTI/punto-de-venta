<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago\SDK;
use MercadoPago\Preference;
use MercadoPago\Item;

class PaymentController extends Controller
{
    /**
     * Muestra la página de pago con el botón de Mercado Pago.
     *
     * @return \Illuminate\View\View
     */
    public function createPayment()
    {
        // Configurar credenciales de Mercado Pago
        SDK::setAccessToken(config('services.mercadopago.access_token'));

        // Crear una nueva preferencia de pago
        $preference = new Preference();

        // Crear un ítem para la preferencia
        $item = new Item();
        $item->title = 'Producto de Ejemplo';  // Título del producto
        $item->quantity = 1;  // Cantidad del producto
        $item->unit_price = 100.00;  // Precio unitario del producto
        $preference->items = [$item];

        // Configurar URLs de retorno para la preferencia
        $preference->back_urls = [
            'success' => route('payment.success'),  // URL de éxito
            'failure' => route('payment.failure'),  // URL de fallo
            'pending' => route('payment.pending')   // URL de pendiente
        ];

        // Configurar retorno automático a la URL de éxito
        $preference->auto_return = 'approved';

        // Guardar la preferencia y generar la URL de pago
        $preference->save();

        // Retornar la vista con la preferencia de pago
        return view('payment', ['preference' => $preference]);
    }

    /**
     * Maneja la respuesta de un pago exitoso.
     *
     * @return \Illuminate\View\View
     */
    public function success()
    {
        return view('payment.success');
    }

    /**
     * Maneja la respuesta de un pago pendiente.
     *
     * @return \Illuminate\View\View
     */
    public function pending()
    {
        return view('payment.pending');
    }

    /**
     * Maneja la respuesta de un pago fallido.
     *
     * @return \Illuminate\View\View
     */
    public function failure()
    {
        return view('payment.failure');
    }

    /**
     * Maneja las notificaciones recibidas de Mercado Pago a través de webhooks.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function webhook(Request $request)
    {
        $data = $request->all();

        // Registra los datos recibidos para debugging
        \Log::info('Webhook received:', $data);

        // Obtener el tipo de notificación
        $notificationType = $data['type'] ?? null;

        // Procesar la notificación según su tipo
        if ($notificationType === 'payment') {
            // Obtener el ID del pago desde la notificación
            $paymentId = $data['data']['id'];

            // Obtener detalles del pago desde la API de Mercado Pago
            $payment = \MercadoPago\Payment::find_by_id($paymentId);

            // Procesar el pago según su estado
            switch ($payment->status) {
                case 'approved':
                    // Pago aprobado, actualiza la base de datos
                    \Log::info('Pago aprobado:', ['payment_id' => $paymentId]);
                    break;

                case 'pending':
                    // Pago pendiente, actualiza la base de datos
                    \Log::info('Pago pendiente:', ['payment_id' => $paymentId]);
                    break;

                case 'rejected':
                    // Pago rechazado, actualiza la base de datos
                    \Log::info('Pago rechazado:', ['payment_id' => $paymentId]);
                    break;

                default:
                    // Otro estado, maneja según sea necesario
                    \Log::info('Estado de pago desconocido:', ['payment_id' => $paymentId, 'status' => $payment->status]);
                    break;
            }
        }

        return response()->json(['status' => 'success'], 200);
    }
}
