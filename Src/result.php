<?php if (isset($result) && isset($lambda) && isset($mean) && isset($std_dev) && isset($mu) && isset($t)): ?>
    <div style="width: 80%; max-width: 800px; height: 400px; margin: auto;">
        <canvas id="densityChart"></canvas>
    </div>

    <script>
        // Code JavaScript pour générer le graphique avec Chart.js
        var ctx = document.getElementById('densityChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Densité de probabilité',
                    data: [],
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,  // Rendre le graphique réactif
                maintainAspectRatio: false,  // Permet de ne pas garder un ratio fixe
                title: {
                    display: true,
                    text: 'Calculateur de probabilité - Loi inverse-gaussienne'
                }
            }
        });

        // Générer les données pour le graphique
        var xValues = [];
        var yValues = [];
        var mu = <?php echo $mu; ?>;
        var lambda = <?php echo $lambda; ?>;
        for (var x = 0.01; x <= <?php echo $t; ?>; x += 0.1) {
            var roundedX = x.toFixed(2);  // Arrondi à 2 décimales
            xValues.push(roundedX);
            var y = math.sqrt(lambda / (2 * math.pi * math.pow(x, 3))) *
                math.exp(-lambda * math.pow(x - mu, 2) / (2 * math.pow(mu, 2) * x));
            yValues.push(y);
        }

        chart.data.labels = xValues;
        chart.data.datasets[0].data = yValues;
        chart.update();
    </script>
    <fieldset>
        <legend>Résultats</legend>

        <table>
            <tr>
                <th>Probabilité P(X ≤ t)</th>
                <th>λ</th>
                <th>X̄ (moyenne)</th>
                <th>σ (écart-type)</th>
            </tr>
            <tr>
                <td><?php echo number_format($result, 3); ?></td>
                <td><?php echo $lambda; ?></td>
                <td><?php echo $mean; ?></td>
                <td><?php echo number_format($std_dev, 3); ?></td>
            </tr>
        </table>
    </fieldset>
<?php else: ?>
    <p>Veuillez soumettre le formulaire pour obtenir les résultats.</p>
<?php endif; ?>
