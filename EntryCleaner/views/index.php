<style>
    table span:hover {
        cursor: default !important;
    }
</style>

<div>
    <h1>Cleaned Entries</h1>
    <table class="uk-table uk-table-middle uk-table-responsive">
        <thead class="uk-text-light uk-text-uppercase">
        <tr>
            <th>Collection Name</th>
            <th>Entry Id</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($entries as $entry) : ?>
            <tr>
                <td><?= $entry['collection'] ?></td>
                <td><?= $entry['entryId'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
