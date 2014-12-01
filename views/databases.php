

<div class='container'>

    <h3>Available databases:</h3><BR>

    <?php if ($dbs): ?>

        <table border='1' class='data'>
            <tr>
                <th>Database</th>
                <th>Tables</th>
                <th>Rows</th>
                <th>Data Size</th>
            </tr>

            <?php foreach ($dbs as $db => $details): ?>

                <tr>
                    <td><a href="?db=<?=$db?>"><?=$db?></a></td>
                    <td><?=$details['tables']?></td>
                    <td><?=$details['rows']?></td>
                    <td><?=Box::formatDataSize($details['data_size'])?></td>
                </tr>

            <?php endforeach ?>

        </table>


    <?php else: ?>

        This user has not access to any database or there are no databases on this server.

    <?php endif ?>

</div>

