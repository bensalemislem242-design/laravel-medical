<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Print Prescription</title>

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

    <style>
        body, html { min-height: 53%; max-width: 62%; margin: 0 auto; }
        .page-header { padding-top: 19px; padding-bottom: 28px; }
        #nomLabel { width: 24%; } #nom { width: 17%; }
        #prenomLabel { width: 31%; } #prescritionBody { width: 100%; }
        #sendButton { margin-top: 15px; padding: 10px 20px; background-color: #007bff; color: white; border: none; cursor: pointer; border-radius: 5px; }
        #sendButton:hover { background-color: #0056b3; }

        @media print {
            body { min-height: 520px; max-width: 536px; margin: 0 auto; }
        }
    </style>
</head>
<body>
<div class="wrapper">
    <section class="invoice">
        <div class="row">
            <div class="col-12">
                <h2 class="page-header">s-Hospital
                    <small class="float-right">Date: {{ date('Y-m-d', strtotime($orientataionsltr['updated_at'])) }}</small>
                </h2>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <tbody>
                <tr>
                    <th id="nomLabel">Name:</th>
                    <td id="nom">{{ $patient->name }}</td>
                    <th id="prenomLabel">Last Name:</th>
                    <td>{{ $patient->lastname }}</td>
                </tr>
                <tr>
                    <th>Phone:</th>
                    <td>{{ $patient->phone }}</td>
                    <th>Date of birth:</th>
                    <td>{{ $patient->dob }}</td>
                </tr>
                <tr>
                    <td colspan="4">
                        <textarea id="prescritionBody" cols="29" rows="13">{{ $orientataionsltr->content }}</textarea>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- Bouton Envoyer -->
        <button id="sendButton">Envoyer</button>
    </section>
</div>

<script>
    window.addEventListener("load", function() {
        window.print();
    });

    // Envoyer les données directement à Flutter
    document.getElementById('sendButton').addEventListener('click', function () {
        // 🔴 REMPLACE CETTE IP par celle de ton téléphone/émulateur
        const FLUTTER_IP = '192.168.0.198'; // ⚠️ Change avec l'IP qui s'affiche dans Flutter
        
        const data = {
            name: document.getElementById('nom').innerText,
            lastname: "{{ $patient->lastname }}",
            phone: "{{ $patient->phone }}",
            dob: "{{ $patient->dob }}",
            content: document.getElementById('prescritionBody').value,
            date: "{{ date('Y-m-d', strtotime($orientataionsltr['updated_at'])) }}"
        };

        fetch(`http://${FLUTTER_IP}:8080/sendPrescription`, { 
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert('✅ Prescription envoyée à l\'application Flutter avec succès!');
            } else {
                alert('❌ Erreur: ' + result.message);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('❌ Erreur de connexion. Vérifiez que l\'app Flutter est ouverte et que l\'IP est correcte.\nIP utilisée: ' + FLUTTER_IP);
        });
    });
</script>
</body>
</html>
