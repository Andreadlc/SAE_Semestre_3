<?php if (isset($result) && isset($lambda) && isset($mean) && isset($std_dev) && isset($mu) && isset($t) && isset($n)) : ?>
    <div style="width: 80%; max-width: 800px; height: 400px; margin: auto;">
        <canvas id="densityChart"></canvas>
    </div>

    <script>
        // Récupération des données depuis PHP
        var mu = <?php echo $mu; ?>;
        var lambda = <?php echo $lambda; ?>;
        var t = <?php echo $t; ?>;
        var n = <?php echo $n; ?>;
        var h = t / n; // Largeur des rectangles
        var xValues = [];
        var yValues = [];
        var rectAreas = [];
        var totalArea = 0;

        // Génération des données
        for (var i = 0; i <= n; i++) {
            var x = i * h;
            xValues.push(x.toFixed(2)); // Ajout des x pour le graphique
            var y = Math.sqrt(lambda / (2 * Math.PI * Math.pow(x, 3))) *
                Math.exp(-lambda * Math.pow(x - mu, 2) / (2 * Math.pow(mu, 2) * x));
            if (isNaN(y)) y = 0; // Gérer les cas où y est NaN
            yValues.push(y);

            // Calcul des aires des rectangles
            if (i < n) {
                rectAreas.push({ x: x, y: y });
                totalArea += y * h;
            }
        }

        // Tracé du graphique
        var ctx = document.getElementById('densityChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: xValues,
                datasets: [
                    {
                        label: 'Densité de probabilité',
                        data: yValues,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1,
                        fill: false
                    },
                    {
                        label: 'Rectangles (aire approximée)',
                        data: rectAreas.map(r => r.y),
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        type: 'bar',
                        barPercentage: 1.0,
                        categoryPercentage: 1.0
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { title: { display: true, text: 'Valeurs de X' } },
                    y: { title: { display: true, text: 'Densité' } }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Courbe de densité et aire des rectangles sous la courbe'
                    }
                }
            }
        });

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
