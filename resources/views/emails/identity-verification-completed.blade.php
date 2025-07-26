
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vérification d'identité complétée</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #4e73df, #6f42c1); color: white; padding: 20px; border-radius: 8px 8px 0 0; }
        .content { background: #f8f9fc; padding: 20px; border-radius: 0 0 8px 8px; }
        .button { display: inline-block; background: #f6c23e; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 10px 0; }
        .user-info { background: white; padding: 15px; border-radius: 5px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Vérification d'identité complétée</h2>
        </div>
        <div class="content">
            <p>Bonjour,</p>
            
            <p>Un utilisateur a complété son processus de vérification d'identité :</p>
            
            <div class="user-info">
                <p><strong>Nom :</strong> {{ $user->first_name }} {{ $user->last_name }}</p>
                <p><strong>Email :</strong> {{ $user->email }}</p>
                <p><strong>Rôle :</strong> {{ $user->role->name ?? 'N/A' }}</p>
                <p><strong>Date de vérification :</strong> {{ now()->format('d/m/Y à H:i') }}</p>
            </div>
            
            <p>Vous pouvez maintenant examiner les documents soumis et valider ou rejeter le compte.</p>
            
            <a href="{{ $userDetailsUrl }}" class="button">Voir les détails de l'utilisateur</a>
            
            <p>Cordialement,<br>
            Système de gestion scolaire</p>
        </div>
    </div>
</body>
</html>
