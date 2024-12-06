<?php if (isset($result) && isset($lambda) && isset($mean) && isset($std_dev) && isset($mu) && isset($t) && isset($n)) : ?>

    <!-- Section pour afficher la formule -->
    <br><br>
    <div style="text-align: center; margin: 20px;">
        <h3>Formule de la densité de probabilité (Loi inverse-gaussienne)</h3>
        <p id="mathFormula">$$f(x) = \sqrt{\frac{\lambda}{2 \pi x^3}} \cdot \exp\left(-\frac{\lambda (x - \mu)^2}{2 \mu^2 x}\right)$$</p>
    </div>

    <!-- Graphique de densité -->
    <div style="width: 80%; max-width: 800px; height: 400px; margin: auto;">
        <br><br>
        <canvas id="densityChart"></canvas>
    </div>

    <!-- Chargement de MathJax pour afficher la formule -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/3.2.2/es5/tex-mml-chtml.min.js"></script>

    <script>
        // Récupération des données depuis PHP
        const lambda = <?php echo json_encode($lambda); ?>;
        const mu = <?php echo json_encode($mu); ?>;
        const t = <?php echo json_encode($t); ?>;
        const n = <?php echo json_encode($n); ?>;
        const h = t / n; // Largeur des rectangles

        const xValues = [];
        const yValues = [];
        const rectAreas = [];
        let totalArea = 0;

        // Mise à jour de la formule avec les valeurs saisies par l'utilisateur
        document.getElementById('mathFormula').innerHTML = `$$f(x) = \\sqrt{\\frac{${lambda}}{2 \\pi x^3}} \\cdot \\exp\\left(-\\frac{${lambda} (x - ${mu})^2}{2 ${mu}^2 x}\\right)$$`;

        // Rechargement de MathJax pour afficher la formule mise à jour
        MathJax.typeset();

        // Calcul des points pour le graphique
        for (let i = 1; i <= n; i++) { // i commence à 1 pour éviter division par 0
            const x = i * h;
            xValues.push(x.toFixed(2)); // Ajout des x pour le graphique

            // Calcul de la densité pour chaque x
            const y = Math.sqrt(lambda / (2 * Math.PI * Math.pow(x, 3))) *
                Math.exp(-lambda * Math.pow(x - mu, 2) / (2 * Math.pow(mu, 2) * x));
            yValues.push(isNaN(y) || !isFinite(y) ? 0 : y);

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

    <br><br><br>
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