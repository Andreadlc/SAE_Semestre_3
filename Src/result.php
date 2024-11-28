<?php if (isset($result) && isset($lambda) && isset($mean) && isset($std_dev) && isset($mu) && isset($t)): ?>
    <h2>Résultats</h2>
    <table>
        <tr>
            <th>Probabilité P(X ≤ t)</th>
            <th>λ</th>
            <th>X̄ (moyenne)</th>
            <th>σ (écart-type)</th>
        </tr>
        <tr>
            <td><?php echo number_format($result, 2); ?></td>
            <td><?php echo $lambda; ?></td>
            <td><?php echo $mean; ?></td>
            <td><?php echo number_format($std_dev, 2); ?></td>
        </tr>
    </table>
    <canvas id="densityChart" width="400" height="200"></canvas>

    <script>
        var ctx = document.getElementById('densityChart').getContext('2d');
        var xValues = [];
        var yValues = [];
        var mu = <?php echo $mu; ?>;
        var lambda = <?php echo $lambda; ?>;
        for (var x = 0.01; x <= <?php echo $t; ?>; x += 0.1) {
            xValues.push(x);
            var y = Math.sqrt(lambda / (2 * Math.PI * Math.pow(x, 3))) *
                Math.exp(-lambda * Math.pow(x - mu, 2) / (2 * Math.pow(mu, 2) * x));
            yValues.push(y);
        }

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: xValues,
                datasets: [{
                    label: 'Densité de probabilité',
                    data: yValues,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            }
        });
    </script>
<?php else: ?>
    <p>Veuillez soumettre le formulaire pour obtenir les résultats.</p>
<?php endif; ?>
