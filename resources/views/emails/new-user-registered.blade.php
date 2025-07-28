
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nouvel utilisateur enregistré</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #4e73df, #6f42c1); color: white; padding: 20px; border-radius: 8px 8px 0 0; }
        .content { background: #f8f9fc; padding: 20px; border-radius: 0 0 8px 8px; }
        .button { display: inline-block; background: #1cc88a; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 10px 0; }
        .user-info { background: white; padding: 15px; border-radius: 5px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Nouvel utilisateur enregistré</h2>
        </div>
        <div class="content">
            <p>Bonjour,</p>
            
            <p>Un nouvel utilisateur vient de s'enregistrer sur la plateforme :</p>
            
            <div class="user-info">
                <p><strong>Nom :</strong> {{ $user->getFullName() }}</p>
                <p><strong>Email :</strong> {{ $user->email }}</p>
                <p><strong>Rôle :</strong> {{ $user->role->name ?? 'N/A' }}</p>
                <p><strong>Date d'inscription :</strong> {{ $user->created_at->format('d/m/Y à H:i') }}</p>
                <p><strong>Statut :</strong> {{ $user->status }}</p>
            </div>
            
            <p>Vous pouvez consulter les détails de cet utilisateur et gérer son compte via le panneau d'administration.</p>
            
            <a href="{{ $userManagementUrl }}" class="button">Gérer les utilisateurs</a>
            
            <p>Cordialement,<br>
            Système de gestion scolaire</p>
        </div>
    </div>
</body>
</html>
