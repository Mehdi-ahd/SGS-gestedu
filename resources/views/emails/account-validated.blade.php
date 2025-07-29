
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Compte validé</title>
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
        .success-badge {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            display: inline-block;
            margin-bottom: 20px;
        }
        .content {
            margin-bottom: 30px;
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
            <div class="success-badge">✅ Compte Validé</div>
        </div>

        <div class="content">
            <h2>Félicitations {{ $user->first_name }} {{ $user->last_name }} !</h2>
            
            <p>Nous avons le plaisir de vous informer que votre compte GestEdu a été <strong>validé avec succès</strong>.</p>
            
            <p>Vous pouvez maintenant accéder à toutes les fonctionnalités de votre espace personnel :</p>
            
            <ul>
                <li>Consulter votre tableau de bord</li>
                <li>Accéder aux informations de votre profil</li>
                <li>Utiliser tous les services disponibles selon votre rôle</li>
            </ul>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/login') }}" class="btn">Se connecter maintenant</a>
            </div>

            <p><strong>Informations de votre compte :</strong></p>
            <ul>
                <li><strong>Email :</strong> {{ $user->email }}</li>
                <li><strong>Rôle :</strong> {{ ucfirst($user->role ?? 'Utilisateur') }}</li>
                <li><strong>Date de validation :</strong> {{ now()->format('d/m/Y à H:i') }}</li>
            </ul>
        </div>

        <div class="footer">
            <p>Si vous n'êtes pas à l'origine de cette demande, veuillez nous contacter immédiatement.</p>
            <p><small>© {{ date('Y') }} GestEdu - Système de gestion scolaire</small></p>
        </div>
    </div>
</body>
</html>
