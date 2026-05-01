<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de mot de passe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 2px solid #007bff;
        }
        .header h1 {
            color: #007bff;
            margin: 0;
        }
        .content {
            padding: 20px;
        }
        .otp-box {
            background-color: #f8f9fa;
            border: 2px dashed #007bff;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        .otp-code {
            font-size: 48px;
            font-weight: bold;
            color: #007bff;
            letter-spacing: 10px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            border-top: 1px solid #ddd;
            color: #777;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SmartHospital</h1>
        </div>
        
        <div class="content">
            <h2>Réinitialisation de mot de passe</h2>
            
            <p>Bonjour <strong>{{ $user->name ?? $user->email }}</strong>,</p>
            
            <p>Nous avons reçu une demande de réinitialisation de mot de passe pour votre compte. Voici votre code de vérification :</p>
            
            <div class="otp-box">
                <div class="otp-code">{{ $otp }}</div>
            </div>
            
            <p>Ce code expirera dans <strong>15 minutes</strong>.</p>
            
            <p>Si vous n'avez pas demandé cette réinitialisation, ignorez cet email.</p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} SmartHospital. Tous droits réservés.</p>
            <p>Cet email a été envoyé automatiquement.</p>
        </div>
    </div>
</body>
</html>