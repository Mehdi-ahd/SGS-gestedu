
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Changement de statut d'inscription</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #4e73df; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f8f9fc; }
        .status-accepted { color: #28a745; font-weight: bold; }
        .status-rejected { color: #dc3545; font-weight: bold; }
        .footer { padding: 20px; text-align: center; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>École Jean Piaget 2</h1>
            <p>Notification de changement de statut d'inscription</p>
        </div>
        
        <div class="content">
            <p>Bonjour {{ $parent->firstname }} {{ $parent->lastname }},</p>
            
            <p>Nous vous informons que le statut d'inscription de votre enfant a été mis à jour :</p>
            
            <ul>
                <li><strong>Élève :</strong> {{ $inscription->student->getFullName() }}</li>
                <li><strong>Niveau d'étude :</strong> {{ $inscription->study_level->specification }}</li>
                <li><strong>Année scolaire :</strong> {{ $inscription->school_year_id }}</li>
                <li><strong>Nouveau statut :</strong> 
                    <span class="{{ $newStatus === 'accepté' ? 'status-accepted' : 'status-rejected' }}">
                        {{ ucfirst($newStatus) }}
                    </span>
                </li>
            </ul>
            
            @if($newStatus === 'accepté')
                <p>Félicitations ! L'inscription de votre enfant a été acceptée. Vous pouvez maintenant procéder au règlement des frais de scolarité.</p>
            @else
                <p>Malheureusement, l'inscription de votre enfant n'a pas pu être acceptée. Pour plus d'informations, veuillez contacter l'administration de l'école.</p>
            @endif
            
            <p>Pour toute question, n'hésitez pas à nous contacter.</p>
        </div>
        
        <div class="footer">
            <p>Cordialement,<br>L'administration de l'École Jean Piaget 2</p>
        </div>
    </div>
</body>
</html>
