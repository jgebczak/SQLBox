

<div class='container'>

    <?php if ($dbs): ?>

        <table border='1' class='data'>
            <tr>
                <th>Database</th>
                <th>Tables</th>
                <th>Data Size</th>
            </tr>

            <?php foreach ($dbs as $db): ?>

                <tr>
                    <td><?=$db?></td>
                    <td>?</td>
                    <td>?</td>
                </tr>

            <?php endforeach ?>

        </table>


    <?php else: ?>

        This user has not access to any database or there are no databases on this server.

    <?php endif ?>

</div>

