
<table>
    <thead>
        <tr>
            <th>Property</th>
            <th>Value</th>
        </tr>
    </thead>
    <tbody>
        {foreach $team as $key => $value}
            <tr>
                <td>{$key}</td>
                <td>{$value}</td>
            </tr>
        {/foreach}
    </tbody>
</table>