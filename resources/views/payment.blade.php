<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago con Mercado Pago</title>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>
<body>
    <h1>Completar Pago</h1>

    <!-- Botón de pago de Mercado Pago -->
    <div id="mercado-pago-button"></div>

    <script>
        const mp = new MercadoPago("{{ config('services.mercadopago.public_key') }}");

        mp.checkout({
            preference: {
                id: '{{ $preference->id }}'
            },
            render: {
                container: '#mercado-pago-button', // El nombre de la clase donde se mostrará el botón de pago
                label: 'Pagar', // Cambiar el texto del botón de pago (opcional)
            }
        });
    </script>
</body>
</html>
