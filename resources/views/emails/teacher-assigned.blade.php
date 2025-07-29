
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nouvelle assignation d'enseignement</title>
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
        .assignment-badge {
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
        .assignment-details {
            background-color: #f8f9fa;
            border-left: 4px solid #28a745;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .detail-item {
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .detail-item:last-child {
            border-bottom: none;
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
            <div class="assignment-badge">👨‍🏫 Nouvelle Assignation</div>
        </div>

        <div class="content">
            <h2>Bonjour {{ $teacher->first_name }} {{ $teacher->last_name }},</h2>
            
            <p>Nous avons le plaisir de vous informer que vous avez été <strong>assigné(e) à un nouvel enseignement</strong>.</p>

            <div class="assignment-details">
                <h3>📚 Détails de l'assignation</h3>
                
                <div class="detail-item">
                    <strong>🎯 Niveau d'étude :</strong> {{ $teaching->studyLevel->specification ?? 'Non spécifié' }}
                </div>
                
                <div class="detail-item">
                    <strong>👥 Groupe :</strong> Groupe {{ $teaching->group->name ?? $teaching->group_id }}
                </div>
                
                <div class="detail-item">
                    <strong>📖 Matière :</strong> {{ $teaching->subject->name ?? 'Non spécifiée' }}
                </div>
                
                <div class="detail-item">
                    <strong>📅 Année scolaire :</strong> {{ $teaching->schoolYear->name ?? $teaching->school_year_id }}
                </div>
                
                <div class="detail-item">
                    <strong>🕒 Date d'assignation :</strong> {{ $teaching->created_at->format('d/m/Y à H:i') }}
                </div>
            </div>

            <p><strong>Prochaines étapes :</strong></p>
            <ul>
                <li>Connectez-vous à votre espace professeur pour consulter les détails</li>
                <li>Préparez votre planning d'enseignement</li>
                <li>Consultez la liste des élèves de votre groupe</li>
                <li>Organisez votre programme pédagogique</li>
            </ul>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ url('/teacher') }}" class="btn">Accéder à mon espace</a>
            </div>

            <p>Si vous avez des questions concernant cette assignation, n'hésitez pas à contacter l'administration.</p>
        </div>

        <div class="footer">
            <p>Bonne continuation dans vos nouvelles fonctions d'enseignement !</p>
            <p><small>© {{ date('Y') }} GestEdu - Système de gestion scolaire</small></p>
        </div>
    </div>
</body>
</html>
