<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title text-capitalize">{$info.title} data {$table@key}</h4>
                <p class="card-category">{$info.description}</p>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead class="text-primary">
                        <tr>
                        {foreach $column as $cell}
                            <th class="{if $cell eq "id"}text-uppercase{else}text-capitalize{/if}">{$cell}</th>
                        {/foreach}
                        </tr>
                    </thead>
                    <tbody>
                    {foreach $data as $row}
                        <tr>
                        {foreach $row as $cell}
                            <td class="{if $cell@key === 'id' }text-primary{/if}">
                                {$cell}
                            </td>
                        {/foreach}
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>