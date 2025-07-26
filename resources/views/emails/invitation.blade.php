
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invitation GestEdu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4e73df;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 5px 5px;
        }
        .btn {
            display: inline-block;
            background-color: #4e73df;
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Invitation GestEdu</h1>
        </div>
        <div class="content">
            <p>Bonjour,</p>
            
            <p>Vous avez été invité(e) à rejoindre la plateforme GestEdu en tant que <strong>{{ $roleName }}</strong>.</p>
            
            <p>Pour créer votre compte, cliquez sur le lien ci-dessous :</p>
            
            <div style="text-align: center;">
                <a href="{{ $invitationLink }}" class="btn">Créer mon compte</a>
            </div>
            
            <p><strong>Important :</strong> Ce lien d'invitation expire dans 7 jours.</p>
            
            <p>Si vous ne souhaitez pas créer de compte, vous pouvez ignorer cet email.</p>
            
            <p>Cordialement,<br>L'équipe GestEdu</p>
        </div>
        <div class="footer">
            <p>© {{ date('Y') }} GestEdu. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>
