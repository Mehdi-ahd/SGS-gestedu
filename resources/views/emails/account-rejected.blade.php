
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Compte rejeté</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 2em;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }
        .rejection-badge {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            display: inline-block;
            margin-bottom: 20px;
        }
        .content {
            margin-bottom: 30px;
        }
        .reason-box {
            background-color: #f8f9fa;
            border-left: 4px solid #dc3545;
            padding: 15px;
            margin: 20px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">🎓 GestEdu</div>
            <div class="rejection-badge">❌ Compte Rejeté</div>
        </div>

        <div class="content">
            <h2>Bonjour {{ $user->first_name }} {{ $user->last_name }},</h2>
            
            <p>Nous regrettons de vous informer que votre demande de compte GestEdu a été <strong>rejetée</strong>.</p>

            @if($reason)
            <div class="reason-box">
                <h4>Motif du rejet :</h4>
                <p>{{ $reason }}</p>
            </div>
            @endif
            
            <p><strong>Que faire maintenant ?</strong></p>
            <ul>
                <li>Vérifiez que tous vos documents sont conformes aux exigences</li>
                <li>Assurez-vous que vos informations personnelles sont correctes</li>
                <li>Contactez l'administration pour plus de détails si nécessaire</li>
                <li>Vous pouvez soumettre une nouvelle demande après correction</li>
            </ul>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/register') }}" class="btn">Créer un nouveau compte</a>
            </div>

            <p><strong>Informations de la demande :</strong></p>
            <ul>
                <li><strong>Email :</strong> {{ $user->email }}</li>
                <li><strong>Date de rejet :</strong> {{ now()->format('d/m/Y à H:i') }}</li>
            </ul>
        </div>

        <div class="footer">
            <p>Si vous avez des questions, n'hésitez pas à contacter notre support.</p>
            <p><small>© {{ date('Y') }} GestEdu - Système de gestion scolaire</small></p>
        </div>
    </div>
</body>
</html>
