<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { width: 80%; margin: 20px auto; border: 1px solid #eee; padding: 20px; border-radius: 10px; }
        .header { background: #e53e3e; color: white; padding: 10px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { padding: 20px; }
        .footer { font-size: 12px; color: #777; margin-top: 20px; text-align: center; }
        .alert-box { background: #fff5f5; border-left: 5px solid #e53e3e; padding: 15px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Alerta de Inventario Bajo</h2>
        </div>
        <div class="content">
            <p>Hola,</p>
            <p>Se ha detectado que el siguiente insumo ha alcanzado o superado su nivel de <strong>stock mínimo</strong>:</p>
            
            <div class="alert-box">
                <strong>Material:</strong> {{ $material->nombre }}<br>
                <strong>Stock Actual:</strong> <span style="color: red; font-weight: bold;">{{ $material->stock }} {{ $material->unidad }}</span><br>
                <strong>Mínimo Permitido:</strong> {{ $material->stock_minimo }} {{ $material->unidad }}
            </div>

            <p>Por favor, realice el pedido de reposición a la brevedad para evitar interrupciones en las actividades.</p>
        </div>
        <div class="footer">
            Este es un mensaje automático generado por el Sistema de Gestión Agrícola.
        </div>
    </div>
</body>
</html>