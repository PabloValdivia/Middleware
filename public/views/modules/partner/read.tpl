<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary">
                <h3 class="card-title text-capitalize">{$title}</h3>
                <h5 class="card-category">{$description}</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead class="text-primary">
                        <tr>
                        {foreach $thead as $column}
                            <th class="{if $column eq "iso"}text-uppercase{else}text-capitalize{/if}">{$column}</th>
                        {/foreach}
                        </tr>
                    </thead>
                    <tbody>
                    {foreach $data as $row}
                        <tr>
                        {foreach $row as $cell}
                            <td class="{if $cell@key === 'parent' }text-primary{/if}">{$cell}</td>
                        {/foreach}
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>