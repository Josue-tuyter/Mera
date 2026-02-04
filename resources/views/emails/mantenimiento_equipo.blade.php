<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; line-height: 1.6; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; }
        .header { background-color: #2c3e50; color: #ffffff; padding: 20px; text-align: center; }
        .content { padding: 30px; background-color: #ffffff; }
        .footer { background-color: #f8f9fa; color: #7f8c8d; padding: 15px; text-align: center; font-size: 12px; }
        .status-badge { background-color: #f39c12; color: white; padding: 5px 12px; border-radius: 20px; font-size: 14px; font-weight: bold; }
        .details { margin-top: 20px; border-collapse: collapse; width: 100%; }
        .details td { padding: 10px; border-bottom: 1px solid #f1f1f1; }
        .label { font-weight: bold; color: #7f8c8d; width: 40%; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="margin:0;">Recordatorio de Mantenimiento</h2>
        </div>
        <div class="content">
            <p>Estimado equipo de <strong>Finca Los Mera</strong>,</p>
            <p>Se informa que el siguiente equipo ha alcanzado su fecha programada de mantenimiento:</p>
            
            <div style="text-align: center; margin: 20px 0;">
                <span class="status-badge">MANTENIMIENTO REQUERIDO</span>
            </div>

            <table class="details">
                <tr>
                    <td class="label">Equipo/Herramienta:</td>
                    <td>{{ $equipo->nombre }}</td>
                </tr>
                <tr>
                    <td class="label">Serial:</td>
                    <td>{{ $equipo->serial }}</td>
                </tr>
                <tr>
                    <td class="label">Ubicación:</td>
                    <td>{{ $equipo->ubicacion }}</td>
                </tr>
                <tr>
                    <td class="label">Responsable:</td>
                    <td>{{ $equipo->responsable ? $equipo->responsable->name : 'No asignado' }}</td>
                </tr>
                <tr>
                    <td class="label">Costo Estimado:</td>
                    <td>${{ number_format($equipo->costo_mantenimiento_estimado, 2) }}</td>
                </tr>
            </table>

            <p style="margin-top: 25px;">Por favor, proceda con la revisión técnica para asegurar la operatividad de la herramienta.</p>
        </div>
        <div class="footer">
            Este es un mensaje automático del Sistema de Gestión de Finca Los Mera.
        </div>
    </div>
</body>
</html>